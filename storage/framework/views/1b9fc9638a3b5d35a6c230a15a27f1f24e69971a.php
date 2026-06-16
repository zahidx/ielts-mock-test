<?php $__env->startSection('title','Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">
<?php if(session('info')): ?><div class="alert alert-info"><?php echo e(session('info')); ?></div><?php endif; ?>
<h4 class="mb-4"><i class="bi bi-speedometer2"></i> My Dashboard</h4>
<div class="row mb-4"><div class="col-md-8"><div class="card border-0 shadow-sm"><div class="card-header bg-white fw-bold">Available Tests</div><div class="card-body">
<?php $__empty_1 = true; $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded"><div><h6 class="mb-1"><?php echo e($test->title); ?></h6><small class="text-muted"><?php echo e($test->description); ?></small></div>
<form method="POST" action="<?php echo e(route('test.start',$test)); ?>"><?php echo csrf_field(); ?><button class="btn btn-primary" style="background:#003366;border:none;" onclick="return confirm('Start test? Timer begins immediately.')"><i class="bi bi-play-fill"></i> Start</button></form></div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><p class="text-muted mb-0">No tests available.</p><?php endif; ?></div></div></div>
<div class="col-md-4"><div class="card border-0 shadow-sm text-center p-4"><h2 class="text-primary"><?php echo e($attempts->where('status','completed')->count()); ?></h2><p class="text-muted mb-0">Tests Completed</p></div></div></div>
<?php if($attempts->where('status','completed')->count()): ?>
<div class="card border-0 shadow-sm"><div class="card-header bg-white fw-bold">My Results</div><div class="card-body p-0"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Test</th><th>Date</th><th>Listening</th><th>Reading</th><th>Writing</th></tr></thead><tbody>
<?php $__currentLoopData = $attempts->where('status','completed'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php $lr=$a->results->firstWhere('section.type','listening');$rr=$a->results->firstWhere('section.type','reading');$wr=$a->writingSubmission;?>
<tr><td><?php echo e($a->test->title); ?></td><td><?php echo e($a->created_at->format('d M Y')); ?></td><td><span class="badge bg-primary"><?php echo e($lr?$lr->band_score:'-'); ?></span></td><td><span class="badge bg-success"><?php echo e($rr?$rr->band_score:'-'); ?></span></td><td><span class="badge bg-warning text-dark"><?php echo e($wr&&$wr->band_score?$wr->band_score:'Pending'); ?></span></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody></table></div></div><?php endif; ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\ielts-mock-test\ielts-mock-test\resources\views/test/dashboard.blade.php ENDPATH**/ ?>