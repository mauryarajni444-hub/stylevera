<?php $locale=app()->getLocale(); ?>
<?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php
  $img = null;
  if ($item->variant) {
    $pm = $item->variant->media->where('is_primary',1)->first() ?: $item->variant->media->first();
    if ($pm) $img = $pm->url;
  }
  if (!$img && $item->product->cover_image && str_starts_with($item->product->cover_image,'http')) {
    $img = $item->product->cover_image;
  }
?>
<div class="sv-cart-item">
  <?php if($img): ?>
    <img src="<?php echo e($img); ?>" class="sv-cart-thumb" alt="<?php echo e($item->product->nameLocale()); ?>" onerror="this.style.background='#f5f5f5';this.src=''">
  <?php else: ?>
    <div class="sv-cart-thumb" style="background:linear-gradient(135deg,#f5f5f5,#ece9e4);display:flex;align-items:center;justify-content:center">
      <span style="font-family:'Marcellus',serif;font-size:1rem;color:rgba(140,144,126,0.5)">SV</span>
    </div>
  <?php endif; ?>
  <div class="flex-grow-1">
    <div style="font-size:13px;font-weight:600;color:var(--sv-text)"><?php echo e($item->product->nameLocale()); ?></div>
    <?php if($item->variant): ?><div style="font-size:11.5px;color:var(--sv-muted)"><?php echo e($item->variant->nameLocale()); ?></div><?php endif; ?>
    <div style="font-size:12.5px;color:var(--sv-primary);font-weight:600;margin-top:4px"><?php echo e(number_format($item->price,2)); ?> AED</div>
    <div class="sv-qty-wrap" style="margin-top:8px;display:flex;align-items:center;gap:8px">
      <button class="sv-qty-btn" data-item-id="<?php echo e($item->id); ?>" data-action="dec">−</button>
      <span style="font-size:13px;font-weight:700;min-width:20px;text-align:center"><?php echo e($item->quantity); ?></span>
      <button class="sv-qty-btn" data-item-id="<?php echo e($item->id); ?>" data-action="inc">+</button>
      <span style="font-size:12px;color:var(--sv-muted);margin-left:4px">= <?php echo e(number_format($item->price*$item->quantity,2)); ?> AED</span>
    </div>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<div style="text-align:center;padding:48px 20px;color:var(--sv-muted)">
  <i class="bi bi-bag" style="font-size:2.5rem;opacity:0.3;display:block;margin-bottom:10px"></i>
  <?php echo e($locale==='ar'?'السلة فارغة':'Your cart is empty'); ?>

</div>
<?php endif; ?>
<?php /**PATH F:\stylevera_project\resources\views/frontend/partials/cart-items.blade.php ENDPATH**/ ?>