<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function home(): View
    {
        return view('store.home', [
            'featured' => Product::active()
                ->with('category')
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->latest('id_product')
                ->limit(9)
                ->get(),
        ]);
    }
}
