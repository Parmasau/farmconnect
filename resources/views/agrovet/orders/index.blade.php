{{-- resources/views/agrovet/orders/index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Orders - Agrovet')

@section('sidebar')
    @include('agrovet.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Customer Orders</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">Order #</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Customer</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Total</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Date</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($orders as $order)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $order->order_number }}</td>
                        <td class="px-4 py-3">{{ $order->buyer->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">KSh {{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 
                                   ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                   ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700')) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('agrovet.orders.show', $order) }}" class="text-blue-600 hover:underline text-sm">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📦</div>
            <h3 class="text-lg font-medium mb-2">No Orders Yet</h3>
            <p class="text-gray-500">Orders from farmers will appear here</p>
        </div>
    @endif
</div>
@endsection