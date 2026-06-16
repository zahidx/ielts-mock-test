@extends('layouts.app')
@section('title','Users')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')
<div class="col-md-10 py-4 px-4">
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card border-0 shadow-sm mb-4"><div class="card-header bg-white fw-bold">Create New User</div><div class="card-body">
<form method="POST" action="{{ route('admin.users.create') }}" class="row g-3">@csrf
<div class="col-md-3"><input type="text" name="user_id" class="form-control" placeholder="User ID" required></div>
<div class="col-md-3"><input type="text" name="name" class="form-control" placeholder="Full Name" required></div>
<div class="col-md-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
<div class="col-md-3"><button class="btn btn-primary w-100" style="background:#003366;border:none;">Create</button></div>
</form>@if($errors->any())<div class="text-danger mt-2">{{ $errors->first() }}</div>@endif</div></div>
<div class="card border-0 shadow-sm"><div class="card-header bg-white fw-bold">All Users ({{ $users->count() }})</div><div class="card-body p-0"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>User ID</th><th>Name</th><th>Created</th><th>Tests</th><th>Action</th></tr></thead><tbody>
@foreach($users as $u)<tr><td><code>{{ $u->user_id }}</code></td><td>{{ $u->name }}</td><td>{{ $u->created_at->format('d M Y') }}</td><td>{{ $u->testAttempts()->where('status','completed')->count() }}</td><td><form method="POST" action="{{ route('admin.users.delete',$u) }}" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@endforeach
</tbody></table></div></div></div></div></div>
@endsection