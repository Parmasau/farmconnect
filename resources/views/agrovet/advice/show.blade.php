{{-- resources/views/agrovet/advice/show.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Advice Request Details')

@section('sidebar')
    @include('agrovet.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <a href="{{ route('agrovet.advice.index') }}" class="text-green-600 hover:underline text-sm">← Back to Requests</a>
                <h1 class="text-2xl font-bold mt-2">Advice Request Details</h1>
            </div>
            <span class="px-3 py-1 rounded-full text-sm 
                {{ $advice->status === 'answered' ? 'bg-green-100 text-green-700' : 
                   ($advice->status === 'assigned' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                {{ ucfirst($advice->status) }}
            </span>
        </div>

        <!-- Farmer Info -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
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
                    <p class="text-sm text-gray-600">Requested</p>
                    <p class="font-medium">{{ $advice->created_at->format('F j, Y g:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Advice Request -->
        <div class="mb-6">
            <h3 class="font-semibold mb-2">Subject</h3>
            <p class="text-gray-800 text-lg">{{ $advice->subject }}</p>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold mb-2">Farmer's Question</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-700 whitespace-pre-wrap">{{ $advice->message }}</p>
            </div>
        </div>

        <!-- Response Form -->
        @if($advice->status !== 'answered')
        <div class="border-t pt-6">
            <h3 class="font-semibold mb-3">Your Response</h3>
            <form method="POST" action="{{ route('agrovet.advice.respond', $advice) }}">
                @csrf
                <div class="mb-4">
                    <textarea name="response" rows="6" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
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
        </div>
        @else
        <!-- Display Response -->
        <div class="border-t pt-6">
            <h3 class="font-semibold mb-3">Your Response</h3>
            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                <p class="text-gray-700 whitespace-pre-wrap">{{ $advice->response }}</p>
                <p class="text-xs text-gray-500 mt-2">
                    Sent on {{ $advice->responded_at ? $advice->responded_at->format('F j, Y g:i A') : 'Recently' }}
                </p>
            </div>
            
            <div class="mt-4 flex gap-3">
                <a href="{{ route('agrovet.advice.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                    Back to Requests
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection