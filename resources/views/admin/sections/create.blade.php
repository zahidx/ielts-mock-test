@extends('layouts.app')
@section('title','Add Section')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')
<div class="col-md-10 py-4 px-4"><nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.tests') }}">Tests</a></li><li class="breadcrumb-item"><a href="{{ route('admin.tests.show',$test) }}">{{ $test->title }}</a></li><li class="breadcrumb-item active">Add Section</li></ol></nav>
<div class="card border-0 shadow-sm"><div class="card-header bg-white fw-bold">Add New Section</div><div class="card-body">
<form method="POST" action="{{ route('admin.sections.store',$test) }}" enctype="multipart/form-data">@csrf
<div class="row mb-3"><div class="col-md-4"><label class="form-label fw-semibold">Type *</label><select name="type" id="sType" class="form-select" required onchange="toggle()"><option value="">--</option><option value="listening">Listening</option><option value="reading">Reading</option><option value="writing">Writing</option><option value="speaking">Speaking</option></select></div>
<div class="col-md-4"><label class="form-label fw-semibold">Title *</label><input type="text" name="title" class="form-control" required></div>
<div class="col-md-4"><label class="form-label fw-semibold">Duration (min) *</label><input type="number" name="duration_minutes" class="form-control" value="30" min="1" required></div></div>
<div id="fListen" style="display:none" class="mb-3"><label class="form-label fw-semibold">Upload Audio (MP3)</label><input type="file" name="audio_file" class="form-control" accept="audio/*"><small class="text-muted">Or set path below</small></div>
<div id="fListenPath" style="display:none" class="mb-3"><label class="form-label fw-semibold">Audio path</label><input type="text" name="content" class="form-control" placeholder="audio/file.mp3"></div>
<div id="fRead" style="display:none" class="mb-3"><label class="form-label fw-semibold">Reading Passage</label><textarea name="content" class="form-control" rows="12"></textarea></div>
<div id="fWrite1" style="display:none" class="mb-3"><label class="form-label fw-semibold">Task 1 Prompt</label><textarea name="content" class="form-control" rows="4"></textarea></div>
<div id="fWrite2" style="display:none" class="mb-3"><label class="form-label fw-semibold">Task 2 Prompt</label><textarea name="content_extra" class="form-control" rows="4"></textarea></div>
<div id="fSpeak" style="display:none" class="mb-3"><label class="form-label fw-semibold">Speaking Prompts</label><textarea name="content" class="form-control" rows="6"></textarea></div>
<button type="submit" class="btn btn-primary" style="background:#003366;border:none;"><i class="bi bi-plus-lg"></i> Add Section</button>
<a href="{{ route('admin.tests.show',$test) }}" class="btn btn-outline-secondary ms-2">Cancel</a></form></div></div></div></div></div>
@push('scripts')<script>function toggle(){const t=document.getElementById('sType').value;['fListen','fListenPath','fRead','fWrite1','fWrite2','fSpeak'].forEach(x=>document.getElementById(x).style.display='none');if(t==='listening'){document.getElementById('fListen').style.display='';document.getElementById('fListenPath').style.display=''}if(t==='reading')document.getElementById('fRead').style.display='';if(t==='writing'){document.getElementById('fWrite1').style.display='';document.getElementById('fWrite2').style.display=''}if(t==='speaking')document.getElementById('fSpeak').style.display='';const d=document.querySelector('[name=duration_minutes]');if(t==='listening')d.value=30;if(t==='reading'||t==='writing')d.value=60;if(t==='speaking')d.value=15}</script>@endpush
@endsection