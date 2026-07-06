<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\ShippingRate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $cart = $this->activeCart($request);
        $items = $cart->items()->with('product.category')->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $weight = $items->sum(fn ($item): int => $item->quantity * (int) $item->product->weight_gram);
        $shippingMethods = ShippingMethod::with(['rates' => fn ($query) => $query->orderBy('min_weight_gram')])->get();
        $paymentMethods = PaymentMethod::orderBy('method_name')->get();
        $shippingCost = $this->shippingCost((int) $shippingMethods->first()?->id_shipping_method, $weight);
        $subtotal = $items->sum(fn ($item): float => $item->quantity * (float) $item->product->price);

        return view('store.checkout.index', [
            'items' => $items,
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'total' => $subtotal + $shippingCost,
            'paymentMethods' => $paymentMethods,
            'shippingMethods' => $shippingMethods,
            'address' => $request->user()->addresses()->where('is_default', true)->first(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'recipient_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'province' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'detail_address' => ['required', 'string', 'max:1000'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'id_payment_method' => ['required', 'exists:payment_methods,id_payment_method'],
            'id_shipping_method' => ['required', 'exists:shipping_methods,id_shipping_method'],
        ]);

        $cart = $this->activeCart($request);
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        try {
            $order = DB::transaction(function () use ($request, $cart, $data): Order {
                $items = $cart->items;
                $products = Product::whereIn('id_product', $items->pluck('id_product'))
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id_product');

                foreach ($items as $item) {
                    $product = $products[$item->id_product] ?? null;
                    if (! $product || $product->status !== 'active' || $item->quantity > $product->stock) {
                        throw new \RuntimeException('Stok tidak mencukupi.');
                    }
                }

                Address::where('id_user', $request->user()->id_user)->update(['is_default' => false]);
                $address = Address::create([
                    'id_user' => $request->user()->id_user,
                    'recipient_name' => $data['recipient_name'],
                    'phone' => $data['phone'],
                    'province' => $data['province'],
                    'city' => $data['city'],
                    'district' => $data['district'],
                    'detail_address' => $data['detail_address'],
                    'postal_code' => $data['postal_code'] ?? null,
                    'is_default' => true,
                ]);

                $subtotal = 0;
                $weight = 0;

                foreach ($items as $item) {
                    $product = $products[$item->id_product];
                    $subtotal += $item->quantity * (float) $product->price;
                    $weight += $item->quantity * (int) $product->weight_gram;
                }

                $shippingCost = $this->shippingCost((int) $data['id_shipping_method'], $weight);
                if ($shippingCost < 0) {
                    throw new \RuntimeException('Tarif pengiriman tidak tersedia.');
                }

                $order = Order::create([
                    'id_user' => $request->user()->id_user,
                    'id_address' => $address->id_address,
                    'order_code' => $this->nextOrderCode(),
                    'subtotal' => $subtotal,
                    'shipping_cost' => $shippingCost,
                    'total_price' => $subtotal + $shippingCost,
                    'order_status' => 'waiting_payment',
                ]);

                foreach ($items as $item) {
                    $product = $products[$item->id_product];
                    $lineTotal = $item->quantity * (float) $product->price;
                    $order->items()->create([
                        'id_product' => $product->id_product,
                        'quantity' => $item->quantity,
                        'price_each' => $product->price,
                        'total_price' => $lineTotal,
                    ]);
                    $product->decrement('stock', $item->quantity);
                }

                $order->payment()->create([
                    'id_payment_method' => $data['id_payment_method'],
                    'payment_status' => 'unpaid',
                ]);
                $order->shipment()->create([
                    'id_shipping_method' => $data['id_shipping_method'],
                    'shipping_cost' => $shippingCost,
                    'shipment_status' => 'not_shipped',
                ]);

                $cart->items()->delete();
                $cart->update(['status' => 'checked_out']);

                return $order;
            });
        } catch (\RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan dibuat.');
    }

    private function activeCart(Request $request): Cart
    {
        return Cart::firstOrCreate([
            'id_user' => $request->user()->id_user,
            'status' => 'active',
        ]);
    }

    private function shippingCost(int $shippingMethodId, int $weight): float
    {
        if ($shippingMethodId < 1 || $weight < 1) {
            return -1;
        }

        $rate = ShippingRate::where('id_shipping_method', $shippingMethodId)
            ->where('min_weight_gram', '<=', $weight)
            ->where('max_weight_gram', '>=', $weight)
            ->orderBy('min_weight_gram')
            ->first();

        return $rate ? (float) $rate->base_cost : -1;
    }

    private function nextOrderCode(): string
    {
        do {
            $code = sprintf('%s-%s-%s', config('app.order_code_prefix', env('ORDER_CODE_PREFIX', 'OVV')), now()->format('ymd'), Str::upper(Str::random(5)));
        } while (Order::where('order_code', $code)->exists());

        return $code;
    }
}
