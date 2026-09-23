<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminAuthController extends Controller {
    public function showLogin(){return view('admin.login');}
    public function login(Request $r){
        $r->validate(['email'=>'required|email','password'=>'required']);
        if(Auth::attempt($r->only('email','password'),$r->boolean('remember'))){
            if(!Auth::user()->isAdmin()){Auth::logout();return back()->with('error','Access denied.');}
            $r->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        return back()->with('error','Invalid credentials.')->withInput($r->only('email'));
    }
    public function logout(Request $r){
        Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}