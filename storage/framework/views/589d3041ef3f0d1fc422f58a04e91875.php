<?php $__env->startSection('title',$page->titleLocale().' — Stylevera'); ?>
<?php $__env->startSection('content'); ?>
<div class="sv-breadcrumb"><div class="container"><a href="<?php echo e(route('home')); ?>"><?php echo e(app()->getLocale()==='ar'?'الرئيسية':'Home'); ?></a><span>/</span><strong><?php echo e($page->titleLocale()); ?></strong></div></div>
<div class="container py-5"><div class="row justify-content-center"><div class="col-lg-8"><?php echo $page->contentLocale(); ?></div></div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/frontend/page.blade.php ENDPATH**/ ?>