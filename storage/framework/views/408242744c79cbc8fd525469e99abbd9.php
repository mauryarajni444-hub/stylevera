<?php $__env->startSection('title','Orders'); ?>
<?php $__env->startSection('content'); ?>
<div class="sv-card mb-3">
  <form method="GET" class="d-flex gap-2 flex-wrap">
    <input name="search" class="admin-input" style="max-width:200px" placeholder="Ref / Email" value="<?php echo e(request('search')); ?>">
    <select name="status" class="admin-select" style="max-width:160px" onchange="this.form.submit()">
      <option value="">All Status</option>
      <?php $__currentLoopData = ['pending','confirmed','processing','shipped','delivered','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($s); ?>" <?php echo e(request('status')===$s?'selected':''); ?>><?php echo e(ucfirst($s)); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <button class="btn btn-dark text-uppercase" style="font-size:12px">Search</button>
  </form>
</div>
<div class="sv-card"><div style="overflow-x:auto"><table class="sv-table">
<thead><tr><th>Ref</th><th>Customer</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th></th></tr></thead>
<tbody><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
  <td><strong><?php echo e($o->ref_number); ?></strong></td>
  <td><?php echo e($o->guest_name); ?><br><small style="color:#999"><?php echo e($o->guest_email); ?></small></td>
  <td><strong><?php echo e(number_format($o->total,2)); ?> AED</strong></td>
  <td><span class="sv-badge sv-b-<?php echo e($o->payment_status); ?>"><?php echo e(ucfirst($o->payment_status)); ?></span></td>
  <td><span class="sv-badge sv-b-<?php echo e($o->status); ?>"><?php echo e(ucfirst($o->status)); ?></span></td>
  <td style="color:#999"><?php echo e($o->created_at->format('d M Y')); ?></td>
  <td>
    <a href="<?php echo e(route('admin.orders.show',$o->id)); ?>" class="btn btn-sm btn-outline-dark" style="font-size:11px">View</a>
    <form method="POST" action="<?php echo e(route('admin.orders.destroy',$o->id)); ?>" style="display:inline" onsubmit="return confirm('Delete?')"><?php echo csrf_field(); ?>@method('DELETE')<button class="btn btn-sm btn-outline-danger" style="font-size:11px">Del</button></form>
  </td>
</tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tbody>
</table></div><div class="mt-3"><?php echo e($orders->links()); ?></div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>