<?php $__env->startSection('title',app()->getLocale()==='ar'?'ستايل فيرا — البسي قصتك':'Stylevera — Dress Your Story'); ?>
<?php $__env->startSection('content'); ?>
<?php $locale=app()->getLocale(); ?>


<section id="billboard" class="bg-light py-5">
  <div class="container">
    <div class="row justify-content-center">
      <h1 class="section-title text-center mt-4" data-aos="fade-up"><?php echo e($locale==='ar'?'مجموعات جديدة':'New Collections'); ?></h1>
      <div class="col-md-6 text-center" data-aos="fade-up" data-aos-delay="300">
        <p><?php echo e($locale==='ar'?'اكتشف أحدث صيحات الموضة الفاخرة في ستايل فيرا — وجهتك الأولى للأزياء في الإمارات.':'Discover the latest luxury fashion at Stylevera — your premier fashion destination in the UAE.'); ?></p>
      </div>
    </div>
    <div class="row">
      <div class="swiper main-swiper py-4" data-aos="fade-up" data-aos-delay="500">
        <div class="swiper-wrapper d-flex border-animation-left">
          <?php $__empty_1 = true; $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="swiper-slide">
            <div class="banner-item image-zoom-effect">
              <div class="image-holder">
                <a href="<?php echo e($banner->link ?: route('shop')); ?>">
                  <?php if($banner->image && str_starts_with($banner->image,'http')): ?>
                    <img src="<?php echo e($banner->image); ?>" alt="<?php echo e($banner->titleLocale()); ?>" class="img-fluid">
                  <?php else: ?>
                    <img src="<?php echo e(asset('images/placeholder.svg')); ?>" alt="<?php echo e($banner->titleLocale()); ?>" class="img-fluid" style="min-height:400px;object-fit:cover;background:#f1f1f0">
                  <?php endif; ?>
                </a>
              </div>
              <div class="banner-content py-4">
                <h5 class="element-title text-uppercase"><a href="<?php echo e($banner->link ?: route('shop')); ?>" class="item-anchor"><?php echo e($banner->titleLocale()); ?></a></h5>
                <p><?php echo e($banner->subtitleLocale()); ?></p>
                <div class="btn-left"><a href="<?php echo e($banner->link ?: route('shop')); ?>" class="btn-link fs-6 text-uppercase text-decoration-none"><?php echo e($banner->btnLocale()); ?></a></div>
              </div>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="swiper-slide">
            <div class="banner-item"><div class="image-holder" style="background:#f1f1f0;min-height:350px;display:flex;align-items:center;justify-content:center"><span style="color:#ccc;font-family:'Marcellus',serif;font-size:2rem">STYLEVERA</span></div></div>
          </div>
          <?php endif; ?>
        </div>
        <div class="swiper-pagination"></div>
      </div>
      <div class="icon-arrow icon-arrow-left"><svg width="50" height="50" viewBox="0 0 24 24"><use xlink:href="#arrow-left"/></svg></div>
      <div class="icon-arrow icon-arrow-right"><svg width="50" height="50" viewBox="0 0 24 24"><use xlink:href="#arrow-right"/></svg></div>
    </div>
  </div>
</section>


