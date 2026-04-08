{{-- resources/views/agrovet/dashboard.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Agrovet Dashboard')

@section('sidebar')
    @include('agrovet.sidebar')
@endsection

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('agrovet.products.index') }}" class="bg-white/95 backdrop-blur-sm rounded-xl p-5 shadow hover:shadow-lg transition">
        <div class="text-3xl mb-2">🏪</div>
        <div class="text-2xl font-bold text-green-700">{{ $stats['products'] ?? 0 }}</div>
        <div class="text-sm text-gray-500">Products</div>
    </a>
    <a href="{{ route('agrovet.orders.index') }}" class="bg-white/95 backdrop-blur-sm rounded-xl p-5 shadow hover:shadow-lg transition">
        <div class="text-3xl mb-2">📦</div>
        <div class="text-2xl font-bold text-green-700">{{ $stats['orders'] ?? 0 }}</div>
        <div class="text-sm text-gray-500">Orders</div>
    </a>
    <a href="{{ route('agrovet.advice.index') }}" class="bg-white/95 backdrop-blur-sm rounded-xl p-5 shadow hover:shadow-lg transition">
        <div class="text-3xl mb-2">💡</div>
        <div class="text-2xl font-bold text-yellow-600">{{ $stats['advice'] ?? 0 }}</div>
        <div class="text-sm text-gray-500">Pending Advice</div>
    </a>
    <a href="{{ route('agrovet.consultations.index') }}" class="bg-white/95 backdrop-blur-sm rounded-xl p-5 shadow hover:shadow-lg transition">
        <div class="text-3xl mb-2">📅</div>
        <div class="text-2xl font-bold text-purple-600">{{ $stats['consultations'] ?? 0 }}</div>
        <div class="text-sm text-gray-500">Pending Consults</div>
    </a>
</div>

<!-- Additional Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-blue-50 rounded-xl p-4 text-center">
        <div class="text-xl font-bold text-blue-600">KSh {{ number_format($stats['total_revenue'] ?? 0, 0) }}</div>
        <div class="text-xs text-gray-600">Total Revenue</div>
    </div>
    <div class="bg-yellow-50 rounded-xl p-4 text-center">
        <div class="text-xl font-bold text-yellow-600">{{ $stats['pending_orders'] ?? 0 }}</div>
        <div class="text-xs text-gray-600">Pending Orders</div>
    </div>
    <div class="bg-red-50 rounded-xl p-4 text-center">
        <div class="text-xl font-bold text-red-600">{{ $stats['low_stock'] ?? 0 }}</div>
        <div class="text-xs text-gray-600">Low Stock</div>
    </div>
    <a href="{{ route('agrovet.messages.index') }}" class="bg-purple-50 rounded-xl p-4 text-center hover:bg-purple-100 transition">
        <div class="text-xl font-bold text-purple-600">{{ $stats['unread_messages'] ?? 0 }}</div>
        <div class="text-xs text-gray-600">Unread Messages</div>
    </a>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <!-- Recent Orders -->
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-5">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-semibold">Recent Orders</h3>
            <a href="{{ route('agrovet.orders.index') }}" class="text-xs text-green-600 hover:underline">View All</a>
        </div>
        @forelse($recentOrders ?? [] as $order)
        <div class="flex justify-between items-center py-2 border-b last:border-0 text-sm">
            <div>
                <p class="font-medium">#{{ $order->order_number }}</p>
                <p class="text-gray-500 text-xs">{{ $order->buyer->name ?? 'Customer' }}</p>
            </div>
            <div class="text-right">
                <p class="font-semibold text-green-700">KSh {{ number_format($order->total_amount, 2) }}</p>
                <span class="text-xs capitalize bg-gray-100 px-2 py-0.5 rounded-full">{{ $order->status }}</span>
            </div>
        </div>
        @empty
        <p class="text-gray-400 text-sm text-center py-4">No orders yet.</p>
        @endforelse
    </div>

    <!-- Pending Advice -->
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-5">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-semibold">Pending Advice</h3>
            <a href="{{ route('agrovet.advice.index') }}" class="text-xs text-green-600 hover:underline">View All</a>
        </div>
        @forelse($pendingAdvice ?? [] as $item)
        <div class="py-2 border-b last:border-0">
            <p class="font-medium text-sm">{{ $item->subject }}</p>
            <p class="text-xs text-gray-500">from {{ $item->farmer->name ?? 'Farmer' }} · {{ $item->created_at->diffForHumans() }}</p>
            <a href="{{ route('agrovet.advice.show', $item) }}" class="text-green-700 text-xs hover:underline">Respond →</a>
        </div>
        @empty
        <p class="text-gray-400 text-sm text-center py-4">No pending advice.</p>
        @endforelse
    </div>
