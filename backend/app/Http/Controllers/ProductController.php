<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        return $this->catalog($request);
    }

    public function category(Request $request, Category $category): View
    {
        return $this->catalog($request, $category);
    }

    private function catalog(Request $request, ?Category $category = null): View
    {
        $query = Product::active()
            ->with('category')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        if ($category) {
            $query->where('id_category', $category->id_category);
        }

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
        abort_unless($product->status === Product::STATUS_ACTIVE, 404);

        return view('store.products.show', [
            'product' => $product->load(['category', 'images', 'reviews.user'])->loadCount('reviews')->loadAvg('reviews', 'rating'),
        ]);
    }
}
