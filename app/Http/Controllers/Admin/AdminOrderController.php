<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
class AdminOrderController extends Controller {
    public function index(Request $r){
        $q=Order::orderByDesc('created_at');
        if($r->search)$q->where(fn($x)=>$x->where('ref_number','like',"%{$r->search}%")->orWhere('guest_email','like',"%{$r->search}%"));
        if($r->status)$q->where('status',$r->status);
        return view('admin.orders.index',['orders'=>$q->paginate(20)]);
    }
    public function show(Order $order){$order->load('items');return view('admin.orders.show',compact('order'));}
    public function updateStatus(Request $r,Order $order){$order->update(['status'=>$r->status,'admin_notes'=>$r->admin_notes]);return back()->with('success','Status updated!');}
    public function destroy(Order $order){$order->delete();return redirect()->route('admin.orders.index')->with('success','Deleted.');}
}