<section class="features py-5">
  <div class="container">
    <div class="row">
      <?php $__currentLoopData = [['calendar','Book An Appointment','احجز موعداً'],['shopping-bag','Pick Up In Store','استلم من المتجر'],['gift','Special Packaging','تغليف مميز'],['arrow-cycle','Free Global Returns','إرجاع مجاني دولي']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>[$icon,$en,$ar]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="<?php echo e($i*200); ?>">
        <div class="py-5">
          <svg width="38" height="38" viewBox="0 0 24 24"><use xlink:href="#<?php echo e($icon); ?>"/></svg>
          <h4 class="element-title text-capitalize my-3"><?php echo e($locale==='ar'?$ar:$en); ?></h4>
          <p><?php echo e($locale==='ar'?'نقدم لك أفضل تجربة تسوق في الإمارات.':'We bring you the best shopping experience in the UAE.'); ?></p>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>


<section class="categories overflow-hidden">
  <div class="container">
    <div class="open-up" data-aos="zoom-out">
      <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $featuredCats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4">
          <div class="cat-item image-zoom-effect">
            <div class="image-holder">
              <a href="<?php echo e(route('shop',['cat'=>$cat->slug])); ?>">
                <?php if($cat->image && str_starts_with($cat->image,'http')): ?>
                  <img src="<?php echo e($cat->image); ?>" alt="<?php echo e($cat->nameLocale()); ?>" class="product-image img-fluid">
                <?php else: ?>
                  <img src="<?php echo e(asset('images/placeholder.svg')); ?>" alt="<?php echo e($cat->nameLocale()); ?>" class="product-image img-fluid" style="min-height:300px;object-fit:cover">
                <?php endif; ?>
              </a>
            </div>
            <div class="category-content"><div class="product-button">
              <a href="<?php echo e(route('shop',['cat'=>$cat->slug])); ?>" class="btn btn-common text-uppercase"><?php echo e($locale==='ar'?'تسوق '.$cat->nameLocale():'Shop '.$cat->nameLocale()); ?></a>
            </div></div>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php for($i=0;$i<3;$i++): ?>
        <div class="col-md-4"><div class="cat-item" style="background:#f5f5f5;min-height:300px;border-radius:6px"></div></div>
        <?php endfor; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>


<section id="new-arrival" class="new-arrival product-carousel py-5 position-relative overflow-hidden">
  <div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
      <h4 class="text-uppercase" style="letter-spacing:1.5px"><?php echo e($locale==='ar'?'أحدث المنتجات':'Our New Arrivals'); ?></h4>
      <a href="<?php echo e(route('shop',['sort'=>'newest'])); ?>" class="btn-link"><?php echo e($locale==='ar'?'عرض الكل':'View All Products'); ?></a>
    </div>
    <div class="swiper product-swiper open-up" data-aos="zoom-out">
      <div class="swiper-wrapper d-flex">
        <?php $__currentLoopData = $newArrivals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $dp=$p->getDisplayPrice();
          $allMedia=collect();
          foreach($p->variants as $v){ foreach($v->media as $m){ $allMedia->push($m); } }
          $primary=$allMedia->where('is_primary',1)->first()?:$allMedia->first();
          $imgUrls=$allMedia->where('type','image')->pluck('url')->take(5)->values();
        ?>
        <div class="swiper-slide">
          <div class="product-item image-zoom-effect link-effect">
            <div class="image-holder position-relative">
              <?php if($primary && $primary->type==='video'): ?>
              <a href="<?php echo e(route('product.show',$p->slug)); ?>">
                <video src="<?php echo e($primary->url); ?>" muted autoplay loop class="product-image" style="width:100%;object-fit:cover;aspect-ratio:3/4"></video>
              </a>
              <?php elseif($primary): ?>
              <a href="<?php echo e(route('product.show',$p->slug)); ?>"
                <?php if($imgUrls->count()>1): ?>
                  class="sv-multi-img"
                  data-original-src="<?php echo e($primary->url); ?>"
                  data-images="<?php echo e($imgUrls->join('||')); ?>"
                <?php endif; ?>>
                <img src="<?php echo e($primary->url); ?>" alt="<?php echo e($p->nameLocale()); ?>" class="product-image sv-main-img img-fluid"
                  onerror="this.src='<?php echo e(asset('images/placeholder.svg')); ?>'">
              </a>
              <?php if($imgUrls->count()>1): ?>
              <div class="sv-img-dots">
                <?php for($d=0;$d<min($imgUrls->count(),5);$d++): ?>
                <div class="sv-img-dot <?php echo e($d===0?'active':''); ?>"></div>
                <?php endfor; ?>
              </div>
              <?php endif; ?>
              <?php else: ?>
              <a href="<?php echo e(route('product.show',$p->slug)); ?>">
                <img src="<?php echo e(asset('images/placeholder.svg')); ?>" alt="<?php echo e($p->nameLocale()); ?>" class="product-image img-fluid" style="aspect-ratio:3/4;object-fit:cover">
              </a>
              <?php endif; ?>
              <a href="#" class="btn-icon btn-wishlist" onclick="svToggleWishlist(<?php echo e($p->id); ?>,this);return false">
                <svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#heart"/></svg>
              </a>
              <?php if($p->is_new_arrival): ?><span class="sv-new-badge"><?php echo e($locale==='ar'?'جديد':'NEW'); ?></span><?php endif; ?>
              <div class="product-content">
                <h5 class="element-title text-uppercase fs-5 mt-3"><a href="<?php echo e(route('product.show',$p->slug)); ?>"><?php echo e($p->nameLocale()); ?></a></h5>
                <a href="<?php echo e(route('product.show',$p->slug)); ?>" class="text-decoration-none" data-after="<?php echo e($locale==='ar'?'أضف للسلة':'Add to cart'); ?>">
                  <span class="price-aed">
                    <?php if($dp['sale']): ?><span class="original"><?php echo e(number_format($dp['price'],2)); ?> AED</span><span class="sale"><?php echo e(number_format($dp['sale'],2)); ?> AED</span>
                    <?php else: ?><?php echo e(number_format($dp['price'],2)); ?> AED <?php endif; ?>
                  </span>
                </a>
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
  </div>
</section>


<section class="collection bg-light position-relative py-5" style="margin-top: -20%">
  <div class="container">
    <div class="row">
      <div class="title-xlarge text-uppercase txt-fx domino">Collection</div>
      <div class="collection-item d-flex flex-wrap my-5">
          <div class="col-md-6 column-container">
              <div class="image-holder"
                   style="
            min-height:520px;
            background:
                linear-gradient(rgba(0,0,0,.15),rgba(0,0,0,.15)),
                url('https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/29/1781199773_6a2af39d99667.jpeg');
            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
            border-radius:16px;
         ">
                  <div class="stylevera-wrapper">
                      <h1 id="styleveraText"></h1>
                  </div>
              </div>
          </div>
        <div class="col-md-6 column-container bg-white">
          <div class="collection-content p-5 m-0 m-md-5">
            <h3 class="element-title text-uppercase"><?php echo e($locale==='ar'?'مجموعة الشتاء الكلاسيكية':'Classic Winter Collection'); ?></h3>
            <p><?php echo e($locale==='ar'?'اكتشف مجموعتنا الشتوية الفاخرة — مصممة خصيصاً لتناسب أسلوب حياتك في دولة الإمارات.':'Discover our luxurious winter collection — designed for the UAE lifestyle with premium fabrics and timeless cuts.'); ?></p>
            <a href="<?php echo e(route('shop')); ?>" class="btn btn-dark text-uppercase mt-3" style="letter-spacing:2px"><?php echo e($locale==='ar'?'تسوق المجموعة':'Shop Collection'); ?></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<section id="best-sellers" class="best-sellers product-carousel py-5 position-relative overflow-hidden">
  <div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
      <h4 class="text-uppercase" style="letter-spacing:1.5px"><?php echo e($locale==='ar'?'الأكثر مبيعاً':'Best Selling Items'); ?></h4>
      <a href="<?php echo e(route('shop')); ?>" class="btn-link"><?php echo e($locale==='ar'?'عرض الكل':'View All Products'); ?></a>
    </div>
    <div class="swiper product-swiper open-up" data-aos="zoom-out">
      <div class="swiper-wrapper d-flex">
        <?php $__currentLoopData = $bestSellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $dp=$p->getDisplayPrice();
          $allMedia=collect();
          foreach($p->variants as $v){ foreach($v->media as $m){ $allMedia->push($m); } }
          $primary=$allMedia->where('is_primary',1)->first()?:$allMedia->first();
          $imgUrls=$allMedia->where('type','image')->pluck('url')->take(5)->values();
        ?>
        <div class="swiper-slide">
          <div class="product-item image-zoom-effect link-effect">
            <div class="image-holder position-relative">
              <?php if($primary && $primary->type==='video'): ?>
              <a href="<?php echo e(route('product.show',$p->slug)); ?>"><video src="<?php echo e($primary->url); ?>" muted autoplay loop class="product-image" style="width:100%;object-fit:cover;aspect-ratio:3/4"></video></a>
              <?php elseif($primary): ?>
              <a href="<?php echo e(route('product.show',$p->slug)); ?>"
                <?php if($imgUrls->count()>1): ?> class="sv-multi-img" data-original-src="<?php echo e($primary->url); ?>" data-images="<?php echo e($imgUrls->join('||')); ?>" <?php endif; ?>>
                <img src="<?php echo e($primary->url); ?>" alt="<?php echo e($p->nameLocale()); ?>" class="product-image sv-main-img img-fluid" onerror="this.src='<?php echo e(asset('images/placeholder.svg')); ?>'">
              </a>
              <?php if($imgUrls->count()>1): ?><div class="sv-img-dots"><?php for($d=0;$d<min($imgUrls->count(),5);$d++): ?><div class="sv-img-dot <?php echo e($d===0?'active':''); ?>"></div><?php endfor; ?></div><?php endif; ?>
              <?php else: ?>
              <a href="<?php echo e(route('product.show',$p->slug)); ?>"><img src="<?php echo e(asset('images/placeholder.svg')); ?>" alt="<?php echo e($p->nameLocale()); ?>" class="product-image img-fluid" style="aspect-ratio:3/4;object-fit:cover"></a>
              <?php endif; ?>
              <a href="#" class="btn-icon btn-wishlist" onclick="svToggleWishlist(<?php echo e($p->id); ?>,this);return false"><svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#heart"/></svg></a>
              <div class="product-content">
                <h5 class="text-uppercase fs-5 mt-3"><a href="<?php echo e(route('product.show',$p->slug)); ?>"><?php echo e($p->nameLocale()); ?></a></h5>
                <a href="<?php echo e(route('product.show',$p->slug)); ?>" class="text-decoration-none" data-after="<?php echo e($locale==='ar'?'أضف للسلة':'Add to cart'); ?>">
                  <span class="price-aed"><?php echo e(number_format($dp['sale']??$dp['price'],2)); ?> AED</span>
                </a>
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
  </div>
</section>


<style>
    /* Outer wrapper — adds left/right spacing */
    .sv-vs-outer{padding:32px 40px;background:transparent;line-height:0}
    @media(max-width:767px){.sv-vs-outer{padding:20px 16px}}

    /* Video card — rounded, full natural height */
    .sv-vs{
        position:relative;
        width:100%;
        border-radius:16px;        /* ← 16px border radius */
        overflow:hidden;
        background:#000;
        line-height:0;
        box-shadow:0 12px 48px rgba(0,0,0,.28);
    }
    /* Show FULL video — no cropping */
    .sv-vs video{
        width:100%;
        display:block;
        height:auto;               /* ← natural height, nothing cut */
        object-fit:contain;        /* ← entire frame always visible */
        background:#000;
    }
    .sv-vov{position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,0,0,.08) 0%,transparent 30%,rgba(0,0,0,.40) 100%);pointer-events:none;z-index:1;border-radius:16px}
    .sv-vcb{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);z-index:4;width:76px;height:76px;border-radius:50%;cursor:pointer;background:rgba(255,255,255,.14);border:2px solid rgba(255,255,255,.65);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;transition:all .25s}
    .sv-vcb:hover{background:rgba(255,255,255,.28);border-color:#fff;transform:translate(-50%,-50%) scale(1.1)}
    .sv-vcb.sv-g{opacity:0;pointer-events:none;transition:opacity .3s}
    .sv-vhi{position:absolute;top:16px;right:18px;z-index:4;background:rgba(0,0,0,.50);color:rgba(255,255,255,.88);font-size:11px;letter-spacing:1.5px;text-transform:uppercase;padding:5px 13px;border-radius:20px;display:flex;align-items:center;gap:6px;backdrop-filter:blur(4px);pointer-events:none;transition:opacity .35s}
    .sv-vhi.sv-g{opacity:0}
    /* Controls sit at the bottom of the video card */
    .sv-vctrl{position:absolute;bottom:0;left:0;right:0;z-index:5;padding:12px 20px 16px;border-radius:0 0 16px 16px;background:linear-gradient(to top,rgba(0,0,0,.72) 0%,transparent 100%);display:flex;align-items:center;gap:12px;opacity:0;transition:opacity .3s}
    .sv-vs:hover .sv-vctrl,.sv-vs.sv-act .sv-vctrl{opacity:1}
    .sv-vbtn{width:34px;height:34px;border-radius:50%;border:1.5px solid rgba(255,255,255,.55);background:rgba(255,255,255,.10);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;cursor:pointer;color:#fff;flex-shrink:0;transition:all .2s}
    .sv-vbtn:hover{background:rgba(255,255,255,.25);border-color:#fff}
    .sv-vpr{flex:1;height:4px;border-radius:4px;background:rgba(255,255,255,.22);cursor:pointer;transition:height .15s;position:relative}
    .sv-vpr:hover{height:7px}
    .sv-vpf{height:100%;border-radius:4px;background:linear-gradient(90deg,#C9A84C,#f0d27a);pointer-events:none;transition:width .1s linear}
    .sv-vtm{font-size:11px;color:rgba(255,255,255,.72);white-space:nowrap;letter-spacing:.5px;flex-shrink:0}
    .sv-vvw{display:flex;align-items:center;gap:7px;flex-shrink:0}
    .sv-vvi{cursor:pointer;color:rgba(255,255,255,.8);display:flex;align-items:center;transition:color .2s}
    .sv-vvi:hover{color:#fff}
    .sv-vvs{-webkit-appearance:none;appearance:none;width:78px;height:4px;border-radius:4px;background:rgba(255,255,255,.28);outline:none;cursor:pointer}
    .sv-vvs::-webkit-slider-thumb{-webkit-appearance:none;appearance:none;width:13px;height:13px;border-radius:50%;background:#C9A84C;cursor:pointer;box-shadow:0 0 5px rgba(201,168,76,.55)}
    .sv-vvs::-moz-range-thumb{width:13px;height:13px;border-radius:50%;background:#C9A84C;border:none;cursor:pointer}
</style>

<div class="sv-vs-outer" data-aos="zoom-out">
    <section class="sv-vs" id="svVS">
        <video id="svV"
               src="https://rajni-app-bucket-2026.s3.us-east-1.amazonaws.com/stylevera/variants/29/1781208710_6a2b1686e77ca.mp4"
               playsinline autoplay muted loop preload="metadata"
               style="width:100%;display:block;height:auto;object-fit:contain;background:#000"
        ></video>

        <div class="sv-vov"></div>

        
        <div class="sv-vhi" id="svHI">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/>
                <line x1="23" y1="9" x2="17" y2="15"/><line x1="17" y1="9" x2="23" y2="15"/>
            </svg>
            Tap to unmute
        </div>

        
        <div class="sv-vcb" id="svCB" onclick="svVU()">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="white" style="margin-left:4px">
                <polygon points="5 3 19 12 5 21 5 3"/>
            </svg>
        </div>

        
        <div class="sv-vctrl">
            <div class="sv-vbtn" onclick="svVT()">
                <svg id="svPI" width="13" height="13" viewBox="0 0 24 24" fill="white"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                <svg id="svPA" width="13" height="13" viewBox="0 0 24 24" fill="white" style="display:none"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
            </div>
            <div class="sv-vpr" id="svPR" onclick="svVSK(event)">
                <div class="sv-vpf" id="svPF" style="width:0%"></div>
            </div>
            <div class="sv-vtm" id="svTM">0:00 / 0:00</div>
            <div class="sv-vvw">
                <div class="sv-vvi" onclick="svVMT()">
                    <svg id="svVOn" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/>
                        <path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/>
                    </svg>
                    <svg id="svVOf" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none">
                        <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/>
                        <line x1="23" y1="9" x2="17" y2="15"/><line x1="17" y1="9" x2="23" y2="15"/>
                    </svg>
                </div>
                <input type="range" class="sv-vvs" id="svVL" min="0" max="1" step="0.02" value="0" oninput="svVV(this.value)">
            </div>
        </div>
    </section>

    <script>
        (function(){
            var v=document.getElementById('svV'),
                pf=document.getElementById('svPF'),
                tm=document.getElementById('svTM'),
                cb=document.getElementById('svCB'),
                hi=document.getElementById('svHI'),
                ws=document.getElementById('svVS'),
                vl=document.getElementById('svVL'),
                pi=document.getElementById('svPI'),
                pa=document.getElementById('svPA'),
                vo=document.getElementById('svVOn'),
                vx=document.getElementById('svVOf'),
                _live=false,_pv=0.8;

            function fmt(s){var m=Math.floor(s/60),ss=Math.floor(s%60);return m+':'+(ss<10?'0':'')+ss;}
            function setPP(p){pi.style.display=p?'none':'block';pa.style.display=p?'block':'none';}
            function setVI(n){vo.style.display=n>0?'block':'none';vx.style.display=n>0?'none':'block';}

            v.addEventListener('timeupdate',function(){
                if(!v.duration)return;
                pf.style.width=(v.currentTime/v.duration*100)+'%';
                tm.textContent=fmt(v.currentTime)+' / '+fmt(v.duration);
            });
            v.addEventListener('playing',function(){setPP(true);ws.classList.add('sv-act');});
            v.addEventListener('pause',function(){setPP(false);cb.classList.remove('sv-g');});

            v.muted=true;v.volume=0;vl.value=0;
            v.play().catch(function(){});

            window.svVU=function(){
                _live=true;v.muted=false;
                var vol=_pv||0.8;v.volume=vol;vl.value=vol;
                hi.classList.add('sv-g');cb.classList.add('sv-g');
                setVI(vol);if(v.paused)v.play();ws.classList.add('sv-act');
            };
            window.svVT=function(){v.paused?v.play():v.pause();};
            window.svVSK=function(e){
                var r=document.getElementById('svPR').getBoundingClientRect();
                v.currentTime=((e.clientX-r.left)/r.width)*v.duration;
            };
            window.svVV=function(n){
                n=parseFloat(n);v.volume=n;v.muted=(n===0);
                if(n>0)_pv=n;
                if(!_live&&n>0){_live=true;hi.classList.add('sv-g');cb.classList.add('sv-g');}
                setVI(n);
            };
            window.svVMT=function(){
                if(v.muted||v.volume===0){
                    var vol=_pv||0.7;v.muted=false;v.volume=vol;vl.value=vol;
                    if(!_live){_live=true;hi.classList.add('sv-g');cb.classList.add('sv-g');}
                    setVI(vol);
                } else {_pv=v.volume;v.muted=true;vl.value=0;setVI(0);}
            };
            v.addEventListener('click',function(){_live?svVT():svVU();});
        })();
    </script>
    </section>
</div>


<section class="testimonials py-5 bg-light">
  <div class="section-header text-center mt-5">
    <h3 class="section-title" style="letter-spacing:2px"><?php echo e($locale==='ar'?'ماذا يقول عملاؤنا':'WE LOVE GOOD COMPLIMENT'); ?></h3>
  </div>
  <div class="swiper testimonial-swiper overflow-hidden my-5">
    <div class="swiper-wrapper d-flex">
      <?php $__currentLoopData = [['More than expected — crazy soft, flexible, and perfectly fitted.','casual way'],['"Best fitted shirt — more than expected, crazy soft and flexible."','uptop'],['Outstanding quality and elegant design — Stylevera is truly the best!','Denim craze']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$q,$by]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="swiper-slide">
        <div class="testimonial-item text-center">
          <blockquote><p style="font-style:italic">"<?php echo e($q); ?>"</p><div class="review-title text-uppercase" style="font-size:12px;letter-spacing:2px;color:var(--sv-primary)">— <?php echo e($by); ?></div></blockquote>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
  <div class="testimonial-swiper-pagination d-flex justify-content-center mb-5"></div>
</section>

<?php $__env->stopSection(); ?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<style>

    .stylevera-wrapper{
        display:flex;
        justify-content:center;
        align-items:flex-end;
        min-height:337px;
    }

    /* STYLEVERA TEXT */

    #styleveraText{
        width: 340px;
        min-width: 340px;
        height: 65px;
        display: flex;
        justify-content: center;
        align-items: center;
        box-sizing: border-box;
        overflow: hidden;
        font-family: 'Marcellus', serif;
        font-size: 20px;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        background: linear-gradient(90deg, #fff7d6, #ffeca8, #dddbd1, #ffa954, #fff7d6);
        background-size: 300% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 10px rgba(255, 215, 0, .30), 0 0 20px rgba(255, 215, 0, .25), 0 0 40px rgba(255, 215, 0, .20);
        animation: shine 5s linear infinite, floating 4s ease-in-out infinite;
        border: 1px solid rgba(247, 215, 116, .55);
        border-radius: 10px;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        background-color: rgba(255, 255, 255, .03);
        box-shadow: 0 0 10px rgba(98, 92, 72, .70), 0 0 25px rgba(247, 215, 116, .25), inset 0 0 15px rgba(255, 247, 214, .15);
        position: relative;
        margin-left: 64px;
    }

    #styleveraText::before{
        content:"";
        position:absolute;
        inset:0;

        background:linear-gradient(
            90deg,
            rgba(247,215,116,.08),
            rgba(255,255,255,.02)
        );

        z-index:-1;
    }

    @keyframes shine{
        from{
            background-position:0% center;
        }
        to{
            background-position:300% center;
        }
    }

    @keyframes floating{
        0%,100%{
            transform:translateY(0);
        }
        50%{
            transform:translateY(-5px);
        }
    }

    /* Mobile */

    @media(max-width:768px){

        .stylevera-wrapper{
            min-height:250px;
        }

        #styleveraText{
            width:280px;
            min-width:280px;
            font-size:16px;
            letter-spacing:.14em;
        }
    }

</style>

<script>

    $(function(){

        const text = "STYLEVERA";
        const element = $("#styleveraText");

        function typeStylevera(){

            element.text("");

            let index = 0;

            const timer = setInterval(function(){

                element.text(
                    text.substring(0,index+1)
                );

                index++;

                if(index >= text.length){

                    clearInterval(timer);

                    setTimeout(function(){

                        typeStylevera();

                    },4000);
                }

            },180);

        }

        typeStylevera();

    });

</script>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/frontend/home.blade.php ENDPATH**/ ?>