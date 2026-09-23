<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Product,Order,User,Category};
class AdminDashboardController extends Controller {
    public function index(){
        $stats=[
            'total_orders'=>Order::count(),
            'pending_orders'=>Order::where('status','pending')->count(),
            'total_revenue'=>Order::whereIn('status',['confirmed','delivered'])->sum('total'),
            'today_revenue'=>Order::whereIn('status',['confirmed','delivered'])->whereDate('created_at',today())->sum('total'),
            'total_products'=>Product::where('is_active',1)->count(),
            'total_customers'=>User::where('role','user')->count(),
            'low_stock'=>\App\Models\ProductVariant::where('stock','<',5)->count(),
            'pending_reviews'=>\App\Models\Review::where('is_approved',0)->count(),
        ];
        $recentOrders=Order::orderByDesc('created_at')->take(8)->get();
        $topProducts=Product::orderByDesc('views')->take(5)->get();
        $chartData=collect(range(6,0))->map(fn($d)=>['date'=>now()->subDays($d)->format('d M'),'revenue'=>Order::whereIn('status',['confirmed','delivered'])->whereDate('created_at',now()->subDays($d))->sum('total')]);
        return view('admin.dashboard',compact('stats','recentOrders','topProducts','chartData'));
    }
}