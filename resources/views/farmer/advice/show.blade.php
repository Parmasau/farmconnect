{{-- resources/views/farmer/advice/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Advice Request Details - FarmConnect')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('farmer.advice.index') }}">Advice</a></li>
            <li class="breadcrumb-item active">Request Details</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $advice->subject }}</h5>
                    <span class="badge bg-{{ $advice->status === 'resolved' ? 'success' : ($advice->status === 'answered' ? 'info' : 'warning') }}">
                        {{ ucfirst($advice->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6>Your Question:</h6>
                        <p class="mb-0">{{ $advice->message }}</p>
                        <small class="text-muted">Posted: {{ $advice->created_at->format('M d, Y g:i A') }}</small>
                    </div>

                    @if($advice->response)
                        <div class="bg-light p-4 rounded">
                            <h6>Response from {{ $advice->agrovet->name ?? 'Agrovet' }}:</h6>
                            <p class="mb-0">{{ $advice->response }}</p>
                            <small class="text-muted">Responded: {{ $advice->responded_at ? $advice->responded_at->format('M d, Y g:i A') : $advice->updated_at->format('M d, Y g:i A') }}</small>
                        </div>
                    @elseif($advice->status === 'pending')
                        <div class="alert alert-info">
                            <i class="fas fa-clock"></i> Your request is pending. An agrovet expert will respond shortly.
                        </div>
                    @elseif($advice->status === 'assigned')
                        <div class="alert alert-info">
                            <i class="fas fa-user-check"></i> Your request has been assigned to {{ $advice->agrovet->name ?? 'an agrovet' }}. They will respond soon.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Request Information</h6>
                </div>
                <div class="card-body">
                    <p><strong>Status:</strong> {{ ucfirst($advice->status) }}</p>
                    <p><strong>Created:</strong> {{ $advice->created_at->diffForHumans() }}</p>
                    @if($advice->agrovet)
                        <p><strong>Assigned to:</strong> {{ $advice->agrovet->name }}</p>
                    @endif
                    @if($advice->responded_at)
                        <p><strong>Responded:</strong> {{ $advice->responded_at->diffForHumans() }}</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Need More Help?</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted">If you need additional assistance:</p>
                    <a href="{{ route('farmer.advice.create') }}" class="btn btn-primary btn-sm w-100 mb-2">
                        Ask Another Question
                    </a>
                    <a href="{{ route('farmer.consultations.create') }}" class="btn btn-outline-primary btn-sm w-100">
                        Request Consultation
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection