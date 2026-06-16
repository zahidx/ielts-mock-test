@extends('layouts.app')
@section('title','Results')
@section('content')
<div class="container-fluid"><div class="row">@include('admin.partials.sidebar')
<div class="col-md-10 py-4 px-4"><h4 class="mb-4">All Results</h4><div class="card border-0 shadow-sm"><div class="card-body p-0"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>User</th><th>Test</th><th>Date</th><th>Listening</th><th>Reading</th><th>Writing</th><th>Action</th></tr></thead><tbody>
@forelse($attempts as $a)@php $lr=$a->results->firstWhere('section.type','listening');$rr=$a->results->firstWhere('section.type','reading');@endphp
<tr><td>{{ $a->user->name }}</td><td>{{ $a->test->title }}</td><td>{{ $a->created_at->format('d M Y') }}</td><td>{{ $lr?$lr->band_score:'-' }}</td><td>{{ $rr?$rr->band_score:'-' }}</td><td>{{ $a->writingSubmission&&$a->writingSubmission->band_score?$a->writingSubmission->band_score:'Pending' }}</td><td><a href="{{ route('admin.attempt',$a) }}" class="btn btn-sm btn-primary" style="background:#003366;border:none;">Details</a></td></tr>
@empty<tr><td colspan="7" class="text-muted text-center py-3">No results.</td></tr>@endforelse</tbody></table></div></div></div></div></div>
@endsection