<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AdminUserController extends Controller {
    public function index(){return view('admin.users.index',['users'=>User::whereIn('role',['admin','master_admin'])->orderByDesc('created_at')->paginate(20)]);}
    public function store(Request $r){
        $r->validate(['name'=>'required','email'=>'required|email|unique:users','password'=>'required|min:8','role'=>'required|in:admin,master_admin']);
        User::create(['name'=>$r->name,'email'=>$r->email,'password'=>Hash::make($r->password),'role'=>$r->role,'is_active'=>1,'created_by'=>auth()->id()]);
        return back()->with('success','Admin user created!');
    }
    public function update(Request $r,User $user){
        $data=$r->only('name','role','is_active');
        if($r->filled('password'))$data['password']=Hash::make($r->password);
        $user->update($data);
        return back()->with('success','User updated!');
    }
    public function destroy(User $user){$user->delete();return back()->with('success','Deleted.');}
}