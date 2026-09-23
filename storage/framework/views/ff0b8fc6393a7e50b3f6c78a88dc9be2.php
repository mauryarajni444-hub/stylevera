<?php $__env->startSection('title','Contacts'); ?>
<?php $__env->startSection('content'); ?>
<div class="sv-card"><div style="overflow-x:auto"><table class="sv-table">
<thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Read</th><th>Date</th><th></th></tr></thead>
<tbody><?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr style="<?php echo e(!$c->is_read?'background:#fffbf0':''); ?>">
  <td><strong><?php echo e($c->name); ?></strong></td>
  <td style="color:#999"><?php echo e($c->email); ?></td>
  <td><?php echo e($c->subject); ?></td>
  <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?php echo e($c->message); ?></td>
  <td><span class="sv-badge <?php echo e($c->is_read?'sv-b-active':'sv-b-pending'); ?>"><?php echo e($c->is_read?'Read':'New'); ?></span></td>
  <td style="color:#999;white-space:nowrap"><?php echo e($c->created_at->format('d M Y')); ?></td>
  <td>
    <?php if(!$c->is_read): ?><form method="POST" action="<?php echo e(route('admin.contacts.read',$c->id)); ?>" style="display:inline"><?php echo csrf_field(); ?><button class="btn btn-sm btn-outline-dark" style="font-size:11px">Mark Read</button></form><?php endif; ?>
    <form method="POST" action="<?php echo e(route('admin.contacts.destroy',$c->id)); ?>" style="display:inline" onsubmit="return confirm('Delete?')"><?php echo csrf_field(); ?>@method('DELETE')<button class="btn btn-sm btn-outline-danger" style="font-size:11px">Del</button></form>
  </td>
</tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tbody>
</table></div><div class="mt-3"><?php echo e($contacts->links()); ?></div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/admin/contacts/index.blade.php ENDPATH**/ ?>