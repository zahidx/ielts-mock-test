@extends('layouts.app')
@section('title','Create Test')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')
<div class="col-md-10 py-4 px-4"><nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('admin.tests') }}">Tests</a></li><li class="breadcrumb-item active">Create</li></ol></nav>
<div class="card border-0 shadow-sm"><div class="card-header bg-white fw-bold">Create New Mock Test</div><div class="card-body">
<form method="POST" action="{{ route('admin.tests.store') }}">@csrf
<div class="mb-3"><label class="form-label fw-semibold">Test Title *</label><input type="text" name="title" class="form-control" required></div>
<div class="mb-3"><label class="form-label fw-semibold">Description</label><textarea name="description" class="form-control" rows="3"></textarea></div>
<button type="submit" class="btn btn-primary" style="background:#003366;border:none;"><i class="bi bi-plus-lg"></i> Create Test</button>
<a href="{{ route('admin.tests') }}" class="btn btn-outline-secondary ms-2">Cancel</a></form></div></div></div></div></div>
@endsection