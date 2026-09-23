<?php $__env->startSection('title',app()->getLocale()==='ar'?'طلباتي':'My Orders'); ?>
<?php $__env->startSection('content'); ?>
<?php $l=app()->getLocale(); ?>
<div class="container py-5">
  <h4 class="text-uppercase mb-4"><?php echo e($l==='ar'?'طلباتي':'My Orders'); ?></h4>
  <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
  <div class="sv-card mb-3">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <strong><?php echo e($order->ref_number); ?></strong>
        <small style="color:#999;display:block"><?php echo e($order->created_at->format('d M Y')); ?></small>
      </div>
      <div class="text-end">
        <span class="sv-badge sv-b-<?php echo e($order->status); ?>"><?php echo e(ucfirst($order->status)); ?></span>
        <div class="mt-1" style="font-weight:600"><?php echo e(number_format($order->total,2)); ?> AED</div>
      </div>
    </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
  <p style="color:#999"><?php echo e($l==='ar'?'لا توجد طلبات بعد.':'No orders yet.'); ?></p>
  <?php endif; ?>
  <?php echo e($orders->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/frontend/account-orders.blade.php ENDPATH**/ ?>