<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $this->activeCart($request);
        $items = $cart->items()->with('product.category')->get();

        return view('store.cart.index', [
            'cart' => $cart,
            'items' => $items,
            'subtotal' => $items->sum(fn (CartItem $item): float => $item->quantity * (float) $item->product->price),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id_product' => ['required', 'exists:products,id_product'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::active()->findOrFail($data['id_product']);
        $cart = $this->activeCart($request);
        $item = $cart->items()->firstOrNew(['id_product' => $product->id_product]);
        $nextQuantity = (int) $item->quantity + (int) $data['quantity'];

        if ($nextQuantity > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $item->quantity = $nextQuantity;
        $item->save();

        return redirect()->route('cart.index')->with('success', 'Produk masuk keranjang.');
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->authorizeCartItem($request, $cartItem);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cartItem->load('product');

        if ($cartItem->product->status !== Product::STATUS_ACTIVE) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        if ((int) $data['quantity'] > $cartItem->product->stock) {
            return back()->with('error', 'Jumlah melebihi stok tersedia.');
        }

        $cartItem->update(['quantity' => $data['quantity']]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->authorizeCartItem($request, $cartItem);
        $cartItem->delete();

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    private function activeCart(Request $request): Cart
    {
        return Cart::firstOrCreate([
            'id_user' => $request->user()->id_user,
            'status' => Cart::STATUS_ACTIVE,
        ]);
    }

    private function authorizeCartItem(Request $request, CartItem $cartItem): void
    {
        abort_unless(
            $cartItem->cart()->where('id_user', $request->user()->id_user)->where('status', Cart::STATUS_ACTIVE)->exists(),
            403
        );
    }
}
