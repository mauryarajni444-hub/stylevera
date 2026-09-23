<?php $__env->startSection('title','Order: '.$order->ref_number); ?>
<?php $__env->startSection('content'); ?>
<div class="row g-4">
  <div class="col-lg-8">
    <div class="sv-card mb-4">
      <div class="sv-card-title">Order Items</div>
      <table class="sv-table">
        <thead><tr><th>Product</th><th>Variant</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead>
        <tbody><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr><td><?php echo e($i->product_name); ?></td><td><?php echo e($i->variant_name); ?></td><td><?php echo e($i->quantity); ?></td><td><?php echo e(number_format($i->price,2)); ?> AED</td><td><strong><?php echo e(number_format($i->total,2)); ?> AED</strong></td></tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tbody>
      </table>
      <div style="text-align:right;padding:12px;border-top:1px solid #eee">
        <div>Subtotal: <?php echo e(number_format($order->subtotal,2)); ?> AED</div>
        <div>Shipping: <?php echo e(number_format($order->shipping_fee,2)); ?> AED</div>
        <?php if($order->discount): ?><div>Discount: -<?php echo e(number_format($order->discount,2)); ?> AED</div><?php endif; ?>
        <div style="font-weight:700;font-size:1.1rem;margin-top:8px">Total: <?php echo e(number_format($order->total,2)); ?> AED</div>
      </div>
    </div>
    <div class="sv-card">
      <div class="sv-card-title">Update Status</div>
      <form method="POST" action="<?php echo e(route('admin.orders.status',$order->id)); ?>">
        <?php echo csrf_field(); ?>
        <div class="row g-3">
          <div class="col-md-6"><select name="status" class="admin-select"><?php $__currentLoopData = ['pending','confirmed','processing','shipped','delivered','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s); ?>" <?php echo e($order->status===$s?'selected':''); ?>><?php echo e(ucfirst($s)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
          <div class="col-md-6"><button class="btn btn-dark text-uppercase w-100" style="font-size:12px">Update Status</button></div>
          <div class="col-12"><label class="admin-label">Admin Notes</label><textarea name="admin_notes" class="admin-input" rows="3"><?php echo e($order->admin_notes); ?></textarea></div>
        </div>
      </form>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="sv-card">
      <div class="sv-card-title">Customer</div>
      <p><strong><?php echo e($order->guest_name); ?></strong></p>
      <p style="color:#999"><?php echo e($order->guest_email); ?></p>
      <p style="color:#999"><?php echo e($order->guest_phone); ?></p>
      <hr>
      <p style="font-size:12px"><strong>Address:</strong><br><?php echo e($order->shipping_address); ?><br><?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_country); ?></p>
      <?php if($order->notes): ?><hr><p style="font-size:12px"><strong>Notes:</strong> <?php echo e($order->notes); ?></p><?php endif; ?>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>