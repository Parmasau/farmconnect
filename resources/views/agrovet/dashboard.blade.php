{{-- resources/views/agrovet/dashboard.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Agrovet Dashboard')

@section('sidebar')
    @include('agrovet.sidebar')
@endsection

@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('agrovet.products.index') }}" class="bg-white rounded-xl p-5 shadow hover:shadow-md text-center">
        <div class="text-3xl mb-1">🏪</div>
        <div class="text-2xl font-bold text-green-700">{{ $stats['products'] ?? 0 }}</div>
        <div class="text-sm text-gray-500">Products</div>
    </a>
    <a href="{{ route('agrovet.orders.index') }}" class="bg-white rounded-xl p-5 shadow hover:shadow-md text-center">
        <div class="text-3xl mb-1">📦</div>
        <div class="text-2xl font-bold text-green-700">{{ $stats['orders'] ?? 0 }}</div>
        <div class="text-sm text-gray-500">Orders</div>
    </a>
    <a href="{{ route('agrovet.advice.index') }}" class="bg-white rounded-xl p-5 shadow hover:shadow-md text-center">
        <div class="text-3xl mb-1">💡</div>
        <div class="text-2xl font-bold text-green-700">{{ $stats['advice'] ?? 0 }}</div>
        <div class="text-sm text-gray-500">Open Advice</div>
    </a>
    <a href="{{ route('agrovet.consultations.index') }}" class="bg-white rounded-xl p-5 shadow hover:shadow-md text-center">
        <div class="text-3xl mb-1">📅</div>
        <div class="text-2xl font-bold text-green-700">{{ $stats['consultations'] ?? 0 }}</div>
        <div class="text-sm text-gray-500">Pending Consults</div>
    </a>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow p-5">
        <h3 class="font-semibold mb-3">Recent Orders</h3>
        @forelse($recentOrders ?? [] as $order)
        <div class="flex justify-between items-center py-2 border-b last:border-0 text-sm">
            <div><p class="font-medium">{{ $order->order_number }}</p><p class="text-gray-500 text-xs">{{ $order->buyer->name ?? 'N/A' }}</p></div>
            <div class="text-right"><p class="font-semibold text-green-700">KES {{ number_format($order->total_amount,2) }}</p><span class="text-xs capitalize bg-gray-100 px-2 py-0.5 rounded-full">{{ $order->status }}</span></div>
        </div>
        @empty
        <p class="text-gray-400 text-sm">No orders yet.</p>
        @endforelse
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <h3 class="font-semibold mb-3">Pending Advice</h3>
        @forelse($pendingAdvice ?? [] as $item)
        <div class="py-2 border-b last:border-0">
            <p class="font-medium text-sm">{{ $item->subject ?? 'Advice Request' }}</p>
            <p class="text-xs text-gray-500">from {{ $item->farmer->name ?? 'Farmer' }} · {{ $item->created_at->diffForHumans() ?? 'Recently' }}</p>
            <a href="{{ route('agrovet.advice.show', $item) ?? '#' }}" class="text-green-700 text-xs hover:underline">Respond →</a>
        </div>
        @empty
        <p class="text-gray-400 text-sm">No pending advice.</p>
        @endforelse
    </div>
</div>
@endsection