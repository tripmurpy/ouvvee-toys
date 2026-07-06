<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function create(Request $request, Product $product): View
    {
        $order = $this->reviewableOrder($request, $product);
        abort_unless($order, 403);

        return view('store.reviews.create', [
            'product' => $product,
            'order' => $order,
        ]);
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $order = $this->reviewableOrder($request, $product);
        abort_unless($order, 403);

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $product->reviews()->updateOrCreate(
            [
                'id_user' => $request->user()->id_user,
                'id_order' => $order->id_order,
            ],
            [
                'rating' => $data['rating'],
                'comment' => $data['comment'] ?? null,
            ]
        );

        return redirect()->route('products.show', $product)->with('success', 'Review dikirim.');
    }

    private function reviewableOrder(Request $request, Product $product): ?Order
    {
        return $request->user()
            ->orders()
            ->whereIn('order_status', [Order::STATUS_PAID, Order::STATUS_PROCESSING, Order::STATUS_SHIPPED, Order::STATUS_COMPLETED])
            ->whereHas('items', fn ($query) => $query->where('id_product', $product->id_product))
            ->latest('order_date')
            ->first();
    }
}
