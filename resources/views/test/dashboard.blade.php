@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<div class="container py-4">
@if(session('info'))<div class="alert alert-info">{{ session('info') }}</div>@endif
<h4 class="mb-4"><i class="bi bi-speedometer2"></i> My Dashboard</h4>
<div class="row mb-4"><div class="col-md-8"><div class="card border-0 shadow-sm"><div class="card-header bg-white fw-bold">Available Tests</div><div class="card-body">
@forelse($tests as $test)<div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded"><div><h6 class="mb-1">{{ $test->title }}</h6><small class="text-muted">{{ $test->description }}</small></div>
<form method="POST" action="{{ route('test.start',$test) }}">@csrf<button class="btn btn-primary" style="background:#003366;border:none;" onclick="return confirm('Start test? Timer begins immediately.')"><i class="bi bi-play-fill"></i> Start</button></form></div>
@empty<p class="text-muted mb-0">No tests available.</p>@endforelse</div></div></div>
<div class="col-md-4"><div class="card border-0 shadow-sm text-center p-4"><h2 class="text-primary">{{ $attempts->where('status','completed')->count() }}</h2><p class="text-muted mb-0">Tests Completed</p></div></div></div>
@if($attempts->where('status','completed')->count())
<div class="card border-0 shadow-sm"><div class="card-header bg-white fw-bold">My Results</div><div class="card-body p-0"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Test</th><th>Date</th><th>Listening</th><th>Reading</th><th>Writing</th></tr></thead><tbody>
@foreach($attempts->where('status','completed') as $a)@php $lr=$a->results->firstWhere('section.type','listening');$rr=$a->results->firstWhere('section.type','reading');$wr=$a->writingSubmission;@endphp
<tr><td>{{ $a->test->title }}</td><td>{{ $a->created_at->format('d M Y') }}</td><td><span class="badge bg-primary">{{ $lr?$lr->band_score:'-' }}</span></td><td><span class="badge bg-success">{{ $rr?$rr->band_score:'-' }}</span></td><td><span class="badge bg-warning text-dark">{{ $wr&&$wr->band_score?$wr->band_score:'Pending' }}</span></td></tr>@endforeach
</tbody></table></div></div>@endif</div>
@endsection