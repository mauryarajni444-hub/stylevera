<?php $__env->startSection('title','Admin Users'); ?>
<?php $__env->startSection('content'); ?>
<div class="row g-4">
  <div class="col-lg-5">
    <div class="sv-card">
      <div class="sv-card-title">Create Admin User</div>
      <form method="POST" action="<?php echo e(route('admin.users.store')); ?>"><?php echo csrf_field(); ?>
        <div class="row g-3">
          <div class="col-12"><label class="admin-label">Name</label><input name="name" class="admin-input" required></div>
          <div class="col-12"><label class="admin-label">Email</label><input name="email" type="email" class="admin-input" required></div>
          <div class="col-12"><label class="admin-label">Password</label><input name="password" type="password" class="admin-input" required minlength="8"></div>
          <div class="col-12"><label class="admin-label">Role</label><select name="role" class="admin-select"><option value="admin">Admin</option><option value="master_admin">Master Admin</option></select></div>
          <div class="col-12"><button class="btn btn-dark text-uppercase w-100">Create Admin</button></div>
        </div>
      </form>
    </div>
  </div>
  <div class="col-lg-7"><div class="sv-card"><table class="sv-table">
    <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr></thead>
    <tbody><?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
      <td><strong><?php echo e($u->name); ?></strong></td>
      <td style="color:#999"><?php echo e($u->email); ?></td>
      <td><span class="sv-badge <?php echo e($u->role==='master_admin'?'sv-b-blue':'sv-b-confirmed'); ?>"><?php echo e(ucfirst($u->role)); ?></span></td>
      <td><span class="sv-badge <?php echo e($u->is_active?'sv-b-active':'sv-b-inactive'); ?>"><?php echo e($u->is_active?'Active':'Off'); ?></span></td>
      <td>
        <?php if($u->id !== auth()->id()): ?>
        <form method="POST" action="<?php echo e(route('admin.users.destroy',$u->id)); ?>" onsubmit="return confirm('Delete?')"><?php echo csrf_field(); ?>@method('DELETE')<button class="btn btn-sm btn-outline-danger" style="font-size:11px">Del</button></form>
        <?php else: ?><small style="color:#999">You</small><?php endif; ?>
      </td>
    </tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tbody>
  </table><div class="mt-3"><?php echo e($users->links()); ?></div></div></div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/admin/users/index.blade.php ENDPATH**/ ?>