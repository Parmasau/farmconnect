@extends('layouts.dashboard')

@section('title', 'Message Details - Admin')

@section('sidebar')
    @include('admin.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow">
        <div class="p-4 border-b flex items-center gap-3">
            <a href="{{ route('admin.contact.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-2xl font-bold">Message Details</h1>
            @if(!$message->is_read)
                <span class="ml-auto bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">Unread</span>
            @endif
        </div>

        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="font-semibold mb-2">Sender Information</h3>
                    <p><strong>Name:</strong> {{ $message->name }}</p>
                    <p><strong>Email:</strong> {{ $message->email }}</p>
                    <p><strong>Sent:</strong> {{ $message->created_at->format('F j, Y g:i A') }}</p>
                    <p><strong>Read:</strong> {{ $message->read_at ? $message->read_at->format('F j, Y g:i A') : 'Not read yet' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Quick Actions</h3>
                    <div class="flex gap-3">
                        <a href="mailto:{{ $message->email }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-reply"></i> Reply via Email
                        </a>
                        <form action="{{ route('admin.contact.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="font-semibold mb-3">Message</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
