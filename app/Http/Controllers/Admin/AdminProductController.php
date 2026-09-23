<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{Product,ProductVariant,Category};
class AdminProductController extends Controller {
    public function index(){return view('admin.products.index',['products'=>Product::with('category')->withCount('variants')->orderByDesc('created_at')->paginate(20)]);}
    public function create(){return view('admin.products.create',['categories'=>Category::where('is_active',1)->orderBy('sort_order')->get()]);}
    public function store(Request $r){
        $r->validate(['name_en'=>'required','base_price'=>'required|numeric']);
        $data=$r->except('_token');
        $data['slug']=Str::slug($r->name_en).'-'.Str::random(5);
        $data['created_by']=auth()->id();
        foreach(['is_featured','is_new_arrival','is_best_seller','is_active'] as $b)$data[$b]=$r->boolean($b);
        $product=Product::create($data);
        return redirect()->route('admin.products.edit',$product->id)->with('success','Product created! Now add variants.');
    }
    public function edit(Product $product){
        $product->load(['variants.media','category']);
        return view('admin.products.edit',['product'=>$product,'categories'=>Category::where('is_active',1)->orderBy('sort_order')->get()]);
    }
    public function update(Request $r,Product $product){
        $r->validate(['name_en'=>'required']);
        $data=$r->except('_token','_method');
        foreach(['is_featured','is_new_arrival','is_best_seller','is_active'] as $b)$data[$b]=$r->boolean($b);
        $product->update($data);
        return back()->with('success','Product updated!');
    }
    public function destroy(Product $product){$product->delete();return redirect()->route('admin.products.index')->with('success','Deleted.');}
    public function storeVariant(Request $r,Product $product){
        $r->validate(['name_en'=>'required','price'=>'required|numeric']);
        $data=$r->except('_token');
        $data['is_default']=$r->boolean('is_default');
        $data['is_active']=1;
        if($data['is_default'])ProductVariant::where('product_id',$product->id)->update(['is_default'=>0]);
        ProductVariant::create($data+['product_id'=>$product->id]);
        return back()->with('success','Variant added!');
    }
    public function updateVariant(Request $r,ProductVariant $variant){
        $data=$r->except('_token','_method');
        $data['is_default']=$r->boolean('is_default');
        if($data['is_default'])ProductVariant::where('product_id',$variant->product_id)->where('id','!=',$variant->id)->update(['is_default'=>0]);
        $variant->update($data);
        if($r->wantsJson()||$r->ajax())return response()->json(['success'=>true,'message'=>'Variant updated!']);
        return back()->with('success','Variant updated!');
    }
    public function editVariant(ProductVariant $variant){
        return response()->json(['success'=>true,'variant'=>$variant]);
    }
        public function destroyVariant(ProductVariant $variant){$variant->delete();return back()->with('success','Variant deleted.');}
}