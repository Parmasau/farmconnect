{{-- resources/views/farmer/messages/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Messages - FarmConnect')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Messages</h1>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Conversations</h5>
        </div>
        <div class="card-body">
            @if($messages->count() > 0)
                <div class="list-group">
                    @foreach($messages as $message)
                        @php
                            $otherUser = $message->sender_id == Auth::id() ? $message->receiver : $message->sender;
                            $unreadCount = Message::where('sender_id', $otherUser->id)
                                                 ->where('receiver_id', Auth::id())
                                                 ->where('is_read', false)
                                                 ->count();
                        @endphp
                        <a href="{{ route('farmer.messages.show', $otherUser->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $otherUser->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Str::limit($message->content, 50) }}</small>
                                </div>
                                @if($unreadCount > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                                @endif
                            </div>
                            <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-envelope fa-4x text-muted mb-3"></i>
                    <h3>No Messages Yet</h3>
                    <p class="text-muted">Start a conversation with other farmers about their products.</p>
                    <a href="{{ route('farmer.products.marketplace') }}" class="btn btn-primary">
                        Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection