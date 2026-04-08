@extends('layouts.dashboard')

@section('title', 'Messages - Agrovet Dashboard')

@section('sidebar')
    @include('agrovet.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Messages from Farmers</h1>
    </div>

    @if(isset($messages) && $messages->count() > 0)
        <div class="divide-y">
            @foreach($messages as $message)
                @php
                    $otherUser = $message->sender_id == auth()->id() ? $message->receiver : $message->sender;
                    $unreadCount = App\Models\Message::where('sender_id', $otherUser->id)
                                                   ->where('receiver_id', auth()->id())
                                                   ->whereNull('read_at')
                                                   ->count();
                @endphp
                <a href="{{ route('agrovet.messages.show', $otherUser->id) }}" class="block py-4 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold">{{ $otherUser->name }}</p>
                                    <p class="text-sm text-gray-500">{{ Str::limit($message->body, 50) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-400">{{ $message->created_at->diffForHumans() }}</p>
                                    @if($unreadCount > 0)
                                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-0.5 mt-1 inline-block">{{ $unreadCount }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">💬</div>
            <h3 class="text-lg font-medium mb-2">No Messages Yet</h3>
            <p class="text-gray-500 mb-4">When farmers contact you, messages will appear here</p>
        </div>
    @endif
</div>
@endsection
