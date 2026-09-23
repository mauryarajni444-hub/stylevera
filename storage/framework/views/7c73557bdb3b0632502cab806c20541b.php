<?php $__env->startSection('title',$product->nameLocale().' — Stylevera'); ?>
<?php $__env->startPush('styles'); ?>
    <style>
        /* ── Product Page Only ─────────────────────────────────── */
        .sv-prod-wrap { display:flex; gap:48px; }
        @media(max-width:991px){ .sv-prod-wrap{ flex-direction:column; gap:24px; } }

        /* Gallery */
        .sv-gallery-main {
            width:100%; aspect-ratio:3/4; border-radius:8px; overflow:hidden;
            background:var(--sv-bg-alt); position:relative;
        }
        .sv-gallery-main img,
        .sv-gallery-main video {
            width:100%; height:100%; object-fit:cover; display:block;
        }
        .sv-gallery-thumbs {
            display:flex; gap:8px; flex-wrap:wrap; margin-top:10px;
        }
        .sv-gallery-thumb {
            width:68px; height:88px; object-fit:cover; border-radius:4px;
            cursor:pointer; opacity:.6; transition:opacity .2s,border-color .2s;
            border:2px solid transparent;
        }
        .sv-gallery-thumb.active,
        .sv-gallery-thumb:hover { opacity:1; border-color:var(--sv-primary); }
        .sv-thumb-video {
            width:68px; height:88px; border-radius:4px; cursor:pointer;
            border:2px solid transparent; opacity:.6; background:#111;
            display:flex; align-items:center; justify-content:center; transition:opacity .2s;
        }
        .sv-thumb-video.active,
        .sv-thumb-video:hover { opacity:1; border-color:var(--sv-primary); }

        /* Swatches */
        .sv-swatch-row { margin-bottom:18px; }
        .sv-swatch-label {
            font-size:10px; font-weight:700; letter-spacing:2px; text-transform:uppercase;
            color:var(--sv-muted); margin-bottom:9px; display:block;
        }
        .sv-swatch-label strong { color:var(--sv-text); font-weight:700; }
        .sv-colors { display:flex; gap:10px; flex-wrap:wrap; }
        .sv-color {
            width:32px; height:32px; border-radius:50%; cursor:pointer;
            border:2px solid transparent; transition:all .2s; position:relative;
        }
        .sv-color:hover { transform:scale(1.1); }
        .sv-color.active {
            box-shadow:0 0 0 3px var(--sv-bg), 0 0 0 5px var(--sv-primary);
        }
        .sv-sizes { display:flex; gap:8px; flex-wrap:wrap; }
        .sv-size {
            min-width:44px; height:44px; padding:0 12px;
            display:flex; align-items:center; justify-content:center;
            border:1.5px solid var(--sv-border); border-radius:4px;
            font-size:13px; font-weight:600; cursor:pointer;
            transition:all .2s; color:var(--sv-text); background:var(--sv-card);
            letter-spacing:.5px; user-select:none;
        }
        .sv-size:hover { border-color:var(--sv-primary); color:var(--sv-primary); }
        .sv-size.active {
            background:var(--sv-text); color:var(--sv-bg);
            border-color:var(--sv-text);
        }
        .sv-size.sv-oos {
            opacity:.38; text-decoration:line-through;
            border-style:dashed; cursor:default;
        }
        /* Price */
        .sv-price-now { font-size:1.75rem; font-weight:700; }
        .sv-price-was { font-size:1rem; text-decoration:line-through; color:var(--sv-muted); margin-right:8px; }
        .sv-price-badge {
            display:inline-block; background:#c0392b; color:#fff;
            font-size:10px; font-weight:800; letter-spacing:1.5px;
            padding:2px 7px; border-radius:2px; vertical-align:middle; margin-left:6px;
        }
        /* Stock badge */
        .sv-stock { font-size:12.5px; font-weight:600; margin-bottom:16px; }
        .sv-stock.in { color:#27ae60; }
        .sv-stock.low { color:#e67e22; }
        .sv-stock.out { color:#c0392b; }
        /* Add to cart row */
        .sv-atc-row { display:flex; gap:12px; align-items:center; margin:20px 0; flex-wrap:wrap; }
        .sv-qty {
            display:flex; align-items:center; gap:0; border:1.5px solid var(--sv-border);
            border-radius:5px; overflow:hidden;
        }
        .sv-qty button {
            width:36px; height:44px; border:none; background:transparent;
            font-size:18px; cursor:pointer; color:var(--sv-text);
            transition:background .15s;
        }
        .sv-qty button:hover { background:var(--sv-bg-alt); }
        .sv-qty input {
            width:42px; height:44px; border:none; border-left:1.5px solid var(--sv-border);
            border-right:1.5px solid var(--sv-border); text-align:center;
            background:transparent; color:var(--sv-text); font-size:15px; font-weight:600;
        }
        /* Wishlist btn */
        .sv-wish-btn {
            width:48px; height:44px; border:1.5px solid var(--sv-border); border-radius:5px;
            background:transparent; cursor:pointer; display:flex; align-items:center; justify-content:center;
            color:var(--sv-text); transition:all .2s; flex-shrink:0;
        }
        .sv-wish-btn:hover,
        .sv-wish-btn.wishlisted { border-color:#e74c3c; color:#e74c3c; }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <?php
        $locale = app()->getLocale();

        /* ── Build variant data for JS ─────────────────────────── */
        $defId = null;
        $variantJson = $product->variants->map(function($v) use (&$defId) {
          if ($v->is_default && !$defId) $defId = $v->id;
          return [
            'id'         => $v->id,
            'color'      => $v->color,
            'color_hex'  => $v->color_hex,
            'size'       => $v->size,
            'price'      => (float) $v->price,
            'sale_price' => $v->sale_price ? (float)$v->sale_price : null,
            'stock'      => (int) $v->stock,
            'is_default' => (bool) $v->is_default,
            'media'      => $v->media->sortByDesc('is_primary')->map(fn($m) => [
              'url'        => $m->url,
              'type'       => $m->type,
              'is_primary' => (bool) $m->is_primary,
            ])->values(),
          ];
        })->values();

        if (!$defId) $defId = $product->variants->first()?->id;

        /* Unique colors + sizes for swatches */
        $colors   = $product->variants->filter(fn($v)=>$v->color)->groupBy('color');
        $allSizes = $product->variants->filter(fn($v)=>$v->size)->pluck('size')->unique()->values();

        /* Initial price display */
        $dp = $product->getDisplayPrice();
    ?>

    
    <div class="sv-breadcrumb">
        <div class="container">
            <a href="<?php echo e(route('home')); ?>"><?php echo e($locale==='ar'?'الرئيسية':'Home'); ?></a><span>/</span>
            <a href="<?php echo e(route('shop')); ?>"><?php echo e($locale==='ar'?'المتجر':'Shop'); ?></a><span>/</span>
            <?php if($product->category): ?>
                <a href="<?php echo e(route('shop',['cat'=>$product->category->slug])); ?>"><?php echo e($product->category->nameLocale()); ?></a><span>/</span>
            <?php endif; ?>
            <strong><?php echo e($product->nameLocale()); ?></strong>
        </div>
    </div>

    <div class="container py-5">
        <div class="sv-prod-wrap">

            
            <div style="flex:0 0 48%;min-width:0">
                <div class="sv-gallery-main" id="svMain">
                    <div style="width:100%;height:100%;background:var(--sv-bg-alt);display:flex;align-items:center;justify-content:center">
                        <span style="font-family:'Marcellus',serif;font-size:2rem;opacity:.15;letter-spacing:.1em">SV</span>
                    </div>
                </div>
                <div class="sv-gallery-thumbs" id="svThumbs"></div>
            </div>

            
            <div style="flex:1;min-width:0">

                
                <?php if($product->category): ?>
                    <div style="font-size:11px;letter-spacing:2.5px;text-transform:uppercase;color:var(--sv-primary);margin-bottom:6px"><?php echo e($product->category->nameLocale()); ?></div>
                <?php endif; ?>

                
                <h1 style="font-family:'Marcellus',serif;font-size:1.9rem;text-transform:uppercase;letter-spacing:.04em;margin:0 0 14px"><?php echo e($product->nameLocale()); ?></h1>

                
                <?php if($product->reviews_count): ?>
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px">
                        <span style="color:#f0a500;font-size:15px"><?php echo e(str_repeat('★',min(5,round($product->rating??0)))); ?><?php echo e(str_repeat('☆',max(0,5-round($product->rating??0)))); ?></span>
                        <span style="font-size:12px;color:var(--sv-muted)">(<?php echo e($product->reviews_count); ?> reviews)</span>
                    </div>
                <?php endif; ?>

                
                <div id="svPrice" style="margin-bottom:20px">
                    <?php if($dp['sale']): ?>
                        <span class="sv-price-was"><?php echo e(number_format($dp['price'],2)); ?> AED</span>
                        <span class="sv-price-now" style="color:#c0392b"><?php echo e(number_format($dp['sale'],2)); ?> AED</span>
                        <span class="sv-price-badge">SALE</span>
                    <?php else: ?>
                        <span class="sv-price-now"><?php echo e(number_format($dp['price'],2)); ?> AED</span>
                    <?php endif; ?>
                </div>

                
                <?php if($colors->count()): ?>
                    <div class="sv-swatch-row">
                        <span class="sv-swatch-label"><?php echo e($locale==='ar'?'اللون':'COLOR'); ?>: <strong id="svColorTxt"><?php echo e($colors->keys()->first()); ?></strong></span>
                        <div class="sv-colors">
                            <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color => $cvs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $hex = $cvs->first()->color_hex ?: '#999'; ?>
                                <div class="sv-color <?php echo e($loop->first?'active':''); ?>"
                                     style="background:<?php echo e($hex); ?>"
                                     data-color="<?php echo e($color); ?>"
                                     title="<?php echo e($color); ?>">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                
                <?php if($allSizes->count()): ?>
                    <div class="sv-swatch-row">
                        <span class="sv-swatch-label"><?php echo e($locale==='ar'?'المقاس':'SIZE'); ?>: <strong id="svSizeTxt"></strong></span>
                        <div class="sv-sizes" id="svSizes">
                            <?php $__currentLoopData = $allSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="sv-size" data-sz="<?php echo e($sz); ?>"><?php echo e($sz); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                
                <div id="svStock" class="sv-stock"></div>

                
                <div class="sv-atc-row">
                    <div class="sv-qty">
                        <button type="button" onclick="svQty(-1)">−</button>
                        <input type="number" id="svQty" value="1" min="1" max="99">
                        <button type="button" onclick="svQty(1)">+</button>
                    </div>
                    <button id="svATC" class="btn btn-dark text-uppercase flex-grow-1" style="letter-spacing:2px;padding:12px 0;height:44px"
                            onclick="svAddToCart(<?php echo e($product->id); ?>, +document.getElementById('svVid').value, +document.getElementById('svQty').value)">
                        <?php echo e($locale==='ar'?'أضف إلى السلة':'ADD TO CART'); ?>

                    </button>
                    <button class="sv-wish-btn" onclick="svToggleWishlist(<?php echo e($product->id); ?>,this)" title="Wishlist">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    </button>
                </div>

                
                <input type="hidden" id="svVid" value="<?php echo e($defId); ?>">

                
                <?php if($product->descLocale()): ?>
                    <p style="font-size:14px;line-height:1.8;color:var(--sv-muted);margin-bottom:18px"><?php echo e($product->descLocale()); ?></p>
                <?php endif; ?>

                
                <div style="font-size:12px;color:var(--sv-muted);border-top:1px solid var(--sv-border);padding-top:12px;line-height:2.2">
                    <?php if($product->category): ?><span>Category: <a href="<?php echo e(route('shop',['cat'=>$product->category->slug])); ?>" style="color:var(--sv-primary)"><?php echo e($product->category->nameLocale()); ?></a></span><?php endif; ?>
                    <?php if($product->gender): ?> &ensp;<span><?php echo e(ucfirst($product->gender)); ?></span><?php endif; ?>
                    <?php if($product->sku): ?> &ensp;<span>SKU: <?php echo e($product->sku); ?></span><?php endif; ?>
                </div>

            </div>
        </div>

        
        <div style="margin-top:48px">
            <ul class="nav nav-tabs" style="border-color:var(--sv-border)">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabDesc" style="letter-spacing:1.5px;text-transform:uppercase;font-size:12px"><?php echo e($locale==='ar'?'الوصف':'DESCRIPTION'); ?></button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabRev" style="letter-spacing:1.5px;text-transform:uppercase;font-size:12px"><?php echo e($locale==='ar'?'التقييمات':'REVIEWS'); ?> (<?php echo e($product->reviews->count()); ?>)</button></li>
            </ul>
            <div class="tab-content" style="padding:24px 0">
                <div class="tab-pane fade show active" id="tabDesc">
                    <?php $desc = $locale==='ar' ? ($product->description_ar??$product->description_en) : ($product->description_en??''); ?>
                    <?php if($desc): ?><?php echo $desc; ?><?php else: ?><p style="color:var(--sv-muted)"><?php echo e($product->descLocale()); ?></p><?php endif; ?>
                </div>
                <div class="tab-pane fade" id="tabRev">
                    <?php $__empty_1 = true; $__currentLoopData = $product->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div style="border-bottom:1px solid var(--sv-border);padding:16px 0">
                            <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px">
                                <div style="width:36px;height:36px;border-radius:50%;background:var(--sv-primary);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700"><?php echo e(strtoupper(substr($rev->name,0,1))); ?></div>
                                <strong><?php echo e($rev->name); ?></strong>
                                <span style="color:#f0a500"><?php echo e(str_repeat('★',$rev->rating)); ?></span>
                                <span style="font-size:11px;color:var(--sv-muted)"><?php echo e($rev->created_at->format('d M Y')); ?></span>
                            </div>
                            <p style="color:var(--sv-muted);font-size:14px;margin:0"><?php echo e($rev->content); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p style="color:var(--sv-muted)">No reviews yet. Be the first!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <?php if($related->count()): ?>
            <section class="product-carousel py-5 position-relative overflow-hidden">
                <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
                    <h4 class="text-uppercase" style="letter-spacing:1.5px"><?php echo e($locale==='ar'?'قد يعجبك أيضاً':'YOU MAY ALSO LIKE'); ?></h4>
                    <a href="<?php echo e(route('shop')); ?>" class="btn-link"><?php echo e($locale==='ar'?'عرض الكل':'View All'); ?></a>
                </div>
                <div class="swiper product-swiper">
                    <div class="swiper-wrapper d-flex">
                        <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $rdp=$rp->getDisplayPrice(); $rpm=$rp->getPrimaryImage(); ?>
                            <div class="swiper-slide">
                                <div class="product-item image-zoom-effect link-effect">
                                    <div class="image-holder position-relative">
                                        <a href="<?php echo e(route('product.show',$rp->slug)); ?>">
                                            <?php if($rpm): ?>
                                                <img src="<?php echo e($rpm); ?>" alt="<?php echo e($rp->nameLocale()); ?>" class="product-image img-fluid" style="aspect-ratio:3/4;object-fit:cover" onerror="this.src='<?php echo e(asset('images/placeholder.svg')); ?>'">
                                            <?php else: ?>
                                                <div class="product-image" style="aspect-ratio:3/4;background:var(--sv-bg-alt);display:flex;align-items:center;justify-content:center"><span style="font-family:'Marcellus',serif;opacity:.3">SV</span></div>
                                            <?php endif; ?>
                                        </a>
                                        <a href="#" class="btn-icon btn-wishlist" onclick="svToggleWishlist(<?php echo e($rp->id); ?>,this);return false"><svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#heart"/></svg></a>
                                        <div class="product-content">
                                            <h5 class="text-uppercase fs-5 mt-3"><a href="<?php echo e(route('product.show',$rp->slug)); ?>"><?php echo e($rp->nameLocale()); ?></a></h5>
                                            <span class="price-aed"><?php echo e(number_format($rdp['sale']??$rdp['price'],2)); ?> AED</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="icon-arrow icon-arrow-left"><svg width="50" height="50" viewBox="0 0 24 24"><use xlink:href="#arrow-left"/></svg></div>
                <div class="icon-arrow icon-arrow-right"><svg width="50" height="50" viewBox="0 0 24 24"><use xlink:href="#arrow-right"/></svg></div>
            </section>
        <?php endif; ?>

    </div>

    
    <script>
        window.SV_VARIANTS = <?php echo json_encode($variantJson, 15, 512) ?>;
        window.SV_DEFAULT  = <?php echo e($defId ?? 'null'); ?>;
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        /* ═══════════════════════════════════════════════════════════
           STYLEVERA PRODUCT PAGE — Complete Self-Contained Logic
           No conflicts. No external dependencies beyond jQuery.
           All sizes ALWAYS visible. Gallery per-variant only.
        ═══════════════════════════════════════════════════════════ */
        (function($){
            'use strict';

            /* state */
            var CUR_COLOR = null;
            var CUR_SIZE  = null;

            /* ── Qty control ───────────────────────────────────────── */
            window.svQty = function(d){
                var el = document.getElementById('svQty');
                var v  = Math.max(1, (parseInt(el.value)||1) + d);
                el.value = v;
            };

            /* ── Find best variant ─────────────────────────────────── */
            function findV(color, size){
                var vv = window.SV_VARIANTS || [];
                var i, v;
                /* 1. exact */
                for(i=0;i<vv.length;i++){ if(vv[i].color===color && vv[i].size===size) return vv[i]; }
                /* 2. same color, prefer in-stock */
                for(i=0;i<vv.length;i++){ if(vv[i].color===color && vv[i].stock>0) return vv[i]; }
                for(i=0;i<vv.length;i++){ if(vv[i].color===color) return vv[i]; }
                /* 3. same size, prefer in-stock */
                for(i=0;i<vv.length;i++){ if(vv[i].size===size && vv[i].stock>0) return vv[i]; }
                for(i=0;i<vv.length;i++){ if(vv[i].size===size) return vv[i]; }
                /* 4. first */
                return vv[0] || null;
            }

            /* ── Render gallery for a variant ─────────────────────── */
            function showGallery(v){
                var media = v.media || [];
                var $main = $('#svMain');
                var $tb   = $('#svThumbs');

                /* Find primary */
                var primary = null, i;
                for(i=0;i<media.length;i++){ if(media[i].is_primary){ primary=media[i]; break; } }
                if(!primary && media.length) primary = media[0];

                /* Main viewer */
                $main.empty();
                if(primary){
                    if(primary.type==='video'){
                        $main.html('<video src="'+primary.url+'" controls style="width:100%;height:100%;object-fit:cover"></video>');
                    } else {
                        $main.html('<img src="'+primary.url+'" style="width:100%;height:100%;object-fit:cover;cursor:zoom-in" onclick="svLightbox(\''+primary.url.replace(/'/g,"\\'")+'\')" onerror="this.src=\'/images/placeholder.svg\'">');
                    }
                } else {
                    $main.html('<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center"><span style="font-family:Marcellus,serif;font-size:2rem;opacity:.15">SV</span></div>');
                }

                /* Thumbnails — only this variant */
                $tb.empty();
                if(media.length < 2) return;
                for(i=0;i<media.length;i++){
                    var m = media[i];
                    var isActive = m.is_primary || (i===0 && !primary.is_primary);
                    if(m.type==='video'){
                        var $vt = $('<div class="sv-thumb-video'+(isActive?' active':'')+'" data-url="'+m.url+'" data-type="video"><i class="bi bi-play-circle" style="font-size:1.5rem;color:#fff"></i></div>');
                        $tb.append($vt);
                    } else {
                        var $img = $('<img class="sv-gallery-thumb'+(isActive?' active':'')+'" src="'+m.url+'" data-url="'+m.url+'" data-type="image" onerror="this.src=\'/images/placeholder.svg\'">');
                        $tb.append($img);
                    }
                }
            }

            /* ── Render price ──────────────────────────────────────── */
            function showPrice(v){
                var p = v.price || 0;
                var s = v.sale_price || 0;
                var h;
                if(s && s < p){
                    h = '<span class="sv-price-was">'+p.toFixed(2)+' AED</span>'
                        + '<span class="sv-price-now" style="color:#c0392b">'+s.toFixed(2)+' AED</span>'
                        + '<span class="sv-price-badge">SALE</span>';
                } else {
                    h = '<span class="sv-price-now">'+p.toFixed(2)+' AED</span>';
                }
                $('#svPrice').html(h);
            }

            /* ── Render stock badge ────────────────────────────────── */
            function showStock(v){
                var s = parseInt(v.stock)||0;
                var $b = $('#svStock'), $btn = $('#svATC');
                $b.removeClass('in low out');
                if(s<=0){
                    $b.addClass('out').text('✕ Out of Stock');
                    $btn.prop('disabled',true).css('opacity','.5');
                } else if(s<=5){
                    $b.addClass('low').text('Only '+s+' left in stock');
                    $btn.prop('disabled',false).css('opacity','1');
                } else {
                    $b.addClass('in').text('✓ In Stock');
                    $btn.prop('disabled',false).css('opacity','1');
                }
            }

            /* ── Refresh size styles — NEVER hides, only adds/removes .sv-oos ── */
            function refreshSizes(color){
                var vv = window.SV_VARIANTS || [];
                $('#svSizes .sv-size').each(function(){
                    var sz  = $(this).data('sz');
                    var has = false, oos = false;
                    for(var i=0;i<vv.length;i++){
                        if(vv[i].color===color && vv[i].size===sz){
                            has=true;
                            if(parseInt(vv[i].stock)<=0) oos=true;
                            else { oos=false; break; }
                        }
                    }
                    /* always visible — only style changes */
                    $(this).removeClass('sv-oos');
                    if(!has || oos) $(this).addClass('sv-oos');
                });
            }

            /* ── Master: select a variant and update all UI ─────────── */
            function selectVariant(color, size){
                var v = findV(color, size);
                if(!v) return;

                /* lock in resolved state */
                CUR_COLOR = v.color;
                CUR_SIZE  = v.size;
                document.getElementById('svVid').value = v.id;

                showGallery(v);
                showPrice(v);
                showStock(v);

                /* highlight correct color */
                $('.sv-color').removeClass('active');
                $('.sv-color[data-color="'+CUR_COLOR+'"]').addClass('active');
                $('#svColorTxt').text(CUR_COLOR||'');

                /* highlight correct size — ALL sizes stay in DOM */
                $('#svSizes .sv-size').removeClass('active');
                if(CUR_SIZE){
                    $('#svSizes .sv-size[data-sz="'+CUR_SIZE+'"]').addClass('active');
                    $('#svSizeTxt').text(CUR_SIZE);
                }

                if(CUR_COLOR) refreshSizes(CUR_COLOR);
            }

            /* ── Color click ───────────────────────────────────────── */
            $(document).on('click', '.sv-color', function(){
                var color = $(this).data('color');
                /* keep current size if possible for new color, else pick best */
                selectVariant(color, CUR_SIZE);
            });

            /* ── Size click — ALWAYS works ─────────────────────────── */
            $(document).on('click', '.sv-size', function(){
                var sz = $(this).data('sz');
                selectVariant(CUR_COLOR, sz);
            });

            /* ── Thumbnail click ───────────────────────────────────── */
            $(document).on('click', '.sv-gallery-thumb, .sv-thumb-video', function(){
                var url  = $(this).data('url');
                var type = $(this).data('type')||'image';
                if(type==='video'){
                    $('#svMain').html('<video src="'+url+'" controls style="width:100%;height:100%;object-fit:cover"></video>');
                } else {
                    $('#svMain').html('<img src="'+url+'" style="width:100%;height:100%;object-fit:cover;cursor:zoom-in" onclick="svLightbox(\''+url.replace(/'/g,"\\'")+'\')" onerror="this.src=\'/images/placeholder.svg\'">');
                }
                $('.sv-gallery-thumb,.sv-thumb-video').removeClass('active');
                $(this).addClass('active');
            });

            /* ── Init ──────────────────────────────────────────────── */
            $(function(){
                var vv    = window.SV_VARIANTS || [];
                var defId = window.SV_DEFAULT;
                var defV  = null;
                for(var i=0;i<vv.length;i++){ if(vv[i].id===defId){ defV=vv[i]; break; } }
                if(!defV) defV = vv[0];
                if(!defV) return;
                selectVariant(defV.color, defV.size);
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/frontend/product.blade.php ENDPATH**/ ?>