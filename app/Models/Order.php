<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model {
    protected $fillable=['ref_number','user_id','guest_name','guest_email','guest_phone','shipping_address','shipping_city','shipping_country','subtotal','shipping_fee','discount','total','currency','coupon_code','payment_method','payment_status','status','notes','admin_notes'];
    protected $casts=['subtotal'=>'float','shipping_fee'=>'float','discount'=>'float','total'=>'float'];
    public function items(){return $this->hasMany(OrderItem::class);}
    public function user(){return $this->belongsTo(User::class);}
}