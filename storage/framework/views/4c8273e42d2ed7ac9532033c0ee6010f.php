<?php $__env->startSection('content'); ?>
<style>
    .gs-lb-wrap {
        min-height: 100vh;
        background: radial-gradient(ellipse at top, #2b2416 0%, #0a0806 60%, #050403 100%);
        padding: 50px 16px 60px;
        display: flex; flex-direction: column; align-items: center;
    }
    .gs-lb-title {
        font-family: 'Marcellus', serif; font-size: 2.2rem; letter-spacing: 3px;
        color: #C9A84C; margin-bottom: 30px; text-align: center;
    }
    .gs-lb-list { width: 100%; max-width: 520px; }
    .gs-lb-row {
        display: flex; align-items: center; gap: 16px;
        background: rgba(255,255,255,0.04); border: 1px solid rgba(201,168,76,0.15);
        border-radius: 12px; padding: 14px 18px; margin-bottom: 10px;
        font-family: 'Jost', sans-serif; color: #f0e6c8;
    }
    .gs-lb-row.gold { border-color: rgba(201,168,76,0.6); background: rgba(201,168,76,0.08); }
    .gs-lb-rank { font-family: 'Marcellus', serif; font-size: 1.3rem; color: #C9A84C; width: 32px; }
    .gs-lb-name { flex: 1; font-size: 15px; }
    .gs-lb-score { font-weight: 700; font-size: 16px; }
    .gs-lb-empty { color: #9a8c66; text-align: center; margin-top: 20px; }
    .gs-lb-back {
        margin-top: 26px; color: #C9A84C; text-decoration: none; font-size: 13px;
        border: 1px solid rgba(201,168,76,0.4); padding: 10px 26px; border-radius: 30px;
    }
</style>
<div class="gs-lb-wrap">
    <div class="gs-lb-title">🏆 GOLDEN SLICE — LEADERBOARD</div>
    <div class="gs-lb-list">
        <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="gs-lb-row <?php echo e($i === 0 ? 'gold' : ''); ?>">
                <div class="gs-lb-rank"><?php echo e($i + 1); ?></div>
                <div class="gs-lb-name"><?php echo e($row->user->name ?? 'Player'); ?></div>
                <div class="gs-lb-score"><?php echo e(number_format($row->best_score)); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="gs-lb-empty">No scores yet — be the first to play!</div>
        <?php endif; ?>
    </div>
    <a href="<?php echo e(route('game.play')); ?>" class="gs-lb-back">← Back to Game</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\stylevera_project\resources\views/frontend/game-leaderboard.blade.php ENDPATH**/ ?>