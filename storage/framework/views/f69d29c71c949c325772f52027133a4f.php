<?php $__env->startSection('title',app()->getLocale()==='ar'?'حسابي':'My Account'); ?>
<?php $__env->startSection('content'); ?>
<?php $l=app()->getLocale(); ?>
<div class="container py-5">
  <div class="row"><div class="col-md-8 mx-auto">
    <div class="sv-card">
      <h4 class="text-uppercase mb-4"><?php echo e($l==='ar'?'مرحباً,':'Hello,'); ?> <?php echo e($user->name); ?></h4>
      <p><?php echo e($user->email); ?></p>
      <div class="d-flex gap-3 mt-4">
        <a href="<?php echo e(route('account.orders')); ?>" class="btn btn-dark text-uppercase"><?php echo e($l==='ar'?'طلباتي':'My Orders'); ?></a>
        <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button class="btn btn-outline-dark text-uppercase"><?php echo e($l==='ar'?'تسجيل الخروج':'Logout'); ?></button></form>
      </div>
    </div>
  </div></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/frontend/account.blade.php ENDPATH**/ ?>