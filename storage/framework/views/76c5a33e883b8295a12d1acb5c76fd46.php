<?php $__env->startSection('title',app()->getLocale()==='ar'?'تسجيل الدخول':'Login'); ?>
<?php $__env->startSection('content'); ?>
<?php $l=app()->getLocale(); ?>
<div class="container py-5"><div class="row justify-content-center"><div class="col-md-5">
  <div class="sv-card">
    <h4 class="text-uppercase mb-4"><?php echo e($l==='ar'?'تسجيل الدخول':'Login'); ?></h4>
    <form method="POST" action="<?php echo e(route('login.post')); ?>">
      <?php echo csrf_field(); ?>
      <div class="mb-3"><label class="sv-label"><?php echo e($l==='ar'?'البريد الإلكتروني':'Email'); ?></label><input name="email" type="email" class="sv-input" required></div>
      <div class="mb-3"><label class="sv-label"><?php echo e($l==='ar'?'كلمة المرور':'Password'); ?></label><input name="password" type="password" class="sv-input" required></div>
      <button class="btn btn-dark w-100 text-uppercase"><?php echo e($l==='ar'?'دخول':'Login'); ?></button>
    </form>
    <p class="text-center mt-3" style="font-size:13px"><?php echo e($l==='ar'?'ليس لديك حساب؟':'No account?'); ?> <a href="<?php echo e(route('register')); ?>"><?php echo e($l==='ar'?'سجل الآن':'Register</a>'); ?></p>
  </div>
</div></div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/frontend/login.blade.php ENDPATH**/ ?>