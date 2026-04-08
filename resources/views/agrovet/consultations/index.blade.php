@extends('layouts.dashboard')

@section('title', 'Consultations - Agrovet Dashboard')

@section('sidebar')
    @include('agrovet.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Consultation Requests</h1>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-blue-50 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">Total</div>
        </div>
        <div class="bg-yellow-50 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">Pending</div>
        </div>
        <div class="bg-purple-50 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-purple-600">{{ ($stats['accepted'] ?? 0) + ($stats['in_progress'] ?? 0) }}</div>
            <div class="text-sm text-gray-600">Active</div>
        </div>
        <div class="bg-green-50 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $stats['completed'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">Completed</div>
        </div>
    </div>

    @if($consultations->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">Farmer</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Topic</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Type</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Date</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($consultations as $consultation)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-sm">{{ $consultation->farmer->name ?? 'Farmer' }}</p>
                                    <p class="text-xs text-gray-500">{{ $consultation->farmer->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-medium text-sm">{{ $consultation->topic }}</p>
                            <p class="text-xs text-gray-500">{{ Str::limit($consultation->description, 50) }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $consultation->type === 'video' ? 'bg-purple-100 text-purple-700' : 
                                   ($consultation->type === 'phone' ? 'bg-blue-100 text-blue-700' : 
                                   ($consultation->type === 'in_person' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-700')) }}">
                                {{ ucfirst($consultation->type) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $consultation->status === 'completed' ? 'bg-green-100 text-green-700' : 
                                   ($consultation->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : 
                                   ($consultation->status === 'in_progress' ? 'bg-purple-100 text-purple-700' : 
                                   ($consultation->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'))) }}">
                                {{ $consultation->status === 'requested' ? 'Pending' : ucfirst($consultation->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $consultation->created_at->format('M d, Y') }}<br>
                            <span class="text-xs text-gray-500">{{ $consultation->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('agrovet.consultations.show', $consultation) }}" class="text-blue-600 hover:underline text-sm">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $consultations->links() }}</div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📅</div>
            <h3 class="text-lg font-medium mb-2">No Consultations Yet</h3>
            <p class="text-gray-500">Farmers will request consultations here</p>
        </div>
    @endif
</div>
@endsection
