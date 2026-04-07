{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('sidebar')
<div class="space-y-2">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">
        <i class="fas fa-tachometer-alt w-5"></i> Dashboard
    </a>
    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white">
        <i class="fas fa-users w-5"></i> Users
    </a>
    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white">
        <i class="fas fa-box w-5"></i> Products
    </a>
    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white">
        <i class="fas fa-shopping-cart w-5"></i> Orders
    </a>
    <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white">
        <i class="fas fa-chart-line w-5"></i> Reports
    </a>
    
    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white mt-4 border-t border-white/20 pt-4">
        <i class="fas fa-user-circle w-5"></i> My Profile
    </a>
    
    <div class="pt-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-red-600/80 text-white w-full transition-colors">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
    <div class="bg-white rounded-xl p-5 shadow">
        <div class="text-3xl mb-2">👥</div>
        <div class="text-2xl font-bold text-green-700">{{ $totalUsers ?? 0 }}</div>
        <div class="text-sm text-gray-500">Total Users</div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow">
        <div class="text-3xl mb-2">🌾</div>
        <div class="text-2xl font-bold text-green-700">{{ $totalFarmers ?? 0 }}</div>
        <div class="text-sm text-gray-500">Farmers</div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow">
        <div class="text-3xl mb-2">🔬</div>
        <div class="text-2xl font-bold text-green-700">{{ $totalAgrovets ?? 0 }}</div>
        <div class="text-sm text-gray-500">Agrovets</div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow">
        <div class="text-3xl mb-2">📦</div>
        <div class="text-2xl font-bold text-green-700">{{ $totalProducts ?? 0 }}</div>
        <div class="text-sm text-gray-500">Products</div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow">
        <div class="text-3xl mb-2">📋</div>
        <div class="text-2xl font-bold text-green-700">{{ $totalOrders ?? 0 }}</div>
        <div class="text-sm text-gray-500">Orders</div>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow p-5">
        <h3 class="font-semibold mb-3">Recent Users</h3>
        @forelse($recentUsers ?? [] as $user)
        <div class="flex justify-between items-center py-2 border-b last:border-0 text-sm">
            <div>
                <p class="font-medium">{{ $user->name }}</p>
                <p class="text-gray-500 text-xs">{{ $user->email }}</p>
            </div>
            <span class="text-xs capitalize bg-gray-100 px-2 py-0.5 rounded-full">{{ $user->role }}</span>
        </div>
        @empty
        <p class="text-gray-400 text-sm">No users yet.</p>
        @endforelse
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <h3 class="font-semibold mb-3">Recent Orders</h3>
        @forelse($recentOrders ?? [] as $order)
        <div class="flex justify-between items-center py-2 border-b last:border-0 text-sm">
            <div>
                <p class="font-medium">Order #{{ $order->order_number }}</p>
                <p class="text-gray-500 text-xs">{{ $order->buyer->name ?? 'N/A' }}</p>
            </div>
            <div class="text-right">
                <p class="font-semibold text-green-700">KES {{ number_format($order->total_amount, 2) }}</p>
                <span class="text-xs capitalize bg-gray-100 px-2 py-0.5 rounded-full">{{ $order->status }}</span>
            </div>
        </div>
        @empty
        <p class="text-gray-400 text-sm">No orders yet.</p>
        @endforelse
    </div>
</div>
@endsection