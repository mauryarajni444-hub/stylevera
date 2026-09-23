<?php $__env->startSection('title',app()->getLocale()==='ar'?'المتجر — ستايل فيرا':'Shop — Stylevera'); ?>
<?php $__env->startSection('content'); ?>
    <?php $locale=app()->getLocale(); ?>
    <div class="sv-breadcrumb">
        <div class="container"><a href="<?php echo e(route('home')); ?>"><?php echo e($locale==='ar'?'الرئيسية':'Home'); ?></a><span>/</span><strong><?php echo e($locale==='ar'?'المتجر':'Shop'); ?></strong></div>
    </div>
    <div class="container py-5">
        <div class="row">
            
            <div class="col-lg-3 mb-5">
                <form method="GET" action="<?php echo e(route('shop')); ?>" id="shopForm">
                    <div class="sv-card mb-3">
                        <div class="sv-filter-title"><?php echo e($locale==='ar'?'الفئات':'Categories'); ?></div>
                        <div class="sv-filter-item" onclick="document.querySelector('[name=cat]').value='';document.getElementById('shopForm').submit()">
                            <span><?php echo e($locale==='ar'?'الكل':'All'); ?></span><small style="color:#aaa"><?php echo e($categories->sum('products_count')); ?></small>
                        </div>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="sv-filter-item" onclick="document.querySelector('[name=cat]').value='<?php echo e($cat->slug); ?>';document.getElementById('shopForm').submit()" style="<?php echo e(request('cat')===$cat->slug?'color:var(--sv-primary);font-weight:600':''); ?>">
                                <span><?php echo e($cat->nameLocale()); ?></span><small style="color:#aaa">(<?php echo e($cat->products_count); ?>)</small>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <input type="hidden" name="cat" value="<?php echo e(request('cat')); ?>">
                    </div>

                    <div class="sv-card mb-3">
                        <div class="sv-filter-title"><?php echo e($locale==='ar'?'الجنس':'Gender'); ?></div>
                        <?php
                            $genderOptions = [
                              ['val' => '',       'en' => 'All',     'ar' => 'الكل'],
                              ['val' => 'women',  'en' => 'Women',   'ar' => 'نساء'],
                              ['val' => 'men',    'en' => 'Men',     'ar' => 'رجال'],
                              ['val' => 'unisex', 'en' => 'Unisex',  'ar' => 'للجنسين'],
                            ];
                        ?>
                        <?php $__currentLoopData = $genderOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="sv-filter-item" style="cursor:pointer">
                                <span><?php echo e($locale==='ar' ? $option['ar'] : $option['en']); ?></span>
                                <input type="radio" name="gender" value="<?php echo e($option['val']); ?>" <?php echo e(request('gender')===$option['val']?'checked':''); ?> onchange="this.form.submit()" style="accent-color:var(--sv-primary)">
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="sv-card mb-3">
                        <div class="sv-filter-title"><?php echo e($locale==='ar'?'الترتيب':'Sort By'); ?></div>
                        <select name="sort" class="sv-select" onchange="this.form.submit()">
                            <option value=""><?php echo e($locale==='ar'?'الافتراضي':'Default'); ?></option>
                            <option value="newest" <?php echo e(request('sort')==='newest'?'selected':''); ?>><?php echo e($locale==='ar'?'الأحدث':'Newest'); ?></option>
                            <option value="price_asc" <?php echo e(request('sort')==='price_asc'?'selected':''); ?>><?php echo e($locale==='ar'?'السعر: الأقل':'Price: Low to High'); ?></option>
                            <option value="price_desc" <?php echo e(request('sort')==='price_desc'?'selected':''); ?>><?php echo e($locale==='ar'?'السعر: الأعلى':'Price: High to Low'); ?></option>
                        </select>
                    </div>

                    <?php if(request()->hasAny(['cat','gender','sort','search'])): ?>
                        <a href="<?php echo e(route('shop')); ?>" class="btn btn-outline-dark w-100 text-uppercase" style="font-size:12px;letter-spacing:1px"><?php echo e($locale==='ar'?'مسح الفلاتر':'Clear Filters'); ?></a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="col-lg-9">
                <?php if(request('search')): ?>
                    <p style="font-size:13px;color:#999;margin-bottom:16px"><?php echo e($products->total()); ?> <?php echo e($locale==='ar'?'نتيجة لـ':'results for'); ?> "<?php echo e(request('search')); ?>"</p>
                <?php endif; ?>

                <div class="row g-4">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $dp = $p->getDisplayPrice();
                            $allMedia = $p->getAllMedia();
                            $primary = $allMedia->where('type','image')->where('is_primary',1)->first()
                                       ?: $allMedia->where('type','image')->first()
                                       ?: $allMedia->first();
                            $imgUrls = $allMedia->where('type','image')->pluck('url')->take(5)->values();
                        ?>
                        <div class="col-md-4 col-6">
                            <div class="product-item image-zoom-effect link-effect">
                                <div class="image-holder position-relative">
                                    <?php if($primary && $primary->type==='video'): ?>
                                        <a href="<?php echo e(route('product.show',$p->slug)); ?>">
                                            <video src="<?php echo e($primary->url); ?>" muted autoplay loop class="product-image" style="width:100%;aspect-ratio:3/4;object-fit:cover"></video>
                                        </a>
                                    <?php elseif($primary): ?>
                                        <a href="<?php echo e(route('product.show',$p->slug)); ?>"
                                           <?php if($imgUrls->count()>1): ?> class="sv-multi-img" data-original-src="<?php echo e($primary->url); ?>" data-images="<?php echo e($imgUrls->join('||')); ?>" <?php endif; ?>>
                                            <img src="<?php echo e($primary->url); ?>" alt="<?php echo e($p->nameLocale()); ?>" class="product-image sv-main-img img-fluid"
                                                 style="aspect-ratio:3/4;object-fit:cover" onerror="this.src='<?php echo e(asset('images/placeholder.svg')); ?>'">
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
                                            <div class="product-image" style="aspect-ratio:3/4;background:linear-gradient(135deg,#f5f5f5,#ece9e4);display:flex;align-items:center;justify-content:center">
                                                <span style="font-family:'Marcellus',serif;font-size:1.5rem;color:rgba(140,144,126,0.4);letter-spacing:.05em">SV</span>
                                            </div>
                                        </a>
                                    <?php endif; ?>

                                    <a href="#" class="btn-icon btn-wishlist" onclick="svToggleWishlist(<?php echo e($p->id); ?>,this);return false">
                                        <svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#heart"/></svg>
                                    </a>
                                    <?php if($p->is_new_arrival): ?><span class="sv-new-badge"><?php echo e($locale==='ar'?'جديد':'NEW'); ?></span><?php endif; ?>
                                    <?php if($dp['sale']): ?><span class="price-badge" style="position:absolute;top:<?php echo e($p->is_new_arrival?'32':'10'); ?>px;left:10px">SALE</span><?php endif; ?>

                                    <div class="product-content">
                                        <h5 class="element-title text-uppercase fs-5 mt-3"><a href="<?php echo e(route('product.show',$p->slug)); ?>"><?php echo e($p->nameLocale()); ?></a></h5>
                                        <a href="<?php echo e(route('product.show',$p->slug)); ?>" class="text-decoration-none" data-after="<?php echo e($locale==='ar'?'أضف للسلة':'Add to cart'); ?>">
                  <span class="price-aed">
                    <?php if($dp['sale']): ?>
                          <span class="original"><?php echo e(number_format($dp['price'],2)); ?> AED</span>
                          <span class="sale"><?php echo e(number_format($dp['sale'],2)); ?> AED</span>
                      <?php else: ?>
                          <?php echo e(number_format($dp['price'],2)); ?> AED
                      <?php endif; ?>
                  </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-bag-x" style="font-size:3rem;opacity:0.2;display:block;margin-bottom:16px"></i>
                            <p style="color:#aaa"><?php echo e($locale==='ar'?'لا توجد منتجات.':'No products found.'); ?></p>
                            <a href="<?php echo e(route('shop')); ?>" class="btn btn-dark text-uppercase" style="font-size:12px;letter-spacing:1.5px"><?php echo e($locale==='ar'?'عرض الكل':'View All'); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mt-4"><?php echo e($products->links()); ?></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/frontend/shop.blade.php ENDPATH**/ ?>