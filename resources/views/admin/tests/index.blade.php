@extends('layouts.app')
@section('title','Manage Tests')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')
<div class="col-md-10 py-4 px-4">@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="d-flex justify-content-between align-items-center mb-4"><h4 class="mb-0">Manage Tests</h4><a href="{{ route('admin.tests.create') }}" class="btn btn-primary" style="background:#003366;border:none;"><i class="bi bi-plus-lg"></i> Create New Test</a></div>
<div class="card border-0 shadow-sm"><div class="card-body p-0"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>ID</th><th>Title</th><th>Sections</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead><tbody>
@forelse($tests as $test)<tr><td>{{ $test->id }}</td><td><a href="{{ route('admin.tests.show',$test) }}" class="fw-bold text-decoration-none">{{ $test->title }}</a></td><td><span class="badge bg-secondary">{{ $test->sections_count }}</span></td>
<td><form method="POST" action="{{ route('admin.tests.toggle',$test) }}" class="d-inline">@csrf<button type="submit" class="badge border-0 {{ $test->is_active?'bg-success':'bg-danger' }}" style="cursor:pointer">{{ $test->is_active?'Active':'Inactive' }}</button></form></td>
<td>{{ $test->created_at->format('d M Y') }}</td><td><a href="{{ route('admin.tests.show',$test) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a> <a href="{{ route('admin.tests.edit',$test) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a> <form method="POST" action="{{ route('admin.tests.delete',$test) }}" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form></td></tr>
@empty<tr><td colspan="6" class="text-center text-muted py-4">No tests yet.</td></tr>@endforelse</tbody></table></div></div></div></div></div>
@endsection