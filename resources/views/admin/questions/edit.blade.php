@extends('layouts.app')
@section('title','Edit Question')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')
<div class="col-md-10 py-4 px-4"><div class="card border-0 shadow-sm"><div class="card-header bg-white fw-bold">Edit Q#{{ $question->question_number }}</div><div class="card-body">
<form method="POST" action="{{ route('admin.questions.update',[$test,$section,$question]) }}">@csrf @method('PUT')
<div class="row mb-3"><div class="col-md-2"><label class="form-label">Q#</label><input type="number" name="question_number" class="form-control" value="{{ $question->question_number }}" required></div>
<div class="col-md-3"><label class="form-label">Type</label><select name="question_type" id="qT" class="form-select" onchange="tgl()">@foreach(['fill_blank','mcq','true_false_ng','matching','short_answer'] as $t)<option value="{{ $t }}" {{ $question->question_type===$t?'selected':'' }}>{{ $t }}</option>@endforeach</select></div>
<div class="col-md-3"><label class="form-label">Answer</label><input type="text" name="correct_answer" class="form-control" value="{{ $question->correct_answer }}"></div>
<div class="col-md-2"><label class="form-label">Order</label><input type="number" name="order" class="form-control" value="{{ $question->order }}"></div></div>
<div class="mb-3"><label class="form-label">Group</label><input type="text" name="group_label" class="form-control" value="{{ $question->group_label }}"></div>
<div class="mb-3"><label class="form-label">Question *</label><textarea name="question_text" class="form-control" rows="3" required>{{ $question->question_text }}</textarea></div>
<div id="opts" style="display:{{ in_array($question->question_type,['mcq','matching'])?'':'none' }}"><label class="form-label fw-semibold">Options</label>
@php $opts=$question->options;@endphp @foreach(['A','B','C','D'] as $l)<div class="row mb-2"><div class="col-md-1"><input type="text" name="option_labels[]" class="form-control" value="{{ $l }}" readonly></div><div class="col-md-11"><input type="text" name="option_texts[]" class="form-control" value="{{ $opts->where('label',$l)->first()->option_text ?? '' }}"></div></div>@endforeach</div>
<hr><button type="submit" class="btn btn-primary" style="background:#003366;border:none;">Save</button><a href="{{ route('admin.questions.index',[$test,$section]) }}" class="btn btn-outline-secondary ms-2">Cancel</a></form></div></div></div></div></div>
@push('scripts')<script>function tgl(){document.getElementById('opts').style.display=['mcq','matching'].includes(document.getElementById('qT').value)?'':'none'}</script>@endpush
@endsection