<?php $__env->startSection('title',app()->getLocale()==='ar'?'تأكيد الطلب':'Order Confirmed'); ?>
<?php $__env->startSection('content'); ?>
<?php $locale=app()->getLocale(); ?>
<div class="container py-5 text-center">
  <div style="max-width:600px;margin:0 auto">
    <div style="width:80px;height:80px;background:#27ae60;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-size:2rem;color:#fff">✓</div>
    <h2 class="text-uppercase"><?php echo e($locale==='ar'?'شكراً! تم استلام طلبك':'Thank You! Order Received'); ?></h2>
    <p style="color:#999;margin:12px 0 24px"><?php echo e($locale==='ar'?'رقم الطلب:':'Order Reference:'); ?> <strong style="color:var(--sv-text)"><?php echo e($order->ref_number); ?></strong></p>
    <div class="sv-card text-start mb-4">
      <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="d-flex justify-content-between mb-2" style="font-size:13px">
        <span><?php echo e($item->product_name); ?> <?php if($item->variant_name): ?><small style="color:#999"> / <?php echo e($item->variant_name); ?></small><?php endif; ?> × <?php echo e($item->quantity); ?></span>
        <span><?php echo e(number_format($item->total,2)); ?> AED</span>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <hr>
      <div class="d-flex justify-content-between fw-bold"><span><?php echo e($locale==='ar'?'الإجمالي':'Total'); ?></span><span><?php echo e(number_format($order->total,2)); ?> AED</span></div>
    </div>
    <a href="<?php echo e(route('home')); ?>" class="btn btn-dark text-uppercase me-2"><?php echo e($locale==='ar'?'الرئيسية':'Home'); ?></a>
    <a href="<?php echo e(route('shop')); ?>" class="btn btn-outline-dark text-uppercase"><?php echo e($locale==='ar'?'تسوق مجدداً':'Continue Shopping'); ?></a>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/frontend/order-confirm.blade.php ENDPATH**/ ?>