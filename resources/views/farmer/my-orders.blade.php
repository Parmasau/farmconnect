{{-- resources/views/farmer/my-orders.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'My Orders - FarmNest')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Orders</h1>
        <a href="{{ route('farmer.products.marketplace') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            Continue Shopping
        </a>
    </div>

    @if(isset($orders) && $orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">Order #</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Seller</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Items</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Total</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Payment</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Date</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($orders as $order)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $order->order_number }}</td>
                        <td class="px-4 py-3">
                            {{ $order->seller->name ?? 'N/A' }}
                            <br>
                            <span class="text-xs text-gray-500">{{ ucfirst($order->seller->role ?? '') }}</span>
                        </td>
                        <td class="px-4 py-3">{{ $order->items->count() }} items</td>
                        <td class="px-4 py-3 font-semibold">KSh {{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 
                                   ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                   ($order->status === 'processing' ? 'bg-blue-100 text-blue-700' : 
                                   ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700'))) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('farmer.orders.show', $order) }}" class="text-blue-600 hover:underline text-sm">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📦</div>
            <h3 class="text-lg font-medium mb-2">No Orders Yet</h3>
            <p class="text-gray-500 mb-4">You haven't placed any orders yet.</p>
            <a href="{{ route('farmer.products.marketplace') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection