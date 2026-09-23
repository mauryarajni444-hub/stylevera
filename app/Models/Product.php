<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = ['category_id','name_en','name_ar','slug','short_desc_en','short_desc_ar','description_en','description_ar','base_price','sale_price','sku','cover_image','gender','is_featured','is_new_arrival','is_best_seller','is_active','sort_order','views','rating','reviews_count','created_by'];
    protected $casts = ['base_price'=>'float','sale_price'=>'float','is_featured'=>'boolean','is_new_arrival'=>'boolean','is_best_seller'=>'boolean','is_active'=>'boolean'];

    public function category() { return $this->belongsTo(Category::class); }
    public function variants() { return $this->hasMany(ProductVariant::class)->orderBy('sort_order'); }
    public function defaultVariant() { return $this->hasOne(ProductVariant::class)->where('is_default',1); }
    public function reviews() { return $this->hasMany(Review::class); }

    public function nameLocale(): string { return app()->getLocale()==='ar' ? ($this->name_ar ?: $this->name_en) : $this->name_en; }
    public function descLocale(): string { return app()->getLocale()==='ar' ? ($this->short_desc_ar ?: $this->short_desc_en ?? '') : ($this->short_desc_en ?? ''); }

    // Return S3 URL or null (never local paths)
    public function getCoverImage(): ?string {
        if ($this->cover_image && str_starts_with($this->cover_image, 'http')) return $this->cover_image;
        return null; // no local fallback - use placeholder.svg in blade
    }

    public function getDisplayPrice(): array {
        $v = $this->defaultVariant ?? $this->variants()->first();
        if ($v) return ['price' => $v->price, 'sale' => $v->sale_price];
        return ['price' => $this->base_price, 'sale' => $this->sale_price];
    }

    // Get all media across all variants (S3 only)
    public function getAllMedia() {
        $media = collect();
        foreach ($this->variants as $v) {
            foreach ($v->media as $m) {
                $media->push($m);
            }
        }
        return $media;
    }

    public function getPrimaryImage(): ?string {
        $all = $this->getAllMedia();
        $primary = $all->where('type','image')->where('is_primary',1)->first();
        if (!$primary) $primary = $all->where('type','image')->first();
        return $primary?->url;
    }
}
