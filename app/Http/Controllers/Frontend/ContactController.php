<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Contact,Subscriber,Setting};
class ContactController extends Controller {
    public function show(){return view('frontend.contact',['settings'=>Setting::all()->pluck('value','key')]);}
    public function store(Request $r){
        $r->validate(['name'=>'required','email'=>'required|email','message'=>'required']);
        Contact::create($r->only('name','email','subject','message'));
        $msg=session('locale')=='ar'?'شكراً! سنتواصل معك قريباً.':'Thank you! We will be in touch.';
        return back()->with('success',$msg);
    }
    public function newsletter(Request $r){
        $r->validate(['email'=>'required|email']);
        Subscriber::firstOrCreate(['email'=>$r->email],['created_at'=>now()]);
        $msg=session('locale')=='ar'?'تم الاشتراك بنجاح!':'Subscribed successfully!';
        return response()->json(['success'=>true,'message'=>$msg]);
    }
}