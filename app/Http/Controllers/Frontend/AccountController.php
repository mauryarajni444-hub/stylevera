<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,Hash};
use App\Models\{User,Order};
class AccountController extends Controller {
    public function showLogin(){return view('frontend.login');}
    public function showRegister(){return view('frontend.register');}
    public function login(Request $r){
        $r->validate(['email'=>'required|email','password'=>'required']);
        if(Auth::attempt($r->only('email','password'),$r->boolean('remember'))){
            $r->session()->regenerate();
            return redirect()->intended(route('home'));
        }
        return back()->with('error','Invalid credentials.')->withInput($r->only('email'));
    }
    public function register(Request $r){
        $r->validate(['name'=>'required','email'=>'required|email|unique:users','password'=>'required|min:8|confirmed']);
        Auth::login(User::create(['name'=>$r->name,'email'=>$r->email,'password'=>Hash::make($r->password),'role'=>'user','is_active'=>1]));
        return redirect()->route('home');
    }
    public function logout(Request $r){Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect()->route('home');}
    public function index(){return view('frontend.account',['user'=>Auth::user()]);}
    public function orders(){return view('frontend.account-orders',['orders'=>Order::where('user_id',Auth::id())->orderByDesc('created_at')->paginate(10)]);}
    public function orderDetail(string $ref){$order=Order::with('items')->where('ref_number',$ref)->where('user_id',Auth::id())->firstOrFail();return view('frontend.account-order',['order'=>$order]);}
}