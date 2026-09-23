<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\{Product, Category, Banner, Setting};

class HomeController extends Controller {
    public function index() {
        $with = ['variants' => fn($q) => $q->where('is_active',1)->with('media'), 'category'];

        return view('frontend.home', [
            'banners'      => Banner::where('position','hero')->where('is_active',1)->orderBy('sort_order')->get(),
            'featuredCats' => Category::where('is_featured',1)->where('is_active',1)->orderBy('sort_order')->take(3)->get(),
            'newArrivals'  => Product::with($with)->where('is_new_arrival',1)->where('is_active',1)->orderBy('sort_order')->take(10)->get(),
            'bestSellers'  => Product::with($with)->where('is_best_seller',1)->where('is_active',1)->orderBy('sort_order')->take(10)->get(),
            'settings'     => Setting::all()->pluck('value','key'),
        ]);
    }
}
