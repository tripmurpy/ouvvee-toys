<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::active()
            ->with('category')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        if ($search = trim((string) $request->query('q'))) {
            $query->where(fn ($builder) => $builder
                ->where('product_name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"));
        }

        return view('store.products.index', [
            'products' => $query->orderBy('product_name')->paginate(12)->withQueryString(),
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->status === 'active', 404);

        return view('store.products.show', [
            'product' => $product->load(['category', 'images', 'reviews.user'])->loadCount('reviews')->loadAvg('reviews', 'rating'),
        ]);
    }
}
