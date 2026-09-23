<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
class AdminBannerController extends Controller {
    public function index(){return view('admin.banners.index',['banners'=>Banner::orderBy('sort_order')->paginate(20)]);}
    public function store(Request $r){$r->validate(['image'=>'required']);Banner::create($r->except('_token'));return back()->with('success','Banner added!');}
    public function destroy(Banner $b){$b->delete();return back()->with('success','Deleted.');}
}