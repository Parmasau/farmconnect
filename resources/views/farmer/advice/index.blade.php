@extends('layouts.dashboard')

@section('title', 'My Advice Requests - FarmConnect')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Advice Requests</h1>
        <a href="{{ route('farmer.advice.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i> Ask for Advice
        </a>
    </div>

    @if($advice->count() > 0)
        <div class="divide-y">
            @foreach($advice as $request)
                <div class="py-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="font-semibold text-lg">{{ $request->subject }}</h3>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $request->status === 'answered' ? 'bg-green-100 text-green-700' : 
                                       ($request->status === 'assigned' ? 'bg-blue-100 text-blue-700' : 
                                       ($request->status === 'resolved' ? 'bg-gray-100 text-gray-700' : 'bg-yellow-100 text-yellow-700')) }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm mb-2">{{ Str::limit($request->message, 150) }}</p>
                            @if($request->agrovet)
                                <p class="text-xs text-gray-500">Assigned to: {{ $request->agrovet->name }}</p>
                            @endif
                            <p class="text-xs text-gray-400 mt-1">{{ $request->created_at->diffForHumans() }}</p>
                        </div>
                        <a href="{{ route('farmer.advice.show', $request) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm ml-4">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $advice->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">💡</div>
            <h3 class="text-lg font-medium mb-2">No Advice Requests Yet</h3>
            <p class="text-gray-500 mb-4">Have a farming question? Ask our agrovet experts for advice.</p>
            <a href="{{ route('farmer.advice.create') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Ask for Advice
            </a>
        </div>
    @endif
</div>
@endsection