@extends('layouts.dashboard')

@section('title', 'Consultation Details - Agrovet')

@section('sidebar')
    @include('agrovet.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow">
        <!-- Header -->
        <div class="p-4 border-b flex items-center gap-3">
            <a href="{{ route('agrovet.consultations.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h2 class="font-semibold text-lg">{{ $consultation->topic }}</h2>
                <p class="text-xs text-gray-500">Requested by {{ $consultation->farmer->name ?? 'Farmer' }} · {{ $consultation->created_at->diffForHumans() }}</p>
            </div>
            <div class="ml-auto">
                <span class="px-3 py-1 text-sm rounded-full 
                    {{ $consultation->status === 'completed' ? 'bg-green-100 text-green-700' : 
                       ($consultation->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : 
                       ($consultation->status === 'in_progress' ? 'bg-purple-100 text-purple-700' : 
                       ($consultation->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'))) }}">
                    {{ $consultation->status === 'requested' ? 'Pending' : ucfirst($consultation->status) }}
                </span>
            </div>
        </div>

        <!-- Farmer Info -->
        <div class="p-4 border-b bg-gray-50">
            <h3 class="font-semibold mb-2">Farmer Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Name</p>
                    <p class="font-medium">{{ $consultation->farmer->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium">{{ $consultation->farmer->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Phone</p>
                    <p class="font-medium">{{ $consultation->farmer->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Requested On</p>
                    <p class="font-medium">{{ $consultation->created_at->format('M d, Y g:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Consultation Details -->
        <div class="p-4 border-b">
            <h3 class="font-semibold mb-2">Consultation Details</h3>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-600">Type</p>
                    <p class="font-medium capitalize">{{ $consultation->type }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Scheduled Date</p>
                    <p class="font-medium">{{ $consultation->scheduled_at ? $consultation->scheduled_at->format('M d, Y g:i A') : 'Not scheduled' }}</p>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Description</p>
                <p class="text-gray-700">{{ $consultation->description }}</p>
            </div>
        </div>

        <!-- Status Update Form - Using POST with @method('PATCH') -->
        <div class="p-4 border-b">
            <h3 class="font-semibold mb-3">Update Status</h3>
            <form method="POST" action="{{ route('agrovet.consultations.status', $consultation) }}">
                @csrf
                @method('PATCH')
                <div class="flex gap-3">
                    <select name="status" class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                        <option value="requested" {{ $consultation->status === 'requested' ? 'selected' : '' }}>Requested (Pending)</option>
                        <option value="confirmed" {{ $consultation->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="in_progress" {{ $consultation->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ $consultation->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $consultation->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                        Update Status
                    </button>
                </div>
            </form>
        </div>

        <!-- Response Form -->
        <div class="p-4">
            <h3 class="font-semibold mb-3">Response to Farmer</h3>
            <form method="POST" action="{{ route('agrovet.consultations.respond', $consultation) }}">
                @csrf
                <div class="mb-3">
                    <textarea name="response" rows="4" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" placeholder="Write your response here...">{{ $consultation->response }}</textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Send Response
                </button>
            </form>
        </div>
    </div>
</div>
@endsection