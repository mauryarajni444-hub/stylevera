<!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Admin Login — Stylevera</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Jost:wght@400;500;600&display=swap" rel="stylesheet">
<style>
body{min-height:100vh;display:flex;align-items:center;justify-content:center;background:#f1f1f0;font-family:'Jost',sans-serif}
.login-box{background:#fff;padding:40px;width:100%;max-width:400px;border:1px solid #e5e5e5;border-radius:6px}
.brand{font-family:'Marcellus',serif;font-size:1.6rem;letter-spacing:.05em;text-align:center;margin-bottom:8px}
.sub{font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#999;text-align:center;margin-bottom:32px}
input{width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:4px;font-size:13.5px;margin-bottom:14px;outline:none}
input:focus{border-color:#8C907E;box-shadow:0 0 0 3px rgba(140,144,126,.12)}
button{width:100%;padding:12px;background:#111;color:#fff;border:none;font-size:12px;letter-spacing:2px;text-transform:uppercase;cursor:pointer;border-radius:4px}
button:hover{background:#8C907E}
.err{background:rgba(231,76,60,.1);border-left:3px solid #e74c3c;padding:10px;font-size:12px;color:#7b241c;margin-bottom:14px;border-radius:3px}
</style></head><body>
<div class="login-box">
  <div class="brand">STYLEVERA</div>
  <div class="sub">Admin Panel</div>
  <?php if(session('error')): ?><div class="err"><?php echo e(session('error')); ?></div><?php endif; ?>
  <form method="POST" action="<?php echo e(route('admin.login.post')); ?>">
    <?php echo csrf_field(); ?>
    <input type="email" name="email" placeholder="Email" value="<?php echo e(old('email')); ?>" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Sign In</button>
  </form>
</div>
</body></html>
<?php /**PATH F:\stylevera_project\resources\views/admin/login.blade.php ENDPATH**/ ?>