<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'IELTS Mock Test by UKG'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root{--ielts-blue:#003366;--ielts-light:#e8f0fe;--ielts-accent:#0066cc}
        body{font-family:'Segoe UI',Tahoma,sans-serif;background:#f0f2f5}
        .navbar-brand img{height:40px;border-radius:4px}.navbar{background:var(--ielts-blue)!important}
        .sidebar{background:#fff;min-height:calc(100vh - 56px);border-right:1px solid #dee2e6}
        .sidebar .nav-link{color:#333;padding:12px 20px;border-left:3px solid transparent;font-size:14px}
        .sidebar .nav-link:hover{background:#f8f9fa}
        .sidebar .nav-link.active{background:var(--ielts-light);border-left-color:var(--ielts-accent);color:var(--ielts-accent);font-weight:600}
        .sidebar .nav-link i{width:20px;text-align:center;margin-right:8px}
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <nav class="navbar navbar-dark px-3">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo e(auth()->check() && auth()->user()->is_admin ? route('admin.dashboard') : route('user.dashboard')); ?>">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="UKG"> IELTS Mock Test by UKG
        </a>
        <?php if(auth()->guard()->check()): ?>
        <div class="d-flex align-items-center gap-3">
            <span class="text-white"><i class="bi bi-person-circle"></i> <?php echo e(auth()->user()->name); ?></span>
            <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button class="btn btn-outline-light btn-sm">Logout</button></form>
        </div>
        <?php endif; ?>
    </nav>
    <main><?php echo $__env->yieldContent('content'); ?></main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\ielts-mock-test\ielts-mock-test\resources\views/layouts/app.blade.php ENDPATH**/ ?>