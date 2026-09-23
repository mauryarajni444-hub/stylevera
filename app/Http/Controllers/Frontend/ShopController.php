<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Product, Category, Setting};

class ShopController extends Controller {
    public function index(Request $r) {
        $with = ['category', 'variants' => fn($q) => $q->where('is_active',1)->with('media')];
        $q = Product::with($with)->where('is_active',1);
        if ($r->cat)    $q->whereHas('category', fn($x) => $x->where('slug',$r->cat));
        if ($r->gender) $q->where('gender',$r->gender);
        if ($r->search) $q->where(fn($x) => $x->where('name_en','like',"%{$r->search}%")->orWhere('name_ar','like',"%{$r->search}%"));
        if ($r->min_price) $q->where('base_price','>=',$r->min_price);
        if ($r->max_price) $q->where('base_price','<=',$r->max_price);
        match($r->sort ?? '') {
            'price_asc'  => $q->orderBy('base_price'),
            'price_desc' => $q->orderByDesc('base_price'),
            'newest'     => $q->orderByDesc('created_at'),
            default      => $q->orderBy('sort_order'),
        };
        return view('frontend.shop', [
            'products'   => $q->paginate(12)->withQueryString(),
            'categories' => Category::where('is_active',1)->withCount('products')->orderBy('sort_order')->get(),
            'settings'   => Setting::all()->pluck('value','key'),
        ]);
    }
}
