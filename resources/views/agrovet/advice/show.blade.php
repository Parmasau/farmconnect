@extends('layouts.dashboard')

@section('title', 'Advice Request Details - Agrovet')

@section('sidebar')
    @include('agrovet.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow">
        <!-- Header -->
        <div class="p-4 border-b flex items-center gap-3">
            <a href="{{ route('agrovet.advice.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h2 class="font-semibold text-lg">{{ $advice->subject }}</h2>
                <p class="text-xs text-gray-500">Requested by {{ $advice->farmer->name ?? 'Farmer' }}</p>
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

        <!-- Farmer Info -->
        <div class="p-4 border-b bg-gray-50">
            <h3 class="font-semibold mb-2">Farmer Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Name</p>
                    <p class="font-medium">{{ $advice->farmer->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium">{{ $advice->farmer->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Phone</p>
                    <p class="font-medium">{{ $advice->farmer->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Requested On</p>
                    <p class="font-medium">{{ $advice->created_at ? $advice->created_at->format('M d, Y g:i A') : 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Advice Request -->
        <div class="p-4 border-b">
            <h3 class="font-semibold mb-2">Subject</h3>
            <p class="text-gray-800 text-lg">{{ $advice->subject }}</p>
        </div>

        <div class="p-4 border-b">
            <h3 class="font-semibold mb-2">Farmer's Question</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-700">{{ $advice->message }}</p>
            </div>
        </div>

        <!-- Response Section -->
        <div class="p-4">
            <h3 class="font-semibold mb-3">Your Response</h3>
            
            @if($advice->status === 'answered' && $advice->response)
                <div class="bg-green-50 rounded-lg p-4 mb-4 border border-green-200">
                    <p class="text-gray-700">{{ $advice->response }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        Sent on {{ $advice->responded_at ? $advice->responded_at->format('M d, Y g:i A') : 'Recently' }}
                    </p>
                </div>
                <a href="{{ route('agrovet.advice.index') }}" class="inline-block bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Back to Requests
                </a>
            @else
                <form method="POST" action="{{ route('agrovet.advice.respond', $advice) }}">
                    @csrf
                    <div class="mb-4">
                        <textarea name="response" rows="6" class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                                  placeholder="Write your professional advice here..." required>{{ old('response') }}</textarea>
                        @error('response')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                            Send Response
                        </button>
                        <a href="{{ route('agrovet.advice.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                            Cancel
                        </a>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
