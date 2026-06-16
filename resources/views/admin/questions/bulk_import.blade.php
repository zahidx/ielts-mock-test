@extends('layouts.app')
@section('title','Bulk Import')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')
<div class="col-md-10 py-4 px-4"><div class="card border-0 shadow-sm"><div class="card-header bg-white fw-bold">Bulk Import — {{ $section->title }}</div><div class="card-body">
<div class="alert alert-info"><strong>Format:</strong> <code>number|question_text|type|correct_answer|group_label|A:opt|B:opt|C:opt|D:opt</code><br><br>
<strong>Types:</strong> fill_blank, mcq, true_false_ng, matching, short_answer<br><br><strong>Examples:</strong>
<pre class="mb-0" style="font-size:13px">1|What is the name?|fill_blank|Smith|Section 1
2|Main topic?|mcq|B|Section 2|A:Tourism|B:Education|C:Health
3|Study was in 2019.|true_false_ng|TRUE|Questions 6-9</pre></div>
<form method="POST" action="{{ route('admin.questions.bulk.import',[$test,$section]) }}">@csrf
<div class="mb-3"><label class="form-label fw-semibold">Paste Questions</label><textarea name="questions_data" class="form-control" rows="15" required style="font-family:monospace;font-size:13px"></textarea></div>
<button type="submit" class="btn btn-primary" style="background:#003366;border:none;"><i class="bi bi-upload"></i> Import</button>
<a href="{{ route('admin.questions.index',[$test,$section]) }}" class="btn btn-outline-secondary ms-2">Cancel</a></form></div></div></div></div></div>
@endsection