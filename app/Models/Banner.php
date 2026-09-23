<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Banner extends Model {
    protected $fillable=['title_en','title_ar','subtitle_en','subtitle_ar','image','link','button_text_en','button_text_ar','position','sort_order','is_active'];
    public function titleLocale():string{return app()->getLocale()==='ar'?($this->title_ar?:$this->title_en??''):($this->title_en??'');}
    public function subtitleLocale():string{return app()->getLocale()==='ar'?($this->subtitle_ar?:$this->subtitle_en??''):($this->subtitle_en??'');}
    public function btnLocale():string{return app()->getLocale()==='ar'?($this->button_text_ar?:'اكتشف الآن'):($this->button_text_en?:'Discover Now');}
}