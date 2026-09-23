<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProductVariant extends Model {
    protected $fillable=['product_id','name_en','name_ar','color','color_hex','size','material','sku','price','sale_price','stock','is_default','is_active','sort_order'];
    protected $casts=['price'=>'float','sale_price'=>'float','is_default'=>'boolean','is_active'=>'boolean'];
    public function product(){return $this->belongsTo(Product::class);}
    public function media(){return $this->hasMany(VariantMedia::class,'variant_id')->orderBy('sort_order');}
    public function primaryMedia(){return $this->hasOne(VariantMedia::class,'variant_id')->where('is_primary',1);}
    public function nameLocale():string{return app()->getLocale()==='ar'?($this->name_ar?:$this->name_en):$this->name_en;}
}