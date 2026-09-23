<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Page;
class PageController extends Controller {
    public function show(string $slug){
        $page=Page::where('slug',$slug)->where('is_active',1)->firstOrFail();
        return view('frontend.page',compact('page'));
    }
}