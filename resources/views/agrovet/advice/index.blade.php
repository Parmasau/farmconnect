{{-- resources/views/agrovet/advice/index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Advice Requests - Agrovet')

@section('sidebar')
    @include('agrovet.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Advice Requests from Farmers</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">Total Requests</div>
        </div>
        <div class="bg-yellow-50 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">Pending</div>
        </div>
        <div class="bg-purple-50 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-purple-600">{{ $stats['assigned'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">Assigned to You</div>
        </div>
        <div class="bg-green-50 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $stats['answered'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">Answered</div>
        </div>
    </div>

    @if($adviceRequests->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">Farmer</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Subject</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Date</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($adviceRequests as $advice)
                    <tr>
                        <td class="px-4 py-3">
                            <div>
                                <p class="font-medium">{{ $advice->farmer->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-500">{{ $advice->farmer->email ?? '' }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-medium">{{ Str::limit($advice->subject, 40) }}</p>
                            <p class="text-xs text-gray-500">{{ Str::limit($advice->message, 60) }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $advice->status === 'answered' ? 'bg-green-100 text-green-700' : 
                                   ($advice->status === 'assigned' ? 'bg-blue-100 text-blue-700' : 
                                   ($advice->status === 'resolved' ? 'bg-gray-100 text-gray-700' : 'bg-yellow-100 text-yellow-700')) }}">
                                {{ ucfirst($advice->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $advice->created_at->format('M d, Y') }}<br>
                            <span class="text-xs text-gray-500">{{ $advice->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('agrovet.advice.show', $advice) }}" class="text-blue-600 hover:underline text-sm">
                                {{ $advice->status === 'answered' ? 'View Response' : 'Respond' }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $adviceRequests->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">💡</div>
            <h3 class="text-lg font-medium mb-2">No Advice Requests Yet</h3>
            <p class="text-gray-500">Farmers will send advice requests here</p>
        </div>
    @endif
</div>
@endsection