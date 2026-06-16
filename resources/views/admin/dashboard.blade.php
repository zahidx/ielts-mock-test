@extends('layouts.app')
@section('title','Admin Dashboard')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')
<div class="col-md-10 py-4 px-4"><h4 class="mb-4">Admin Dashboard</h4>
<div class="row mb-4">
<div class="col-md-4"><div class="card border-0 shadow-sm text-center p-4"><h2 class="text-primary">{{ $stats['users'] }}</h2><p class="text-muted mb-0">Users</p></div></div>
<div class="col-md-4"><div class="card border-0 shadow-sm text-center p-4"><h2 class="text-success">{{ $stats['tests'] }}</h2><p class="text-muted mb-0">Tests</p></div></div>
<div class="col-md-4"><div class="card border-0 shadow-sm text-center p-4"><h2 class="text-warning">{{ $stats['attempts'] }}</h2><p class="text-muted mb-0">Completed</p></div></div>
</div>
<div class="card border-0 shadow-sm"><div class="card-header bg-white fw-bold">Recent Completions</div><div class="card-body p-0"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>User</th><th>Test</th><th>Date</th><th>Action</th></tr></thead><tbody>
@forelse($recentAttempts as $a)<tr><td>{{ $a->user->name }}</td><td>{{ $a->test->title }}</td><td>{{ $a->created_at->format('d M Y') }}</td><td><a href="{{ route('admin.attempt',$a) }}" class="btn btn-sm btn-outline-primary">View</a></td></tr>
@empty<tr><td colspan="4" class="text-muted text-center py-3">No completed tests yet.</td></tr>@endforelse
</tbody></table></div></div></div></div></div>
@endsection