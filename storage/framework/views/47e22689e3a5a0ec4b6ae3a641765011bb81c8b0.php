<?php $__env->startSection('title','Admin Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid"><div class="row"><?php echo $__env->make('admin.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="col-md-10 py-4 px-4"><h4 class="mb-4">Admin Dashboard</h4>
<div class="row mb-4">
<div class="col-md-4"><div class="card border-0 shadow-sm text-center p-4"><h2 class="text-primary"><?php echo e($stats['users']); ?></h2><p class="text-muted mb-0">Users</p></div></div>
<div class="col-md-4"><div class="card border-0 shadow-sm text-center p-4"><h2 class="text-success"><?php echo e($stats['tests']); ?></h2><p class="text-muted mb-0">Tests</p></div></div>
<div class="col-md-4"><div class="card border-0 shadow-sm text-center p-4"><h2 class="text-warning"><?php echo e($stats['attempts']); ?></h2><p class="text-muted mb-0">Completed</p></div></div>
</div>
<div class="card border-0 shadow-sm"><div class="card-header bg-white fw-bold">Recent Completions</div><div class="card-body p-0"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>User</th><th>Test</th><th>Date</th><th>Action</th></tr></thead><tbody>
<?php $__empty_1 = true; $__currentLoopData = $recentAttempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><?php echo e($a->user->name); ?></td><td><?php echo e($a->test->title); ?></td><td><?php echo e($a->created_at->format('d M Y')); ?></td><td><a href="<?php echo e(route('admin.attempt',$a)); ?>" class="btn btn-sm btn-outline-primary">View</a></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="4" class="text-muted text-center py-3">No completed tests yet.</td></tr><?php endif; ?>
</tbody></table></div></div></div></div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ielts-mock-test\ielts-mock-test\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>