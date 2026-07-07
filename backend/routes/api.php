<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/products', function (Request $request) {
    $query = Product::active()->with('category');

    if ($search = trim((string) $request->query('q'))) {
        $query->where(fn ($builder) => $builder
            ->where('product_name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%"));
    }

    $products = $query->orderBy('product_name')->paginate(12)->withQueryString();

    return response()->json([
        'data' => $products->getCollection()->map(function (Product $product): array {
            $imagePath = $product->displayImagePath();

            return [
                'slug' => $product->slug,
                'name' => $product->product_name,
                'category' => optional($product->category)->category_name,
                'price' => (float) $product->price,
                'stock' => (int) $product->stock,
                'description' => $product->description,
                'image_url' => $imagePath ? asset($imagePath) : null,
                'product_url' => route('products.show', $product),
            ];
        })->values(),
        'meta' => [
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'per_page' => $products->perPage(),
            'total' => $products->total(),
        ],
    ]);
});
