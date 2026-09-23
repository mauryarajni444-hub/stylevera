<?php $__env->startSection('title',app()->getLocale()==='ar'?'اتصل بنا — ستايل فيرا':'Contact — Stylevera'); ?>
<?php $__env->startSection('content'); ?>
<?php $locale=app()->getLocale(); ?>
<div class="sv-breadcrumb"><div class="container"><a href="<?php echo e(route('home')); ?>"><?php echo e($locale==='ar'?'الرئيسية':'Home'); ?></a><span>/</span><strong><?php echo e($locale==='ar'?'اتصل بنا':'Contact'); ?></strong></div></div>
<div class="container py-5">
  <div class="row g-5">
    <div class="col-lg-6">
      <h2 class="text-uppercase mb-4"><?php echo e($locale==='ar'?'تواصل معنا':'Get In Touch'); ?></h2>
      <form action="<?php echo e(route('contact.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="row g-3">
          <div class="col-sm-6"><label class="sv-label"><?php echo e($locale==='ar'?'الاسم':'Name'); ?></label><input name="name" class="sv-input" required></div>
          <div class="col-sm-6"><label class="sv-label"><?php echo e($locale==='ar'?'البريد':'Email'); ?></label><input name="email" type="email" class="sv-input" required></div>
          <div class="col-12"><label class="sv-label"><?php echo e($locale==='ar'?'الموضوع':'Subject'); ?></label><input name="subject" class="sv-input"></div>
          <div class="col-12"><label class="sv-label"><?php echo e($locale==='ar'?'الرسالة':'Message'); ?></label><textarea name="message" rows="5" class="sv-input" required></textarea></div>
          <div class="col-12"><button class="btn btn-dark text-uppercase w-100"><?php echo e($locale==='ar'?'إرسال':'Send Message'); ?></button></div>
        </div>
      </form>
    </div>
    <div class="col-lg-6">
      <h4 class="text-uppercase mb-4"><?php echo e($locale==='ar'?'معلومات التواصل':'Contact Info'); ?></h4>
      <p><?php echo e($settings->get('general.address_en','Dubai Mall Area, Dubai, UAE')); ?></p>
      <p><a href="mailto:<?php echo e($settings->get('general.email','info@stylevera.com')); ?>"><?php echo e($settings->get('general.email','info@stylevera.com')); ?></a></p>
      <p><a href="tel:<?php echo e($settings->get('general.phone','+971 4 000 0000')); ?>"><?php echo e($settings->get('general.phone','+971 4 000 0000')); ?></a></p>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/frontend/contact.blade.php ENDPATH**/ ?>