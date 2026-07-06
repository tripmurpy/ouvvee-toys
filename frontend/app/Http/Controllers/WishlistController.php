<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        return view('store.wishlist.index', [
            'products' => $request->user()
                ->wishlists()
                ->active()
                ->with('category')
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->orderBy('product_name')
                ->get(),
        ]);
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->status === 'active', 404);
        $request->user()->wishlists()->syncWithoutDetaching([$product->id_product]);

        return back()->with('success', 'Produk disimpan ke wishlist.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $request->user()->wishlists()->detach($product->id_product);

        return back()->with('success', 'Produk dihapus dari wishlist.');
    }
}
