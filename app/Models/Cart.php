<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Cart extends Model {
    protected $fillable=['user_id','session_id'];
    public function items(){return $this->hasMany(CartItem::class);}
    public function total():float{return $this->items->sum(fn($i)=>$i->price*$i->quantity);}
    public function count():int{return $this->items->sum('quantity');}
}