<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $lowStockThreshold = (int) config('app.low_stock_threshold', 5);

        return view('admin.dashboard', [
            'salesTotal' => Order::whereNotIn('order_status', [Order::STATUS_CANCELLED])->sum('total_price'),
            'orderCount' => Order::count(),
            'lowStockCount' => Product::active()->where('stock', '<=', $lowStockThreshold)->count(),
            'reviewAverage' => round((float) Review::avg('rating'), 1),
            'lowStockProducts' => Product::active()
                ->with('category')
                ->where('stock', '<=', $lowStockThreshold)
                ->orderBy('stock')
                ->limit(8)
                ->get(),
            'recentOrders' => Order::with('user')->latest('order_date')->limit(8)->get(),
        ]);
    }
}
