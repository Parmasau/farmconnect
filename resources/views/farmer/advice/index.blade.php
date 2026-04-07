{{-- resources/views/farmer/advice/index.blade.php --}}
@extends('layouts.app')

@section('title', 'My Advice Requests - FarmConnect')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>My Advice Requests</h1>
        <a href="{{ route('farmer.advice.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Request
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($advice->count() > 0)
        <div class="row">
            @foreach($advice as $request)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $request->subject }}</h5>
                            <span class="badge bg-{{ $request->status === 'resolved' ? 'success' : ($request->status === 'answered' ? 'info' : 'warning') }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ Str::limit($request->message, 150) }}</p>
                            @if($request->agrovet)
                                <div class="mb-2">
                                    <small class="text-muted">Assigned to: {{ $request->agrovet->name }}</small>
                                </div>
                            @endif
                            <small class="text-muted">{{ $request->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('farmer.advice.show', $request) }}" class="btn btn-sm btn-primary">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $advice->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-question-circle fa-4x text-muted mb-3"></i>
            <h3>No Advice Requests Yet</h3>
            <p class="text-muted">Have a farming question? Ask our agrovet experts for advice.</p>
            <a href="{{ route('farmer.advice.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ask for Advice
            </a>
        </div>
    @endif
</div>
@endsection