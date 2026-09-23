<?php $__env->startSection('title',app()->getLocale()==='ar'?'المفضلة — ستايل فيرا':'Wishlist — Stylevera'); ?>
<?php $__env->startSection('content'); ?>
<?php $locale=app()->getLocale(); ?>
<div class="sv-breadcrumb"><div class="container"><a href="<?php echo e(route('home')); ?>"><?php echo e($locale==='ar'?'الرئيسية':'Home'); ?></a><span>/</span><strong><?php echo e($locale==='ar'?'المفضلة':'Wishlist'); ?></strong></div></div>
<div class="container py-5">
  <h2 class="text-uppercase mb-5"><?php echo e($locale==='ar'?'المفضلة':'Wishlist'); ?></h2>
  <?php if($items->count()): ?>
  <div class="row g-4">
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($item->product): ?>
    <?php $p=$item->product; $dp=$p->getDisplayPrice(); ?>
    <div class="col-md-4 col-6">
      <div class="product-item image-zoom-effect link-effect">
        <div class="image-holder position-relative">
          <a href="<?php echo e(route('product.show',$p->slug)); ?>"><img src="<?php echo e(asset($p->getCoverImage())); ?>" alt="<?php echo e($p->nameLocale()); ?>" class="product-image img-fluid"></a>
          <a href="#" class="btn-icon btn-wishlist wishlisted" onclick="svToggleWishlist(<?php echo e($p->id); ?>,this);return false"><svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#heart"></use></svg></a>
          <div class="product-content">
            <h5 class="text-uppercase fs-5 mt-3"><a href="<?php echo e(route('product.show',$p->slug)); ?>"><?php echo e($p->nameLocale()); ?></a></h5>
            <a href="<?php echo e(route('product.show',$p->slug)); ?>" class="text-decoration-none"><span class="price-aed"><?php echo e(number_format($dp['sale']??$dp['price'],2)); ?> AED</span></a>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
  <?php else: ?>
  <div class="text-center py-5"><p style="color:#999"><?php echo e($locale==='ar'?'لا توجد منتجات في المفضلة.':'Your wishlist is empty.'); ?></p><a href="<?php echo e(route('shop')); ?>" class="btn btn-dark text-uppercase"><?php echo e($locale==='ar'?'تسوق الآن':'Shop Now'); ?></a></div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/frontend/wishlist.blade.php ENDPATH**/ ?>