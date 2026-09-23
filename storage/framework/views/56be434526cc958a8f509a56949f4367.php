<?php $__env->startSection('title','Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-lg-3"><div class="sv-stat-card"><div class="sv-stat-icon sv-si-dark"><i class="bi bi-bag" style="font-size:1.3rem"></i></div><div><div class="sv-stat-val"><?php echo e($stats['total_orders']); ?></div><div class="sv-stat-label">Total Orders</div></div></div></div>
  <div class="col-sm-6 col-lg-3"><div class="sv-stat-card"><div class="sv-stat-icon sv-si-green"><i class="bi bi-currency-dollar" style="font-size:1.3rem"></i></div><div><div class="sv-stat-val"><?php echo e(number_format($stats['total_revenue'],0)); ?></div><div class="sv-stat-label">Revenue (AED)</div></div></div></div>
  <div class="col-sm-6 col-lg-3"><div class="sv-stat-card"><div class="sv-stat-icon sv-si-blue"><i class="bi bi-tag" style="font-size:1.3rem"></i></div><div><div class="sv-stat-val"><?php echo e($stats['total_products']); ?></div><div class="sv-stat-label">Products</div></div></div></div>
  <div class="col-sm-6 col-lg-3"><div class="sv-stat-card"><div class="sv-stat-icon sv-si-orange"><i class="bi bi-clock" style="font-size:1.3rem"></i></div><div><div class="sv-stat-val"><?php echo e($stats['pending_orders']); ?></div><div class="sv-stat-label">Pending Orders</div></div></div></div>
</div>
<div class="sv-card">
  <div class="sv-card-title">Recent Orders</div>
  <div style="overflow-x:auto">
    <table class="sv-table">
      <thead><tr><th>Ref</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
      <tbody>
        <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td><strong><?php echo e($o->ref_number); ?></strong></td>
          <td><?php echo e($o->guest_name); ?></td>
          <td><strong><?php echo e(number_format($o->total,2)); ?> AED</strong></td>
          <td><span class="sv-badge sv-b-<?php echo e($o->status); ?>"><?php echo e(ucfirst($o->status)); ?></span></td>
          <td style="color:#999"><?php echo e($o->created_at->format('d M Y')); ?></td>
          <td><a href="<?php echo e(route('admin.orders.show',$o->id)); ?>" class="btn btn-sm btn-outline-dark" style="font-size:11px">View</a></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>