@extends('layouts.app')
@section('title','Attempt Detail')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')
<div class="col-md-10 py-4 px-4">@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="d-flex justify-content-between mb-4"><div><h4>{{ $attempt->user->name }} <small class="text-muted">({{ $attempt->user->user_id }})</small></h4><p class="text-muted mb-0">{{ $attempt->test->title }} — {{ $attempt->created_at->format('d M Y') }}</p></div><a href="{{ route('admin.results') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="row mb-4">@foreach($attempt->results as $r)<div class="col-md-3"><div class="card border-0 shadow-sm text-center p-3"><h6 class="text-muted">{{ ucfirst($r->section->type) }}</h6><h2 class="text-primary">{{ $r->band_score }}</h2><small>{{ $r->correct_count }}/{{ $r->total_questions }}</small></div></div>@endforeach</div>
@foreach($attempt->test->sections()->whereIn('type',['listening','reading'])->orderBy('order')->get() as $sec)
<div class="card border-0 shadow-sm mb-4"><div class="card-header bg-white fw-bold">{{ ucfirst($sec->type) }} Answers</div><div class="card-body p-0"><table class="table table-sm mb-0"><thead class="table-light"><tr><th>#</th><th>Question</th><th>User</th><th>Correct</th><th></th></tr></thead><tbody>
@foreach($sec->questions as $q)@php $ans=$attempt->answers->firstWhere('question_id',$q->id);@endphp
<tr class="{{ $ans&&$ans->is_correct?'':'table-danger' }}"><td>{{ $q->question_number }}</td><td class="small">{{ Str::limit($q->question_text,80) }}</td><td><code>{{ $ans->answer_text??'—' }}</code></td><td><code>{{ $q->correct_answer }}</code></td><td>{!! $ans&&$ans->is_correct?'<span class="badge bg-success">✓</span>':'<span class="badge bg-danger">✗</span>' !!}</td></tr>@endforeach</tbody></table></div></div>@endforeach
@if($attempt->writingSubmission)<div class="card border-0 shadow-sm mb-4"><div class="card-header bg-white fw-bold">Writing</div><div class="card-body">
<h6>Task 1 ({{ $attempt->writingSubmission->task1_word_count }}w)</h6><div class="bg-light p-3 rounded mb-3" style="white-space:pre-wrap">{{ $attempt->writingSubmission->task1_response??'None' }}</div>
<h6>Task 2 ({{ $attempt->writingSubmission->task2_word_count }}w)</h6><div class="bg-light p-3 rounded mb-3" style="white-space:pre-wrap">{{ $attempt->writingSubmission->task2_response??'None' }}</div><hr>
<form method="POST" action="{{ route('admin.writing.score',$attempt->writingSubmission) }}" class="row g-3">@csrf
<div class="col-md-2"><label>Band</label><input type="number" step="0.5" min="0" max="9" name="band_score" class="form-control" value="{{ $attempt->writingSubmission->band_score }}"></div>
<div class="col-md-8"><label>Feedback</label><textarea name="admin_feedback" class="form-control" rows="2">{{ $attempt->writingSubmission->admin_feedback }}</textarea></div>
<div class="col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100" style="background:#003366;border:none;">Save</button></div></form></div></div>@endif
@if($attempt->recordings->count())<div class="card border-0 shadow-sm mb-4"><div class="card-header bg-white fw-bold">Speaking</div><div class="card-body">
@foreach($attempt->recordings as $rec)<div class="mb-3 p-3 bg-light rounded"><audio controls src="{{ asset('storage/'.$rec->file_path) }}" class="mb-2 d-block"></audio>
<form method="POST" action="{{ route('admin.speaking.score',$rec) }}" class="row g-2">@csrf<div class="col-auto"><input type="number" step="0.5" min="0" max="9" name="band_score" class="form-control form-control-sm" value="{{ $rec->band_score }}"></div><div class="col"><input type="text" name="admin_feedback" class="form-control form-control-sm" value="{{ $rec->admin_feedback }}"></div><div class="col-auto"><button class="btn btn-sm btn-primary">Save</button></div></form></div>@endforeach</div></div>@endif
</div></div></div>
@endsection