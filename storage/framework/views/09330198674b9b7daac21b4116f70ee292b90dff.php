<div class="col-md-2 sidebar py-3">
    <nav class="nav flex-column">
        <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a class="nav-link <?php echo e(request()->routeIs('admin.tests*') || request()->routeIs('admin.sections*') || request()->routeIs('admin.questions*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.tests')); ?>"><i class="bi bi-journal-text"></i> Manage Tests</a>
        <a class="nav-link <?php echo e(request()->routeIs('admin.users*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.users')); ?>"><i class="bi bi-people"></i> Users</a>
        <a class="nav-link <?php echo e(request()->routeIs('admin.results*') || request()->routeIs('admin.attempt*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.results')); ?>"><i class="bi bi-clipboard-data"></i> Results</a>
    </nav>
</div><?php /**PATH D:\ielts-mock-test\ielts-mock-test\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>