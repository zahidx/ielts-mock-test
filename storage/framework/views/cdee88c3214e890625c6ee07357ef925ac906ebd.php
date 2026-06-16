<?php $__env->startSection('title','Users'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid"><div class="row"><?php echo $__env->make('admin.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="col-md-10 py-4 px-4">
<?php if(session('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?>
<div class="card border-0 shadow-sm mb-4"><div class="card-header bg-white fw-bold">Create New User</div><div class="card-body">
<form method="POST" action="<?php echo e(route('admin.users.create')); ?>" class="row g-3"><?php echo csrf_field(); ?>
<div class="col-md-3"><input type="text" name="user_id" class="form-control" placeholder="User ID" required></div>
<div class="col-md-3"><input type="text" name="name" class="form-control" placeholder="Full Name" required></div>
<div class="col-md-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
<div class="col-md-3"><button class="btn btn-primary w-100" style="background:#003366;border:none;">Create</button></div>
</form><?php if($errors->any()): ?><div class="text-danger mt-2"><?php echo e($errors->first()); ?></div><?php endif; ?></div></div>
<div class="card border-0 shadow-sm"><div class="card-header bg-white fw-bold">All Users (<?php echo e($users->count()); ?>)</div><div class="card-body p-0"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>User ID</th><th>Name</th><th>Created</th><th>Tests</th><th>Action</th></tr></thead><tbody>
<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><code><?php echo e($u->user_id); ?></code></td><td><?php echo e($u->name); ?></td><td><?php echo e($u->created_at->format('d M Y')); ?></td><td><?php echo e($u->testAttempts()->where('status','completed')->count()); ?></td><td><form method="POST" action="<?php echo e(route('admin.users.delete',$u)); ?>" class="d-inline" onsubmit="return confirm('Delete?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody></table></div></div></div></div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ielts-mock-test\ielts-mock-test\resources\views/admin/users.blade.php ENDPATH**/ ?>