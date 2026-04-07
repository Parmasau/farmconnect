@extends('layouts.dashboard')
@section('title', 'Chat with ' . $farmer->name)
@section('sidebar') @include('agrovet.dashboard') @endsection
@section('content')
<a href="{{ route('agrovet.messages.index') }}" class="text-green-700 text-sm hover:underline">← Back</a>
<div class="bg-white rounded-xl shadow mt-4 flex flex-col" style="height:60vh">
    <div class="px-4 py-3 border-b font-semibold">{{ $farmer->name }}</div>
    <div class="flex-1 overflow-y-auto p-4 space-y-3">
        @foreach($messages as $msg)
        <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
            <div class="max-w-xs px-4 py-2 rounded-2xl text-sm {{ $msg->sender_id === auth()->id() ? 'bg-green-700 text-white' : 'bg-gray-100 text-gray-800' }}">
                {{ $msg->body }}
                <p class="text-xs mt-1 opacity-60">{{ $msg->created_at->format('H:i') }}</p>
            </div>
        </div>
        @endforeach
    </div>
    <form method="POST" action="{{ route('agrovet.messages.send', $farmer) }}" class="border-t p-3 flex gap-2">
        @csrf
        <input type="text" name="body" placeholder="Type a message..." required class="flex-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
        <button class="bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-800 text-sm">Send</button>
    </form>
</div>
@endsection
