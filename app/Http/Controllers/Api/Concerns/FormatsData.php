<?php
namespace App\Http\Controllers\Api\Concerns;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

trait FormatsData
{
    protected function fmtCategory(Category $c): array
    {
        return [
            'id' => $c->id,
            'name' => $c->nameLocale(),
            'slug' => $c->slug,
            'image' => $c->image,
            'is_featured' => (bool) $c->is_featured,
            'products_count' => $c->products_count ?? null,
        ];
    }

    protected function fmtVariant($v): array
    {
        return [
            'id' => $v->id,
            'name' => $v->nameLocale(),
            'color' => $v->color,
            'color_hex' => $v->color_hex,
            'size' => $v->size,
            'material' => $v->material,
            'price' => (float) $v->price,
            'sale_price' => $v->sale_price ? (float) $v->sale_price : null,
            'stock' => (int) $v->stock,
            'is_default' => (bool) $v->is_default,
            'media' => $v->media->map(fn($m) => [
                'id' => $m->id,
                'type' => $m->type,
                'url' => $m->url,
                'thumbnail' => $m->thumbnail ?: $m->url,
                'is_primary' => (bool) $m->is_primary,
            ])->values(),
        ];
    }

    protected function fmtProduct(Product $p, bool $detailed = false): array
    {
        $variants = $p->variants ?? collect();
        $default = $variants->firstWhere('is_default', 1) ?? $variants->first();

        $allMedia = $variants->flatMap(fn($v) => $v->media);
        $primary = $allMedia->firstWhere('is_primary', 1) ?? $allMedia->first();

        $price = $default->price ?? $p->base_price;
        $salePrice = $default->sale_price ?? $p->sale_price;

        $wishlisted = false;
        if (Auth::hasUser() === false && request()->attributes->has('api_user')) {
            $wishlisted = Wishlist::where('user_id', request()->attributes->get('api_user')->id)
                ->where('product_id', $p->id)->exists();
        }

        $data = [
            'id' => $p->id,
            'name' => $p->nameLocale(),
            'slug' => $p->slug,
            'short_desc' => $p->descLocale(),
            'sku' => $p->sku,
            'gender' => $p->gender,
            'category' => $p->category ? $this->fmtCategory($p->category) : null,
            'price' => (float) $price,
            'sale_price' => $salePrice ? (float) $salePrice : null,
            'cover_image' => $primary->url ?? $p->cover_image,
            'is_featured' => (bool) $p->is_featured,
            'is_new_arrival' => (bool) $p->is_new_arrival,
            'is_best_seller' => (bool) $p->is_best_seller,
            'rating' => (float) $p->rating,
            'reviews_count' => (int) $p->reviews_count,
            'wishlisted' => $wishlisted,
        ];

        if ($detailed) {
            $data['description'] = $p->descLocale() ?: $p->description_en;
            $data['variants'] = $variants->map(fn($v) => $this->fmtVariant($v))->values();
            $data['reviews'] = ($p->reviews ?? collect())->map(fn($r) => [
                'id' => $r->id,
                'name' => $r->name,
                'rating' => (int) $r->rating,
                'content' => $r->content,
                'created_at' => $r->created_at?->toDateTimeString(),
            ])->values();
        }

        return $data;
    }

    protected function fmtBanner(Banner $b): array
    {
        return [
            'id' => $b->id,
            'title' => $b->titleLocale(),
            'subtitle' => $b->subtitleLocale(),
            'image' => $b->image,
            'link' => $b->link,
            'button_text' => $b->btnLocale(),
            'position' => $b->position,
        ];
    }

    protected function fmtOrder(Order $o, bool $detailed = false): array
    {
        $data = [
            'id' => $o->id,
            'ref_number' => $o->ref_number,
            'status' => $o->status,
            'payment_status' => $o->payment_status,
            'payment_method' => $o->payment_method,
            'subtotal' => (float) $o->subtotal,
            'shipping_fee' => (float) $o->shipping_fee,
            'discount' => (float) $o->discount,
            'total' => (float) $o->total,
            'currency' => $o->currency,
            'created_at' => $o->created_at?->toDateTimeString(),
        ];

        if ($detailed) {
            $data['shipping_address'] = $o->shipping_address;
            $data['shipping_city'] = $o->shipping_city;
            $data['shipping_country'] = $o->shipping_country;
            $data['notes'] = $o->notes;
            $data['items'] = $o->items->map(fn($i) => [
                'product_id' => $i->product_id,
                'variant_id' => $i->variant_id,
                'product_name' => $i->product_name,
                'variant_name' => $i->variant_name,
                'quantity' => $i->quantity,
                'price' => (float) $i->price,
                'total' => (float) $i->total,
            ])->values();
        }

        return $data;
    }
}
