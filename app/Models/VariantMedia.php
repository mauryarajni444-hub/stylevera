<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class VariantMedia extends Model {
    protected $fillable=['variant_id','type','url','thumbnail','is_primary','sort_order','file_size'];
    protected $casts=['is_primary'=>'boolean'];
}