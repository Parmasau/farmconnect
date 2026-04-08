@extends('layouts.dashboard')

@section('title', 'Conversation - FarmConnect')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow">
        <!-- Header -->
        <div class="p-4 border-b flex items-center gap-3">
            <a href="{{ route('farmer.messages.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-green-600"></i>
            </div>
            <div>
                <h2 class="font-semibold">{{ $otherUser->name }}</h2>
                <p class="text-xs text-gray-500">{{ $otherUser->email }}</p>
            </div>
        </div>

        <!-- Messages -->
        <div class="h-96 overflow-y-auto p-4 space-y-3" id="messagesContainer">
            @foreach($messages as $message)
                <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[70%] {{ $message->sender_id == auth()->id() ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-800' }} rounded-lg px-4 py-2">
                        <p class="text-sm">{{ $message->body }}</p>  <!-- Changed from content to body -->
                        <p class="text-xs {{ $message->sender_id == auth()->id() ? 'text-green-200' : 'text-gray-500' }} mt-1">
                            {{ $message->created_at->format('g:i A') }}
                        </p>
                    </div>
                </div>
            @endforeach
            <div id="scrollBottom"></div>
        </div>

        <!-- Reply Form -->
        <div class="p-4 border-t">
            <form method="POST" action="{{ route('farmer.messages.send', $otherUser->id) }}" id="messageForm">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="message" 
                           class="flex-1 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                           placeholder="Type your message..." 
                           required>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function scrollToBottom() {
        const container = document.getElementById('messagesContainer');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }
    scrollToBottom();
</script>
@endsection