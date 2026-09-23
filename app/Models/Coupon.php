<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Coupon extends Model {
    protected $fillable=['code','type','value','min_order','max_uses','used_count','expires_at','is_active'];
    protected $casts=['value'=>'float','min_order'=>'float','expires_at'=>'date','is_active'=>'boolean'];
    public function isValid():bool{
        if(!$this->is_active)return false;
        if($this->expires_at&&$this->expires_at->isPast())return false;
        if($this->max_uses&&$this->used_count>=$this->max_uses)return false;
        return true;
    }
    public function calculateDiscount(float $total):float{
        if($this->type==='percent')return round($total*$this->value/100,2);
        return min($this->value,$total);
    }
}