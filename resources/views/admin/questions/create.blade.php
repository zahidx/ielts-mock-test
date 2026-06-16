@extends('layouts.app')
@section('title','Add Question')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')
<div class="col-md-10 py-4 px-4">@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card border-0 shadow-sm"><div class="card-header bg-white fw-bold">Add Question — {{ $section->title }}</div><div class="card-body">
<form method="POST" action="{{ route('admin.questions.store',[$test,$section]) }}">@csrf
<div class="row mb-3"><div class="col-md-2"><label class="form-label fw-semibold">Q# *</label>@php $n=$section->questions()->max('question_number')+1;@endphp<input type="number" name="question_number" class="form-control" value="{{ $n }}" required></div>
<div class="col-md-4"><label class="form-label fw-semibold">Type *</label><select name="question_type" id="qT" class="form-select" required onchange="tgl()"><option value="fill_blank">Fill Blank</option><option value="mcq">MCQ</option><option value="true_false_ng">True/False/NG</option><option value="matching">Matching</option><option value="short_answer">Short Answer</option></select></div>
<div class="col-md-6"><label class="form-label fw-semibold">Group Label</label><input type="text" name="group_label" class="form-control" placeholder="e.g. Section 1: Questions 1-10"></div></div>
<div class="mb-3"><label class="form-label fw-semibold">Question Text *</label><textarea name="question_text" class="form-control" rows="3" required></textarea></div>
<div class="mb-3"><label class="form-label fw-semibold">Correct Answer *</label><input type="text" name="correct_answer" class="form-control" required><small class="text-muted">MCQ/Matching: letter. T/F/NG: TRUE/FALSE/NOT GIVEN. Fill: text.</small></div>
<div id="opts" style="display:none"><label class="form-label fw-semibold">Options</label>
@foreach(['A','B','C','D'] as $l)<div class="row mb-2"><div class="col-md-1"><input type="text" name="option_labels[]" class="form-control" value="{{ $l }}" readonly></div><div class="col-md-11"><input type="text" name="option_texts[]" class="form-control" placeholder="Option {{ $l }}"></div></div>@endforeach</div>
<hr><button type="submit" class="btn btn-primary" style="background:#003366;border:none;"><i class="bi bi-check-lg"></i> Save</button>
<button type="submit" name="add_another" value="1" class="btn btn-outline-primary"><i class="bi bi-plus-lg"></i> Save & Add Another</button>
<a href="{{ route('admin.questions.index',[$test,$section]) }}" class="btn btn-outline-secondary ms-2">Cancel</a></form></div></div></div></div></div>
@push('scripts')<script>function tgl(){document.getElementById('opts').style.display=['mcq','matching'].includes(document.getElementById('qT').value)?'':'none'}tgl()</script>@endpush
@endsection