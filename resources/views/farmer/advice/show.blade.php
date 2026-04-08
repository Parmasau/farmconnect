@extends('layouts.dashboard')

@section('title', 'Advice Request Details - FarmConnect')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow">
        <!-- Header -->
        <div class="p-4 border-b flex items-center gap-3">
            <a href="{{ route('farmer.advice.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h2 class="font-semibold text-lg">{{ $advice->subject }}</h2>
                <p class="text-xs text-gray-500">Requested {{ $advice->created_at->diffForHumans() }}</p>
            </div>
            <div class="ml-auto">
                <span class="px-3 py-1 text-sm rounded-full 
                    {{ $advice->status === 'answered' ? 'bg-green-100 text-green-700' : 
                       ($advice->status === 'assigned' ? 'bg-blue-100 text-blue-700' : 
                       ($advice->status === 'resolved' ? 'bg-gray-100 text-gray-700' : 'bg-yellow-100 text-yellow-700')) }}">
                    {{ ucfirst($advice->status) }}
                </span>
            </div>
        </div>

        <!-- Your Question -->
        <div class="p-4 border-b">
            <h3 class="font-semibold mb-2">Your Question</h3>
            <p class="text-gray-700">{{ $advice->message }}</p>
            @if($advice->agrovet)
                <p class="text-xs text-gray-500 mt-2">Assigned to: {{ $advice->agrovet->name }}</p>
            @endif
        </div>

        <!-- Response -->
        @if($advice->response)
            <div class="p-4 bg-green-50">
                <h3 class="font-semibold mb-2 text-green-800">Response from Agrovet</h3>
                <p class="text-gray-700">{{ $advice->response }}</p>
                <p class="text-xs text-gray-500 mt-2">Answered {{ $advice->responded_at ? $advice->responded_at->diffForHumans() : 'recently' }}</p>
            </div>
        @elseif($advice->status === 'pending')
            <div class="p-4 bg-yellow-50">
                <div class="flex items-center gap-3">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    <div>
                        <p class="font-semibold">Waiting for Response</p>
                        <p class="text-sm text-gray-600">An agrovet expert will respond to your question shortly.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Back Button -->
        <div class="p-4 border-t">
            <a href="{{ route('farmer.advice.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 inline-block">
                Back to Requests
            </a>
        </div>
    </div>
</div>
@endsection