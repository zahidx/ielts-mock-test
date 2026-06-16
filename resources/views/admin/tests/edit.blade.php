@extends('layouts.app')
@section('title','Edit Test')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')
<div class="col-md-10 py-4 px-4"><div class="card border-0 shadow-sm"><div class="card-header bg-white fw-bold">Edit Test</div><div class="card-body">
<form method="POST" action="{{ route('admin.tests.update',$test) }}">@csrf @method('PUT')
<div class="mb-3"><label class="form-label fw-semibold">Title *</label><input type="text" name="title" class="form-control" value="{{ $test->title }}" required></div>
<div class="mb-3"><label class="form-label fw-semibold">Description</label><textarea name="description" class="form-control" rows="3">{{ $test->description }}</textarea></div>
<div class="mb-3"><div class="form-check"><input type="hidden" name="is_active" value="0"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $test->is_active?'checked':'' }}><label class="form-check-label">Active</label></div></div>
<button type="submit" class="btn btn-primary" style="background:#003366;border:none;">Save</button><a href="{{ route('admin.tests.show',$test) }}" class="btn btn-outline-secondary ms-2">Cancel</a></form></div></div></div></div></div>
@endsection