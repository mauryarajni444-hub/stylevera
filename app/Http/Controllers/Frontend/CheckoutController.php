<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{Cart,Order,OrderItem,Setting};
use Illuminate\Support\Facades\{Auth,Session};
class CheckoutController extends Controller {
    private function getCart(){
        if(Auth::check())return Cart::where('user_id',Auth::id())->first();
        $sid=Session::get('cart_session');
        return $sid?Cart::where('session_id',$sid)->first():null;
    }
    public function show(){
        $cart=$this->getCart();
        if(!$cart||$cart->count()===0)return redirect()->route('home');
        $cart->load(['items.product','items.variant']);
        return view('frontend.checkout',['cart'=>$cart,'settings'=>Setting::all()->pluck('value','key')]);
    }
    public function store(Request $r){
        $r->validate(['name'=>'required','email'=>'required|email','phone'=>'required','address'=>'required','city'=>'required']);
        $cart=$this->getCart();
        if(!$cart||$cart->count()===0)return redirect()->route('home');
        $cart->load(['items.product','items.variant']);
        $subtotal=$cart->total();
        $fee=floatval(Setting::get('general.shipping_fee','30.00'));
        $free=floatval(Setting::get('general.free_shipping_above','500.00'));
        if($subtotal>=$free)$fee=0;
        $disc=floatval(Session::get('coupon_discount',0));
        $total=max(0,$subtotal+$fee-$disc);
        $ref='SV-'.date('Y').'-'.strtoupper(Str::random(6));
        $order=Order::create(['ref_number'=>$ref,'user_id'=>Auth::id(),'guest_name'=>$r->name,'guest_email'=>$r->email,'guest_phone'=>$r->phone,'shipping_address'=>$r->address,'shipping_city'=>$r->city,'shipping_country'=>$r->country??'UAE','subtotal'=>$subtotal,'shipping_fee'=>$fee,'discount'=>$disc,'total'=>$total,'coupon_code'=>Session::get('coupon_code'),'payment_method'=>$r->payment??'cod','notes'=>$r->notes]);
        foreach($cart->items as $item){
            OrderItem::create(['order_id'=>$order->id,'product_id'=>$item->product_id,'variant_id'=>$item->variant_id,'product_name'=>$item->product->name_en,'variant_name'=>$item->variant?->name_en,'quantity'=>$item->quantity,'price'=>$item->price,'total'=>$item->price*$item->quantity]);
        }
        $cart->items()->delete();$cart->delete();
        Session::forget(['cart_session','coupon_code','coupon_discount']);
        return redirect()->route('order.confirm',$ref);
    }
    public function confirm(string $ref){
        $order=Order::with('items')->where('ref_number',$ref)->firstOrFail();
        return view('frontend.order-confirm',['order'=>$order]);
    }
}
