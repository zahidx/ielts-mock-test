@extends('layouts.app')
@section('title','Questions')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')
<div class="col-md-10 py-4 px-4">@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.tests') }}">Tests</a></li><li class="breadcrumb-item"><a href="{{ route('admin.tests.show',$test) }}">{{ $test->title }}</a></li><li class="breadcrumb-item active">{{ $section->title }}</li></ol></nav>
<div class="d-flex justify-content-between align-items-center mb-4"><h5><span class="badge bg-primary">{{ ucfirst($section->type) }}</span> {{ $section->title }} — {{ $section->questions->count() }} Qs</h5>
<div class="d-flex gap-2"><a href="{{ route('admin.questions.bulk',[$test,$section]) }}" class="btn btn-outline-success"><i class="bi bi-upload"></i> Bulk Import</a><a href="{{ route('admin.questions.create',[$test,$section]) }}" class="btn btn-primary" style="background:#003366;border:none;"><i class="bi bi-plus-lg"></i> Add Question</a></div></div>
<div class="card border-0 shadow-sm"><div class="card-body p-0"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>#</th><th>Question</th><th>Type</th><th>Answer</th><th>Group</th><th>Actions</th></tr></thead><tbody>
@forelse($section->questions as $q)<tr><td><strong>{{ $q->question_number }}</strong></td><td>{{ Str::limit($q->question_text,80) }}@if($q->options->count())<br><small class="text-muted">@foreach($q->options as $o){{ $o->label }}:{{ Str::limit($o->option_text,25) }} @endforeach</small>@endif</td><td><span class="badge bg-secondary">{{ $q->question_type }}</span></td><td><code>{{ $q->correct_answer }}</code></td><td><small>{{ $q->group_label }}</small></td>
<td><a href="{{ route('admin.questions.edit',[$test,$section,$q]) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a> <form method="POST" action="{{ route('admin.questions.delete',[$test,$section,$q]) }}" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form></td></tr>
@empty<tr><td colspan="6" class="text-muted text-center py-4">No questions yet.</td></tr>@endforelse</tbody></table></div></div>
<div class="mt-3"><a href="{{ route('admin.tests.show',$test) }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back</a></div></div></div></div>
@endsection