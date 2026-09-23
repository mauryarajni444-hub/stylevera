<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Wishlist extends Model {
    public $timestamps=false;
    protected $fillable=['user_id','session_id','product_id','created_at'];
    protected $casts=['created_at'=>'datetime'];
    public function product(){return $this->belongsTo(Product::class);}
}