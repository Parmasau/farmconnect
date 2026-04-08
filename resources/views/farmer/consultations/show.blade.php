@extends('layouts.dashboard')

@section('title', 'Consultation Details - FarmConnect')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow">
        <!-- Header -->
        <div class="p-4 border-b flex items-center gap-3">
            <a href="{{ route('farmer.consultations.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h2 class="font-semibold text-lg">{{ $consultation->topic }}</h2>
                <p class="text-xs text-gray-500">Requested {{ $consultation->created_at->diffForHumans() }}</p>
            </div>
            <div class="ml-auto">
               <span class="px-3 py-1 text-sm rounded-full 
    {{ $consultation->status === 'completed' ? 'bg-green-100 text-green-700' : 
       ($consultation->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : 
       ($consultation->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700')) }}">
    {{ ucfirst($consultation->status) }}
</span>
            </div>
        </div>

        <!-- Consultation Details -->
        <div class="p-4 border-b">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <h3 class="font-semibold text-sm text-gray-600 mb-1">Agrovet</h3>
                    <p class="text-gray-800">{{ $consultation->agrovet->name ?? 'Not Assigned' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-sm text-gray-600 mb-1">Type</h3>
                    <p class="text-gray-800 capitalize">{{ $consultation->type }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-sm text-gray-600 mb-1">Scheduled Date</h3>
                    <p class="text-gray-800">{{ $consultation->scheduled_at ? $consultation->scheduled_at->format('M d, Y g:i A') : 'Not scheduled' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-sm text-gray-600 mb-1">Requested On</h3>
                    <p class="text-gray-800">{{ $consultation->created_at->format('M d, Y g:i A') }}</p>
                </div>
            </div>
            <div>
                <h3 class="font-semibold text-sm text-gray-600 mb-1">Description</h3>
                <p class="text-gray-700">{{ $consultation->description }}</p>
            </div>
        </div>

        <!-- Response -->
        @if($consultation->response)
            <div class="p-4 bg-green-50">
                <h3 class="font-semibold mb-2 text-green-800">Response from Agrovet</h3>
                <p class="text-gray-700">{{ $consultation->response }}</p>
                <p class="text-xs text-gray-500 mt-2">Responded {{ $consultation->responded_at ? $consultation->responded_at->diffForHumans() : 'recently' }}</p>
            </div>
        @elseif($consultation->status === 'pending')
            <div class="p-4 bg-yellow-50">
                <div class="flex items-center gap-3">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    <div>
                        <p class="font-semibold">Waiting for Response</p>
                        <p class="text-sm text-gray-600">The agrovet will respond to your consultation request shortly.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Cancel Button for Pending Consultations -->
        @if($consultation->status === 'pending')
            <div class="p-4 border-t">
                <form method="POST" action="{{ route('farmer.consultations.cancel', $consultation) }}" onsubmit="return confirm('Are you sure you want to cancel this consultation?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
                        Cancel Consultation
                    </button>
                </form>
            </div>
        @endif

        <!-- Back Button -->
        <div class="p-4 border-t">
            <a href="{{ route('farmer.consultations.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 inline-block">
                Back to Consultations
            </a>
        </div>
    </div>
</div>
@endsection
