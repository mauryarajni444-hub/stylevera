<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Cart,CartItem,Product,ProductVariant,Coupon};
use Illuminate\Support\Facades\{Auth,Session};
class CartController extends Controller {
    private function getCart(){
        if(Auth::check())return Cart::firstOrCreate(['user_id'=>Auth::id()]);
        $sid=Session::get('cart_session');
        if(!$sid){$sid=uniqid('sv_');Session::put('cart_session',$sid);}
        return Cart::firstOrCreate(['session_id'=>$sid]);
    }
    public function count(){$c=$this->getCart();return response()->json(['count'=>$c->items()->sum('quantity')]);}
    public function add(Request $r){
        $r->validate(['product_id'=>'required|exists:products,id']);
        $product=Product::findOrFail($r->product_id);
        $variant=$r->variant_id?ProductVariant::find($r->variant_id):$product->variants()->first();
        $price=$variant?($variant->sale_price??$variant->price):($product->sale_price??$product->base_price);
        $cart=$this->getCart();
        $item=$cart->items()->where('product_id',$r->product_id)->where('variant_id',$r->variant_id)->first();
        if($item)$item->increment('quantity',$r->quantity??1);
        else $cart->items()->create(['product_id'=>$r->product_id,'variant_id'=>$r->variant_id??null,'quantity'=>$r->quantity??1,'price'=>$price]);
        $msg=session('locale')==='ar'?'تمت الإضافة إلى السلة!':'Added to cart!';
        return response()->json(['success'=>true,'message'=>$msg,'count'=>$cart->items()->sum('quantity')]);
    }
    public function items(){
        $cart=$this->getCart();$cart->load(['items.product','items.variant.media']);
        $html=view('frontend.partials.cart-items',['items'=>$cart->items])->render();
        return response()->json(['html'=>$html,'total'=>number_format($cart->total(),2).' AED','count'=>$cart->count()]);
    }
    public function update(Request $r){
        $item=CartItem::findOrFail($r->item_id);
        if($r->action==='inc')$item->increment('quantity');
        elseif($r->action==='dec'){if($item->quantity>1)$item->decrement('quantity');else $item->delete();}
        $cart=$this->getCart();$cart->load(['items.product','items.variant.media']);
        return response()->json(['success'=>true,'html'=>view('frontend.partials.cart-items',['items'=>$cart->items])->render(),'total'=>number_format($cart->total(),2).' AED','count'=>$cart->count()]);
    }
    public function remove(Request $r){CartItem::findOrFail($r->item_id)->delete();return $this->items();}
    public function coupon(Request $r){
        $c=Coupon::where('code',strtoupper($r->code))->first();
        if(!$c||!$c->isValid())return response()->json(['success'=>false,'message'=>'Invalid coupon code.']);
        $cart=$this->getCart();$total=$cart->total();
        if($total<$c->min_order)return response()->json(['success'=>false,'message'=>'Minimum order: '.number_format($c->min_order,2).' AED']);
        $disc=$c->calculateDiscount($total);
        Session::put('coupon_code',$c->code);Session::put('coupon_discount',$disc);
        return response()->json(['success'=>true,'message'=>'Coupon applied!','discount'=>number_format($disc,2).' AED','new_total'=>number_format($total-$disc,2).' AED']);
    }
}