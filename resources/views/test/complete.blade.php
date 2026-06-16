@extends('layouts.app')
@section('title','Test Complete')
@section('content')
<div class="container py-5"><div class="text-center mb-4"><img src="{{ asset('images/logo.png') }}" style="height:64px;border-radius:8px" class="mb-3"><h3>Test Completed!</h3><p class="text-muted">{{ $attempt->test->title }} — {{ $attempt->created_at->format('d M Y, h:i A') }}</p></div>
<div class="row justify-content-center"><div class="col-md-8"><div class="card border-0 shadow"><div class="card-body"><h5 class="mb-3">Your Results</h5>
<table class="table"><thead><tr><th>Section</th><th>Score</th><th>Band</th></tr></thead><tbody>
@foreach($attempt->results as $r)<tr><td>{{ ucfirst($r->section->type) }}</td><td>{{ $r->correct_count }}/{{ $r->total_questions }}</td><td><span class="badge bg-primary fs-6">{{ $r->band_score }}</span></td></tr>@endforeach
@if($attempt->writingSubmission)<tr><td>Writing</td><td>{{ $attempt->writingSubmission->task1_word_count + $attempt->writingSubmission->task2_word_count }} words</td><td><span class="badge bg-warning text-dark">{{ $attempt->writingSubmission->band_score ?? 'Pending' }}</span></td></tr>@endif
</tbody></table></div></div>
<div class="text-center mt-4"><a href="{{ route('user.dashboard') }}" class="btn btn-primary" style="background:#003366;border:none;"><i class="bi bi-arrow-left"></i> Back to Dashboard</a></div></div></div></div>
@endsection