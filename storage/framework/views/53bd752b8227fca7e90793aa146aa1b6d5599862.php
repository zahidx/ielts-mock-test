<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(ucfirst($section->type)); ?> - IELTS Mock Test by UKG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        *{box-sizing:border-box}body{margin:0;overflow:hidden;height:100vh;font-family:'Segoe UI',Tahoma,sans-serif;background:#f5f5f5}
        .test-topbar{background:#003366;color:#fff;height:52px;display:flex;align-items:center;justify-content:space-between;padding:0 20px;z-index:100}
        .test-topbar .logo{height:32px;margin-right:12px;border-radius:4px}
        .test-topbar .section-name{font-size:16px;font-weight:600;text-transform:uppercase;letter-spacing:1px}
        .timer-box{background:rgba(255,255,255,.15);padding:6px 18px;border-radius:6px;font-size:18px;font-weight:700;font-variant-numeric:tabular-nums}
        .timer-box.warning{background:#dc3545;animation:pulse 1s infinite}
        @keyframes pulse{50%{opacity:.7}}
        .test-body{display:flex;height:calc(100vh - 52px - 56px)}
        .panel-left{width:50%;overflow-y:auto;padding:24px;background:#fff;border-right:2px solid #dee2e6}
        .panel-right{width:50%;overflow-y:auto;padding:24px;background:#fafbfc}
        .panel-full{width:100%;overflow-y:auto;padding:24px;background:#fff}
        .q-group{margin-bottom:24px;padding-bottom:16px;border-bottom:1px solid #eee}
        .q-group-label{font-weight:700;color:#003366;margin-bottom:12px;font-size:14px;text-transform:uppercase}
        .question-item{margin-bottom:16px;padding:12px;border-radius:8px;transition:background .2s}
        .question-item:hover{background:#f0f4ff}
        .q-num{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;background:#003366;color:#fff;border-radius:50%;font-size:13px;font-weight:700;margin-right:8px;flex-shrink:0}
        .q-text{font-size:15px;margin-bottom:8px}
        .option-row{display:flex;align-items:flex-start;gap:8px;padding:6px 8px;margin-bottom:4px;border-radius:6px;cursor:pointer}
        .option-row:hover{background:#e8f0fe}
        .option-label{font-weight:600;color:#003366;min-width:20px}
        .fill-input{border:none;border-bottom:2px solid #003366;outline:none;padding:4px 8px;font-size:15px;width:200px;background:transparent}
        .fill-input:focus{border-bottom-color:#0066cc;background:#f0f4ff}
        .passage-content{font-size:15px;line-height:1.8;color:#333}
        .highlight-yellow{background:#fff59d}.highlight-green{background:#a5d6a7}.highlight-blue{background:#90caf9}.highlight-pink{background:#f48fb1}
        .highlight-bar{position:sticky;top:0;background:#fff;padding:8px 0;border-bottom:1px solid #ddd;margin-bottom:16px;z-index:10;display:flex;gap:8px;align-items:center}
        .hl-btn{width:28px;height:28px;border-radius:50%;border:2px solid #ccc;cursor:pointer;transition:transform .15s}
        .hl-btn:hover{transform:scale(1.2)}.hl-btn.active{border-color:#333;box-shadow:0 0 0 2px rgba(0,0,0,.2)}
        .q-nav{position:fixed;bottom:0;left:0;right:0;background:#fff;border-top:2px solid #003366;padding:10px 20px;display:flex;align-items:center;justify-content:space-between;z-index:100}
        .q-nav-numbers{display:flex;gap:4px;flex-wrap:wrap}
        .q-nav-num{width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:4px;border:1px solid #ccc;font-size:12px;font-weight:600;cursor:pointer;background:#fff}
        .q-nav-num.answered{background:#003366;color:#fff;border-color:#003366}
        .audio-container{background:#003366;color:#fff;padding:20px;border-radius:12px;margin-bottom:20px}
        .audio-container audio{width:100%;margin-top:10px}
        .writing-area{width:100%;min-height:300px;border:1px solid #ccc;border-radius:8px;padding:16px;font-size:15px;line-height:1.8;resize:vertical}
        .word-count{font-size:14px;color:#666;margin-top:4px}
        .record-btn{width:80px;height:80px;border-radius:50%;border:none;font-size:28px;cursor:pointer}
        .record-btn.idle{background:#dc3545;color:#fff}.record-btn.recording{background:#dc3545;color:#fff;animation:pulse .8s infinite}
        .save-indicator{position:fixed;top:60px;right:20px;padding:6px 14px;border-radius:20px;font-size:12px;z-index:200;transition:opacity .3s}
        .save-indicator.saving{background:#ffc107;color:#333}.save-indicator.saved{background:#28a745;color:#fff}
    </style>
</head>
<body>
    <div class="test-topbar">
        <div class="d-flex align-items-center">
            <img src="<?php echo e(asset('images/logo.png')); ?>" class="logo" alt="UKG">
            <span class="section-name"><?php echo e($section->title); ?></span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="timer-box" id="timer"><?php echo e(sprintf('%02d', $section->duration_minutes)); ?>:00</div>
            <span class="text-white-50 small"><?php echo e(auth()->user()->name); ?></span>
        </div>
    </div>
    <div class="save-indicator" id="saveIndicator" style="opacity:0">Saved</div>

    <div class="test-body">
        <?php if($section->type === 'listening'): ?>
        <div class="panel-left" id="questionsPanel">
            <?php echo $__env->make('test.partials.questions', ['questions' => $section->questions, 'existingAnswers' => $existingAnswers], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="panel-right">
            <div class="audio-container">
                <h6><i class="bi bi-headphones"></i> Listening Audio</h6>
                <p class="small mb-2 opacity-75">Listen carefully. You may replay during practice.</p>
                <audio id="listeningAudio" controls controlsList="nodownload"><source src="<?php echo e(asset($section->content)); ?>" type="audio/mpeg"></audio>
            </div>
        </div>
        <?php elseif($section->type === 'reading'): ?>
        <div class="panel-left" id="questionsPanel">
            <?php echo $__env->make('test.partials.questions', ['questions' => $section->questions, 'existingAnswers' => $existingAnswers], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="panel-right">
            <div class="highlight-bar">
                <span class="small fw-bold text-muted me-2">Highlight:</span>
                <div class="hl-btn" style="background:#fff59d" data-color="highlight-yellow"></div>
                <div class="hl-btn" style="background:#a5d6a7" data-color="highlight-green"></div>
                <div class="hl-btn" style="background:#90caf9" data-color="highlight-blue"></div>
                <div class="hl-btn" style="background:#f48fb1" data-color="highlight-pink"></div>
                <button class="btn btn-sm btn-outline-secondary ms-2" id="clearHighlights"><i class="bi bi-eraser"></i> Clear</button>
            </div>
            <div class="passage-content" id="passageContent"><?php echo nl2br(e($section->content)); ?></div>
        </div>
        <?php elseif($section->type === 'writing'): ?>
        <div class="panel-full">
            <ul class="nav nav-tabs mb-3"><li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#task1Tab">Task 1</a></li><li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#task2Tab">Task 2</a></li></ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="task1Tab">
                    <div class="card mb-3 border-primary"><div class="card-body"><h6 class="text-primary">Writing Task 1</h6><p><?php echo e($section->content); ?></p><small class="text-muted">Spend about 20 minutes. Write at least 150 words.</small></div></div>
                    <textarea class="writing-area" id="task1"><?php echo e($writingSub->task1_response ?? ''); ?></textarea>
                    <div class="word-count">Word count: <strong id="wc1"><?php echo e($writingSub->task1_word_count ?? 0); ?></strong></div>
                </div>
                <div class="tab-pane fade" id="task2Tab">
                    <div class="card mb-3 border-primary"><div class="card-body"><h6 class="text-primary">Writing Task 2</h6><p><?php echo e($section->content_extra); ?></p><small class="text-muted">Spend about 40 minutes. Write at least 250 words.</small></div></div>
                    <textarea class="writing-area" id="task2"><?php echo e($writingSub->task2_response ?? ''); ?></textarea>
                    <div class="word-count">Word count: <strong id="wc2"><?php echo e($writingSub->task2_word_count ?? 0); ?></strong></div>
                </div>
            </div>
        </div>
        <?php elseif($section->type === 'speaking'): ?>
        <div class="panel-full text-center py-5">
            <h5>Speaking Test</h5>
            <p class="text-muted mb-4"><?php echo e($section->content); ?></p>
            <button class="record-btn idle" id="recordBtn"><i class="bi bi-mic-fill"></i></button>
            <p class="mt-3" id="recordStatus">Ready to record</p>
            <div id="recordingsList" class="mt-4"></div>
        </div>
        <?php endif; ?>
    </div>

    <div class="q-nav">
        <div class="q-nav-numbers" id="qNav">
            <?php if(in_array($section->type, ['listening','reading'])): ?>
            <?php $__currentLoopData = $section->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="q-nav-num <?php echo e(isset($existingAnswers[$q->id]) ? 'answered' : ''); ?>" data-q="<?php echo e($q->id); ?>" onclick="scrollToQuestion(<?php echo e($q->id); ?>)"><?php echo e($q->question_number); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <?php $__currentLoopData = $allSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($s->id === $section->id): ?><span class="badge bg-primary px-3 py-2"><?php echo e(ucfirst($s->type)); ?></span>
                <?php elseif($s->order < $section->order): ?><span class="badge bg-success px-3 py-2"><i class="bi bi-check"></i> <?php echo e(ucfirst($s->type)); ?></span>
                <?php else: ?><span class="badge bg-secondary px-3 py-2"><?php echo e(ucfirst($s->type)); ?></span><?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <form method="POST" action="<?php echo e(route('test.submit-section', ['attempt'=>$attempt->id,'section'=>$section->id])); ?>" id="submitForm"><?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-warning fw-bold" onclick="return confirm('Submit this section?')">Next <i class="bi bi-arrow-right"></i></button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const CSRF=document.querySelector('meta[name="csrf-token"]').content,ATTEMPT_ID=<?php echo e($attempt->id); ?>,SECTION_ID=<?php echo e($section->id); ?>;
    let timeLeft=<?php echo e($section->duration_minutes); ?>*60;const timerEl=document.getElementById('timer');
    const timerInterval=setInterval(()=>{timeLeft--;const m=Math.floor(timeLeft/60),s=timeLeft%60;timerEl.textContent=`${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;if(timeLeft<=60)timerEl.classList.add('warning');if(timeLeft<=0){clearInterval(timerInterval);document.getElementById('submitForm').submit()}},1000);
    function showSave(st){const el=document.getElementById('saveIndicator');el.className='save-indicator '+st;el.textContent=st==='saving'?'Saving...':'Saved ✓';el.style.opacity=1;if(st==='saved')setTimeout(()=>el.style.opacity=0,1500)}
    function saveAnswer(qid,val){showSave('saving');fetch('<?php echo e(route("test.save-answer")); ?>',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},body:JSON.stringify({attempt_id:ATTEMPT_ID,question_id:qid,answer_text:val})}).then(()=>{showSave('saved');updateNavDot(qid,val)})}
    document.querySelectorAll('input[type="radio"]').forEach(r=>r.addEventListener('change',e=>saveAnswer(e.target.name.replace('q_',''),e.target.value)));
    document.querySelectorAll('.fill-input').forEach(inp=>{let d;inp.addEventListener('input',e=>{clearTimeout(d);d=setTimeout(()=>saveAnswer(e.target.dataset.qid,e.target.value),800)})});
    document.querySelectorAll('select.tf-select').forEach(sel=>sel.addEventListener('change',e=>saveAnswer(e.target.dataset.qid,e.target.value)));
    function clearAnswer(qid){fetch('<?php echo e(route("test.clear-answer")); ?>',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},body:JSON.stringify({attempt_id:ATTEMPT_ID,question_id:qid})}).then(()=>{document.querySelectorAll(`input[name="q_${qid}"]`).forEach(r=>r.checked=false);const fi=document.querySelector(`.fill-input[data-qid="${qid}"]`);if(fi)fi.value='';const sel=document.querySelector(`select[data-qid="${qid}"]`);if(sel)sel.value='';updateNavDot(qid,'');showSave('saved')})}
    function updateNavDot(qid,val){const d=document.querySelector(`.q-nav-num[data-q="${qid}"]`);if(d)d.classList.toggle('answered',val&&val.trim()!=='')}
    function scrollToQuestion(qid){const el=document.getElementById('q-'+qid);if(el)el.scrollIntoView({behavior:'smooth',block:'center'})}
    <?php if($section->type==='reading'): ?>
    let activeColor=null;document.querySelectorAll('.hl-btn[data-color]').forEach(btn=>{btn.addEventListener('click',()=>{document.querySelectorAll('.hl-btn').forEach(b=>b.classList.remove('active'));if(activeColor===btn.dataset.color){activeColor=null;return}activeColor=btn.dataset.color;btn.classList.add('active')})});
    document.getElementById('passageContent').addEventListener('mouseup',()=>{if(!activeColor)return;const sel=window.getSelection();if(!sel.rangeCount||sel.isCollapsed)return;const range=sel.getRangeAt(0),span=document.createElement('span');span.className=activeColor;try{range.surroundContents(span)}catch(e){}sel.removeAllRanges()});
    document.getElementById('clearHighlights').addEventListener('click',()=>{document.getElementById('passageContent').querySelectorAll('span[class^="highlight-"]').forEach(s=>{const p=s.parentNode;while(s.firstChild)p.insertBefore(s.firstChild,s);p.removeChild(s)})});
    <?php endif; ?>
    <?php if($section->type==='writing'): ?>
    function countWords(t){return t.trim()?t.trim().split(/\s+/).length:0}let wd;['task1','task2'].forEach(id=>{const el=document.getElementById(id);if(!el)return;const wc=document.getElementById(id==='task1'?'wc1':'wc2');el.addEventListener('input',()=>{wc.textContent=countWords(el.value);clearTimeout(wd);wd=setTimeout(()=>{showSave('saving');fetch('<?php echo e(route("test.save-writing")); ?>',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},body:JSON.stringify({attempt_id:ATTEMPT_ID,section_id:SECTION_ID,task1_response:document.getElementById('task1').value,task2_response:document.getElementById('task2').value})}).then(()=>showSave('saved'))},1500)})});
    <?php endif; ?>
    <?php if($section->type==='speaking'): ?>
    let mediaRecorder,audioChunks=[];const recordBtn=document.getElementById('recordBtn'),recordStatus=document.getElementById('recordStatus');recordBtn.addEventListener('click',async()=>{if(!mediaRecorder||mediaRecorder.state==='inactive'){const stream=await navigator.mediaDevices.getUserMedia({audio:true});mediaRecorder=new MediaRecorder(stream);audioChunks=[];mediaRecorder.ondataavailable=e=>audioChunks.push(e.data);mediaRecorder.onstop=()=>{const blob=new Blob(audioChunks,{type:'audio/webm'}),fd=new FormData();fd.append('audio',blob,'recording.webm');fd.append('attempt_id',ATTEMPT_ID);fetch('<?php echo e(route("test.save-recording")); ?>',{method:'POST',headers:{'X-CSRF-TOKEN':CSRF},body:fd}).then(()=>{showSave('saved');const a=document.createElement('audio');a.src=URL.createObjectURL(blob);a.controls=true;a.className='mb-2 d-block mx-auto';document.getElementById('recordingsList').prepend(a)})};mediaRecorder.start();recordBtn.className='record-btn recording';recordBtn.innerHTML='<i class="bi bi-stop-fill"></i>';recordStatus.textContent='Recording...'}else{mediaRecorder.stop();mediaRecorder.stream.getTracks().forEach(t=>t.stop());recordBtn.className='record-btn idle';recordBtn.innerHTML='<i class="bi bi-mic-fill"></i>';recordStatus.textContent='Saved. Click to record again.'}});
    <?php endif; ?>
    </script>
</body>
</html>
<?php /**PATH D:\ielts-mock-test\ielts-mock-test\resources\views/test/section.blade.php ENDPATH**/ ?>