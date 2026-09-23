<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Contact;
class AdminContactController extends Controller {
    public function index(){return view('admin.contacts.index',['contacts'=>Contact::orderByDesc('created_at')->paginate(30)]);}
    public function markRead(Contact $c){$c->update(['is_read'=>1]);return back();}
    public function destroy(Contact $c){$c->delete();return back()->with('success','Deleted.');}
}