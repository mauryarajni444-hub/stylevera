<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class StyleveraAuth {
    const LEVELS=['user'=>1,'admin'=>2,'master_admin'=>3];
    public function handle(Request $request,Closure $next,string $min='admin'){
        if(!Auth::check())return redirect()->route('admin.login');
        $ul=self::LEVELS[Auth::user()->role]??0;
        $ml=self::LEVELS[$min]??2;
        if($ul<$ml)abort(403);
        if(!Auth::user()->is_active){Auth::logout();return redirect()->route('admin.login')->with('error','Account disabled.');}
        return $next($request);
    }
}