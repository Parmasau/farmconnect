@extends('layouts.dashboard')
@section('title', 'Messages')
@section('sidebar') @include('agrovet.dashboard') @endsection
@section('content')
<h2 class="text-lg font-semibold mb-4">Messages</h2>
<div class="bg-white rounded-xl shadow divide-y">
    @forelse($conversations as $userId => $msg)
    @php $other = $msg->sender_id === auth()->id() ? $msg->receiver : $msg->sender; @endphp
    <a href="{{ route('agrovet.messages.show', $other) }}" class="flex items-center gap-4 px-4 py-3 hover:bg-gray-50">
        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center font-bold text-green-700">{{ substr($other->name,0,1) }}</div>
        <div class="flex-1 min-w-0">
            <p class="font-medium text-sm">{{ $other->name }}</p>
            <p class="text-xs text-gray-500 truncate">{{ Str::limit($msg->body, 60) }}</p>
        </div>
        <p class="text-xs text-gray-400 shrink-0">{{ $msg->created_at->diffForHumans() }}</p>
    </a>
    @empty
    <div class="px-4 py-10 text-center text-gray-400">No messages yet.</div>
    @endforelse
</div>
@endsection
