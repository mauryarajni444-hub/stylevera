<?php $__env->startSection('title','Products'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <div></div>
  <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-dark text-uppercase" style="font-size:12px">+ Add Product</a>
</div>
<div class="sv-card">
  <div style="overflow-x:auto">
    <table class="sv-table">
      <thead><tr><th>Product</th><th>Category</th><th>Price</th><th>Variants</th><th>Status</th><th></th></tr></thead>
      <tbody>
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              <img src="<?php echo e(asset($p->getCoverImage())); ?>" style="width:40px;height:52px;object-fit:cover;border:1px solid #eee">
              <div><strong style="font-size:13px"><?php echo e($p->name_en); ?></strong><br><small style="color:#999"><?php echo e($p->name_ar); ?></small></div>
            </div>
          </td>
          <td style="color:#999"><?php echo e($p->category?->name_en); ?></td>
          <td><strong><?php echo e(number_format($p->base_price,2)); ?> AED</strong></td>
          <td><span class="sv-badge sv-b-confirmed"><?php echo e($p->variants_count); ?> variants</span></td>
          <td><span class="sv-badge <?php echo e($p->is_active?'sv-b-active':'sv-b-inactive'); ?>"><?php echo e($p->is_active?'Active':'Inactive'); ?></span></td>
          <td>
            <a href="<?php echo e(route('admin.products.edit',$p->id)); ?>" class="btn btn-sm btn-success" style="font-size:11px;border-radius: 3px">Edit</a>
            <form method="POST" action="<?php echo e(route('admin.products.destroy',$p->id)); ?>" style="display:inline" onsubmit="return confirm('Delete?')"><?php echo csrf_field(); ?><button class="btn btn-sm btn-outline-danger" style="font-size:11px;border-radius: 3px">Del</button></form>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </div>
  <div class="mt-3"><?php echo e($products->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/admin/products/index.blade.php ENDPATH**/ ?>