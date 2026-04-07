@extends('layouts.dashboard')
@section('title', 'Manage Users')
@section('sidebar') @include('admin.dashboard') @endsection
@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-lg font-semibold">Users</h2>
    <form method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="border rounded-lg px-3 py-1.5 text-sm">
        <select name="role" class="border rounded-lg px-3 py-1.5 text-sm" onchange="this.form.submit()">
            <option value="">All Roles</option>
            @foreach(['admin','farmer','agrovet'] as $r)
                <option value="{{ $r }}" @selected(request('role') === $r)>{{ ucfirst($r) }}</option>
            @endforeach
        </select>
        <button class="bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm">Search</button>
    </form>
</div>
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
            <tr><th class="px-4 py-3 text-left">Name</th><th class="px-4 py-3 text-left">Email</th><th class="px-4 py-3 text-left">Role</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-left">Joined</th><th class="px-4 py-3"></th></tr>
        </thead>
        <tbody class="divide-y">
            @foreach($users as $user)
            <tr>
                <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs capitalize {{ $user->role === 'farmer' ? 'bg-green-100 text-green-700' : ($user->role === 'agrovet' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">{{ $user->role }}</span></td>
                <td class="px-4 py-3">
                    <form method="POST" action="{{ route('admin.users.toggle', $user) }}">@csrf @method('PATCH')
                        <button class="text-xs px-2 py-0.5 rounded-full {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</button>
                    </form>
                </td>
                <td class="px-4 py-3 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                <td class="px-4 py-3">
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}">@csrf @method('DELETE')
                        <button class="text-red-500 hover:underline text-xs" onclick="return confirm('Delete user?')">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
