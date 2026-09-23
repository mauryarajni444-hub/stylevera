<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Category extends Model {
    protected $fillable=['name_en','name_ar','slug','description_en','description_ar','image','parent_id','sort_order','is_active','is_featured'];
    public function products(){return $this->hasMany(Product::class);}
    public function nameLocale():string{return app()->getLocale()==='ar'?($this->name_ar?:$this->name_en):$this->name_en;}
}