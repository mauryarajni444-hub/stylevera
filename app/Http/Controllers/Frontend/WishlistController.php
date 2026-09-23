<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\{Auth,Session};
class WishlistController extends Controller {
    private function sid(){
        if(Auth::check())return null;
        $s=Session::get('wl_session');
        if(!$s){$s=uniqid('wl_');Session::put('wl_session',$s);}
        return $s;
    }
    public function index(){
        $q=Wishlist::with(['product.defaultVariant.media']);
        if(Auth::check())$q->where('user_id',Auth::id());
        else $q->where('session_id',$this->sid());
        return view('frontend.wishlist',['items'=>$q->get()]);
    }
    public function toggle(Request $r){
        $cond=Auth::check()?['user_id'=>Auth::id()]:['session_id'=>$this->sid()];
        $cond['product_id']=$r->product_id;
        $ex=Wishlist::where($cond)->first();
        if($ex){$ex->delete();$wishlisted=false;}
        else{Wishlist::create($cond+['created_at'=>now()]);$wishlisted=true;}
        $base=Auth::check()?['user_id'=>Auth::id()]:['session_id'=>$this->sid()];
        return response()->json(['wishlisted'=>$wishlisted,'count'=>Wishlist::where($base)->count()]);
    }
}