<?php $__env->startSection('title','Settings'); ?>
<?php $__env->startSection('content'); ?>
<form method="POST" action="<?php echo e(route('admin.settings.update')); ?>">
  <?php echo csrf_field(); ?>
  <div class="row g-4">
    <div class="col-lg-6">
      <div class="sv-card mb-4">
        <div class="sv-card-title">General</div>
        <div class="row g-3">
          <?php $__currentLoopData = [['general.store_name_en','Store Name (EN)'],['general.store_name_ar','Store Name (AR)'],['general.email','Email'],['general.phone','Phone'],['general.address_en','Address (EN)'],['general.address_ar','Address (AR)'],['general.shipping_fee','Shipping Fee (AED)'],['general.free_shipping_above','Free Shipping Above (AED)']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$k,$label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="col-12"><label class="admin-label"><?php echo e($label); ?></label><input name="settings[<?php echo e($k); ?>]" class="admin-input" value="<?php echo e($settings->get($k,'')); ?>" <?php echo e(str_contains($k,'_ar')?'dir=rtl':''); ?>></div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
      <div class="sv-card">
        <div class="sv-card-title">Announcements</div>
        <div class="row g-3">
          <div class="col-12"><label class="admin-label">Announcement (EN)</label><textarea name="settings[announcement_en.text]" class="admin-input" rows="3"><?php echo e($settings->get('announcement_en.text','')); ?></textarea></div>
          <div class="col-12"><label class="admin-label">Announcement (AR)</label><textarea name="settings[announcement_ar.text]" class="admin-input" rows="3" dir="rtl"><?php echo e($settings->get('announcement_ar.text','')); ?></textarea></div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="sv-card">
        <div class="sv-card-title">Social Media</div>
        <div class="row g-3">
          <?php $__currentLoopData = [['social.instagram','Instagram URL'],['social.facebook','Facebook URL'],['social.twitter','Twitter URL'],['social.pinterest','Pinterest URL']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$k,$label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="col-12"><label class="admin-label"><?php echo e($label); ?></label><input name="settings[<?php echo e($k); ?>]" class="admin-input" value="<?php echo e($settings->get($k,'')); ?>"></div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </div>
    <div class="col-12"><button class="btn btn-dark text-uppercase px-5">Save All Settings</button></div>
  </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>