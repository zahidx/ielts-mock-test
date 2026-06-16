@extends('layouts.app')
@section('title',$test->title)
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')
<div class="col-md-10 py-4 px-4">@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.tests') }}">Tests</a></li><li class="breadcrumb-item active">{{ $test->title }}</li></ol></nav>
<div class="d-flex justify-content-between align-items-center mb-4"><div><h4 class="mb-1">{{ $test->title }}</h4><p class="text-muted mb-0">{{ $test->description }}</p></div>
<div class="d-flex gap-2"><a href="{{ route('admin.tests.edit',$test) }}" class="btn btn-outline-warning"><i class="bi bi-pencil"></i> Edit</a><a href="{{ route('admin.sections.create',$test) }}" class="btn btn-primary" style="background:#003366;border:none;"><i class="bi bi-plus-lg"></i> Add Section</a></div></div>
@forelse($test->sections as $section)<div class="card border-0 shadow-sm mb-3"><div class="card-header bg-white d-flex justify-content-between align-items-center">
<div><span class="badge bg-primary me-2">{{ ucfirst($section->type) }}</span><strong>{{ $section->title }}</strong><small class="text-muted ms-2">{{ $section->duration_minutes }}min | Order:{{ $section->order }}</small></div>
<div class="d-flex gap-2"><a href="{{ route('admin.questions.index',[$test,$section]) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-list-ol"></i> Questions ({{ $section->questions->count() }})</a>
<a href="{{ route('admin.sections.edit',[$test,$section]) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
<form method="POST" action="{{ route('admin.sections.delete',[$test,$section]) }}" class="d-inline" onsubmit="return confirm('Delete section?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form></div></div>
<div class="card-body py-2">@if($section->questions->count())<small class="text-success"><i class="bi bi-check-circle"></i> {{ $section->questions->count() }} questions</small>@else<small class="text-danger"><i class="bi bi-exclamation-circle"></i> No questions — <a href="{{ route('admin.questions.create',[$test,$section]) }}">Add</a></small>@endif</div></div>
@empty<div class="card border-0 shadow-sm"><div class="card-body text-center py-5"><p class="text-muted">No sections yet.</p><a href="{{ route('admin.sections.create',$test) }}" class="btn btn-primary" style="background:#003366;border:none;"><i class="bi bi-plus-lg"></i> Add First Section</a></div></div>@endforelse
</div></div></div>
@endsection