{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Manage Users - Admin')

@section('sidebar')
    @include('admin.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manage Users</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i> Add User
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
        <div class="bg-blue-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-blue-600">{{ $stats['total'] }}</div>
            <div class="text-xs text-gray-600">Total</div>
        </div>
        <div class="bg-green-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-green-600">{{ $stats['farmers'] }}</div>
            <div class="text-xs text-gray-600">Farmers</div>
        </div>
        <div class="bg-purple-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-purple-600">{{ $stats['agrovets'] }}</div>
            <div class="text-xs text-gray-600">Agrovets</div>
        </div>
        <div class="bg-red-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-red-600">{{ $stats['admins'] }}</div>
            <div class="text-xs text-gray-600">Admins</div>
        </div>
        <div class="bg-green-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-green-600">{{ $stats['active'] }}</div>
            <div class="text-xs text-gray-600">Active</div>
        </div>
        <div class="bg-red-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-red-600">{{ $stats['inactive'] }}</div>
            <div class="text-xs text-gray-600">Inactive</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-4 flex gap-3">
        <form method="GET" class="flex-1 flex gap-3">
            <input type="text" name="search" placeholder="Search by name or email..." 
                   value="{{ request('search') }}" class="flex-1 border rounded-lg px-3 py-2">
            <select name="role" class="border rounded-lg px-3 py-2">
                <option value="">All Roles</option>
                <option value="farmer" {{ request('role') == 'farmer' ? 'selected' : '' }}>Farmer</option>
                <option value="agrovet" {{ request('role') == 'agrovet' ? 'selected' : '' }}>Agrovet</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Filter</button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Reset</a>
        </form>
    </div>

    <!-- Users Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium">Name</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Email</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Role</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Phone</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Joined</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($users as $user)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                    <td class="px-4 py-3">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 
                               ($user->role === 'agrovet' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $user->phone ?? 'N/A' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:underline text-sm">View</a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-green-600 hover:underline text-sm">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                            </form>
                            <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-yellow-600 hover:underline text-sm">
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection