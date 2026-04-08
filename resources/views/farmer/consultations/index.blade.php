@extends('layouts.dashboard')

@section('title', 'My Consultations - FarmConnect')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Consultations</h1>
        <a href="{{ route('farmer.consultations.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i> Request Consultation
        </a>
    </div>

    @if($consultations->count() > 0)
        <div class="divide-y">
            @foreach($consultations as $consultation)
                <div class="py-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="font-semibold text-lg">{{ $consultation->topic }}</h3>
                                <span class="px-2 py-1 text-xs rounded-full 
    {{ $consultation->status === 'completed' ? 'bg-green-100 text-green-700' : 
       ($consultation->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : 
       ($consultation->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700')) }}">
    {{ ucfirst($consultation->status) }}
</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-2">{{ Str::limit($consultation->description, 150) }}</p>
                            <div class="flex gap-4 text-xs text-gray-500">
                                <span><i class="fas fa-user mr-1"></i> {{ $consultation->agrovet->name ?? 'Not Assigned' }}</span>
                                <span><i class="fas fa-calendar mr-1"></i> {{ $consultation->scheduled_at ? $consultation->scheduled_at->format('M d, Y') : 'Not scheduled' }}</span>
                                <span><i class="fas fa-clock mr-1"></i> {{ $consultation->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <a href="{{ route('farmer.consultations.show', $consultation) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm ml-4">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $consultations->links() }}</div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📅</div>
            <h3 class="text-lg font-medium mb-2">No Consultations Yet</h3>
            <p class="text-gray-500 mb-4">Request a consultation with an agrovet expert</p>
            <a href="{{ route('farmer.consultations.create') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Request Consultation
            </a>
        </div>
    @endif
</div>
@endsection
