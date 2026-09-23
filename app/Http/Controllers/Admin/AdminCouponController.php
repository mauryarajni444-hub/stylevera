<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
class AdminCouponController extends Controller {
    public function index(){return view('admin.coupons.index',['coupons'=>Coupon::orderByDesc('created_at')->paginate(20)]);}
    public function store(Request $r){
        $r->validate(['code'=>'required|unique:coupons','type'=>'required','value'=>'required|numeric']);
        Coupon::create($r->except('_token'));
        return back()->with('success','Coupon created!');
    }
    public function destroy(Coupon $c){$c->delete();return back()->with('success','Deleted.');}
}