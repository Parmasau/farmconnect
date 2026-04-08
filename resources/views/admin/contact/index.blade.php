@extends('layouts.dashboard')

@section('title', 'Contact Messages - Admin')

@section('sidebar')
    @include('admin.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Contact Messages</h1>
        <div class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
            Unread: {{ $unreadCount ?? 0 }}
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($messages->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">Name</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Message</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Date</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($messages as $message)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $message->name }}</td>
                        <td class="px-4 py-3">{{ $message->email }}</td>
                        <td class="px-4 py-3 max-w-xs">
                            <p class="truncate">{{ Str::limit($message->message, 80) }}</p>
                        </td>
                        <td class="px-4 py-3">
                            @if($message->is_read)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Read</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Unread</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $message->created_at->format('M d, Y') }}<br>
                            <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.contact.show', $message) }}" class="text-blue-600 hover:underline text-sm">View</a>
                                <form action="{{ route('admin.contact.destroy', $message) }}" method="POST" class="inline" onsubmit="return confirm('Delete this message?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $messages->links() }}</div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📧</div>
            <h3 class="text-lg font-medium mb-2">No Contact Messages</h3>
            <p class="text-gray-500">No messages have been submitted through the contact form yet.</p>
        </div>
    @endif
</div>
@endsection