</div>

<!-- Recent Consultations & Messages -->
<div class="grid md:grid-cols-2 gap-6 mt-6">
    <!-- Recent Consultations -->
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-5">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-semibold">Recent Consultations</h3>
            <a href="{{ route('agrovet.consultations.index') }}" class="text-xs text-green-600 hover:underline">View All</a>
        </div>
        @forelse($recentConsultations ?? [] as $consultation)
        <div class="flex justify-between items-center py-2 border-b last:border-0">
            <div>
                <p class="font-medium text-sm">{{ $consultation->topic }}</p>
                <p class="text-xs text-gray-500">from {{ $consultation->farmer->name ?? 'Farmer' }}</p>
            </div>
            <div class="text-right">
                <span class="text-xs capitalize px-2 py-0.5 rounded-full 
                    {{ $consultation->status === 'requested' ? 'bg-yellow-100 text-yellow-700' : 
                       ($consultation->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : 
                       ($consultation->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700')) }}">
                    {{ $consultation->status === 'requested' ? 'Pending' : ucfirst($consultation->status) }}
                </span>
            </div>
        </div>
        @empty
        <p class="text-gray-400 text-sm text-center py-4">No consultations yet.</p>
        @endforelse
    </div>

    <!-- Recent Messages -->
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-5">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-semibold">Recent Messages</h3>
            <a href="{{ route('agrovet.messages.index') }}" class="text-xs text-green-600 hover:underline">View All</a>
        </div>
        @forelse($recentMessages ?? [] as $message)
            @php
                $otherUser = $message->sender_id == auth()->id() ? $message->receiver : $message->sender;
            @endphp
            <div class="flex justify-between items-center py-2 border-b last:border-0">
                <div class="flex-1">
                    <p class="font-medium text-sm">{{ $otherUser->name ?? 'User' }}</p>
                    <p class="text-xs text-gray-500">{{ Str::limit($message->body, 40) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400">{{ $message->created_at->diffForHumans() }}</p>
                    @if($message->receiver_id == auth()->id() && !$message->read_at)
                        <span class="inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                    @endif
                </div>
            </div>
        @empty
        <p class="text-gray-400 text-sm text-center py-4">No messages yet.</p>
        @endforelse
    </div>
</div>

<!-- Recent Products -->
<div class="mt-6 bg-white/95 backdrop-blur-sm rounded-xl shadow p-5">
    <div class="flex justify-between items-center mb-3">
        <h3 class="font-semibold">Recent Products</h3>
        <a href="{{ route('agrovet.products.index') }}" class="text-xs text-green-600 hover:underline">View All</a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
        @forelse($recentProducts ?? [] as $product)
        <div class="text-center">
            <img src="{{ $product->image_url }}" class="w-16 h-16 object-cover rounded-lg mx-auto mb-2">
            <p class="text-sm font-medium">{{ Str::limit($product->name, 20) }}</p>
            <p class="text-xs text-green-600">KSh {{ number_format($product->price, 2) }}</p>
        </div>
        @empty
        <p class="text-gray-400 text-sm text-center col-span-5 py-4">No products yet.</p>
        @endforelse
    </div>
</div>

<!-- Auto-refresh Script -->
<script>
    // Auto-refresh dashboard every 30 seconds to reflect real-time updates
    setInterval(function() {
        location.reload();
    }, 30000);
</script>
@endsection