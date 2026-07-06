<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        return view('store.orders.index', [
            'orders' => $request->user()
                ->orders()
                ->with(['payment.method', 'shipment.method'])
                ->latest('order_date')
                ->get(),
        ]);
    }

    public function show(Request $request, Order $order): View
    {
        abort_unless($order->id_user === $request->user()->id_user || $request->user()->role === 'admin', 403);

        return view('store.orders.show', [
            'order' => $order->load(['items.product.category', 'payment.method', 'shipment.method']),
        ]);
    }

    public function pay(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->id_user === $request->user()->id_user, 403);
        $order->load('payment');

        if ($order->payment->payment_status !== 'unpaid') {
            return back()->with('error', 'Pesanan ini sudah diproses.');
        }

        DB::transaction(function () use ($order): void {
            $order->payment()->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);
            $order->update(['order_status' => 'processing']);
        });

        return back()->with('success', 'Pembayaran simulasi berhasil.');
    }
}
