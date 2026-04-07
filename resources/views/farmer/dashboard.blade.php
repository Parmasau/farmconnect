@extends('layouts.dashboard')

@section('title', 'Farmer Dashboard')

@section('sidebar')
<div class="space-y-2">
    <a href="{{ route('farmer.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.dashboard') ? 'bg-white/20' : '' }}">
        <i class="fas fa-tachometer-alt w-5"></i> Dashboard
    </a>
    <a href="{{ route('farmer.products.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.products.index') ? 'bg-white/20' : '' }}">
        <i class="fas fa-box w-5"></i> My Products
    </a>
    <a href="{{ route('farmer.products.create') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.products.create') ? 'bg-white/20' : '' }}">
        <i class="fas fa-plus w-5"></i> Add Product
    </a>
    <a href="{{ route('farmer.products.marketplace', ['seller' => 'farmer']) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white">
        <i class="fas fa-store w-5"></i> Buy from Farmers
    </a>
    <a href="{{ route('farmer.advice.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.advice.*') ? 'bg-white/20' : '' }}">
        <i class="fas fa-stethoscope w-5"></i> Advice
    </a>
    <a href="{{ route('farmer.consultations.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.consultations.*') ? 'bg-white/20' : '' }}">
        <i class="fas fa-comments w-5"></i> Consultations
    </a>
    <a href="{{ route('farmer.analytics.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white">
        <i class="fas fa-chart-line w-5"></i> Analytics
    </a>
    
    <!-- Profile Link -->
    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white mt-4 border-t border-white/20 pt-4">
        <i class="fas fa-user-circle w-5"></i> My Profile
    </a>
    
    <!-- Logout Button -->
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
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl p-5 shadow">
        <div class="text-3xl mb-2">🌾</div>
        <div class="text-2xl font-bold text-green-700">{{ $stats['total_products'] ?? 0 }}</div>
        <div class="text-sm text-gray-500">My Products</div>
    </div>
    <div class="bg-white/95 backdrop-blur-sm rounded-xl p-5 shadow">
        <div class="text-3xl mb-2">🛒</div>
        <div class="text-2xl font-bold text-green-700">{{ $stats['total_orders'] ?? 0 }}</div>
        <div class="text-sm text-gray-500">Purchases</div>
    </div>
    <div class="bg-white/95 backdrop-blur-sm rounded-xl p-5 shadow">
        <div class="text-3xl mb-2">💰</div>
        <div class="text-2xl font-bold text-green-700">KSh {{ number_format($stats['total_revenue'] ?? 0, 0) }}</div>
        <div class="text-sm text-gray-500">Sales</div>
    </div>
    <div class="bg-white/95 backdrop-blur-sm rounded-xl p-5 shadow">
        <div class="text-3xl mb-2">💡</div>
        <div class="text-2xl font-bold text-green-700">{{ $stats['pending_advice'] ?? 0 }}</div>
        <div class="text-sm text-gray-500">Advice Requests</div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow">
        <div class="p-5 border-b">
            <h2 class="font-semibold">Recent Products</h2>
        </div>
        <div class="p-5">
            @if(isset($recentProducts) && $recentProducts->count() > 0)
                @foreach($recentProducts as $product)
                    <div class="flex justify-between items-center py-2 border-b last:border-0">
                        <div>
                            <p class="font-medium">{{ $product->name }}</p>
                            <p class="text-sm text-gray-500">KSh {{ number_format($product->price, 2) }}</p>
                        </div>
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">{{ $product->status }}</span>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500 text-center py-4">No products yet</p>
            @endif
        </div>
    </div>

    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow">
        <div class="p-5 border-b">
            <h2 class="font-semibold">Recent Orders</h2>
        </div>
        <div class="p-5">
            @if(isset($recentOrders) && $recentOrders->count() > 0)
                @foreach($recentOrders as $order)
                    <div class="flex justify-between items-center py-2 border-b last:border-0">
                        <div>
                            <p class="font-medium">Order #{{ $order->order_number }}</p>
                            <p class="text-sm text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">{{ $order->status }}</span>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500 text-center py-4">No orders yet</p>
            @endif
        </div>
    </div>
</div>
@endsection