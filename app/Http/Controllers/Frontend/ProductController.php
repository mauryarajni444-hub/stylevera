<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\{Product, Setting};

class ProductController extends Controller {
    public function show(string $slug) {
        $product = Product::with([
            'category',
            'variants' => fn($q) => $q->where('is_active',1)->with('media'),
            'reviews'  => fn($q) => $q->where('is_approved',1)->orderByDesc('created_at'),
        ])->where('slug',$slug)->where('is_active',1)->firstOrFail();
        $product->increment('views');

        $related = Product::with(['variants' => fn($q) => $q->limit(1)->with('media')])
            ->where('category_id',$product->category_id)
            ->where('id','!=',$product->id)
            ->where('is_active',1)->take(6)->get();

        return view('frontend.product', [
            'product'  => $product,
            'related'  => $related,
            'settings' => Setting::all()->pluck('value','key'),
        ]);
    }
}
