<?php $__env->startSection('title','Categories'); ?>
<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4"><div></div><a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-dark text-uppercase" style="font-size:12px">+ Add Category</a></div>
    <div class="sv-card"><div style="overflow-x:auto"><table class="sv-table">
                <thead><tr><th>Image</th><th>Name EN</th><th>Name AR</th><th>Products</th><th>Status</th><th></th></tr></thead>
                <tbody><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php if($c->image): ?><img src="<?php echo e($c->image); ?>" style="width:40px;height:40px;object-fit:cover"><?php else: ?><div style="width:40px;height:40px;background:#f1f1f0;border-radius:4px"></div><?php endif; ?></td>
                        <td><strong><?php echo e($c->name_en); ?></strong></td><td dir="rtl"><?php echo e($c->name_ar); ?></td>
                        <td><?php echo e($c->products_count); ?></td>
                        <td><span class="sv-badge <?php echo e($c->is_active?'sv-b-active':'sv-b-inactive'); ?>"><?php echo e($c->is_active?'Active':'Inactive'); ?></span></td>
                        <td>
                            <a href="<?php echo e(route('admin.categories.edit',$c)); ?>" class="btn btn-sm btn-success" style="font-size:11px">Edit</a>
                            <form method="POST" action="<?php echo e(route('admin.categories.destroy',$c)); ?>" style="display:inline" onsubmit="return confirm('Delete?')"><?php echo csrf_field(); ?><button class="btn btn-sm btn-outline-danger" style="font-size:11px">Del</button></form>
                        </td>
                    </tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tbody>
            </table></div><div class="mt-3"><?php echo e($categories->links()); ?></div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>