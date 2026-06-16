<?php $grouped = $questions->groupBy('group_label'); ?>
<?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $groupQuestions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="q-group">
    <?php if($label): ?><div class="q-group-label"><?php echo e($label); ?></div><?php endif; ?>
    <?php $__currentLoopData = $groupQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="question-item" id="q-<?php echo e($q->id); ?>">
        <div class="d-flex align-items-start">
            <span class="q-num"><?php echo e($q->question_number); ?></span>
            <div class="flex-grow-1">
                <div class="q-text"><?php echo nl2br(e($q->question_text)); ?></div>
                <?php if($q->question_type === 'mcq'): ?>
                    <?php $__currentLoopData = $q->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="option-row">
                        <input type="radio" name="q_<?php echo e($q->id); ?>" value="<?php echo e($opt->label); ?>" <?php echo e((isset($existingAnswers[$q->id]) && $existingAnswers[$q->id]===$opt->label) ? 'checked' : ''); ?>>
                        <span class="option-label"><?php echo e($opt->label); ?>.</span><span><?php echo e($opt->option_text); ?></span>
                    </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php elseif($q->question_type === 'true_false_ng'): ?>
                    <select class="form-select form-select-sm tf-select" data-qid="<?php echo e($q->id); ?>" style="width:200px">
                        <option value="">-- Select --</option>
                        <?php $__currentLoopData = ['TRUE','FALSE','NOT GIVEN']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($v); ?>" <?php echo e((isset($existingAnswers[$q->id]) && $existingAnswers[$q->id]===$v) ? 'selected' : ''); ?>><?php echo e($v); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                <?php elseif(in_array($q->question_type, ['fill_blank','short_answer'])): ?>
                    <input type="text" class="fill-input" data-qid="<?php echo e($q->id); ?>" value="<?php echo e($existingAnswers[$q->id] ?? ''); ?>" placeholder="Type your answer">
                <?php elseif($q->question_type === 'matching'): ?>
                    <?php if($q->options->count()): ?>
                    <select class="form-select form-select-sm tf-select" data-qid="<?php echo e($q->id); ?>" style="width:300px">
                        <option value="">-- Select --</option>
                        <?php $__currentLoopData = $q->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($opt->label); ?>" <?php echo e((isset($existingAnswers[$q->id]) && $existingAnswers[$q->id]===$opt->label) ? 'selected' : ''); ?>><?php echo e($opt->label); ?>. <?php echo e($opt->option_text); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php else: ?>
                    <input type="text" class="fill-input" data-qid="<?php echo e($q->id); ?>" value="<?php echo e($existingAnswers[$q->id] ?? ''); ?>" placeholder="Type your answer">
                    <?php endif; ?>
                <?php endif; ?>
                <button class="btn btn-sm btn-outline-secondary mt-1" onclick="clearAnswer(<?php echo e($q->id); ?>)"><i class="bi bi-x-circle"></i> Clear</button>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH D:\ielts-mock-test\ielts-mock-test\resources\views/test/partials/questions.blade.php ENDPATH**/ ?>