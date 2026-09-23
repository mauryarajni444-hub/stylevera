<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Page extends Model {
    protected $fillable=['title_en','title_ar','slug','content_en','content_ar','is_active'];
    public function titleLocale():string{return app()->getLocale()==='ar'?($this->title_ar?:$this->title_en):$this->title_en;}
    public function contentLocale():string{return app()->getLocale()==='ar'?($this->content_ar?:$this->content_en??''):($this->content_en??'');}
}