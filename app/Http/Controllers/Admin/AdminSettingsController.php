<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
class AdminSettingsController extends Controller {
    public function index(){return view('admin.settings.index',['settings'=>Setting::all()->pluck('value','key')]);}
    public function update(Request $r){
        foreach($r->settings??[] as $key=>$value){
            $group=explode('.',$key)[0];
            Setting::updateOrCreate(['key'=>$key],['value'=>$value,'group'=>$group]);
        }
        return back()->with('success','Settings saved!');
    }
}