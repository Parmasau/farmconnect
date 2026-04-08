@extends('layouts.dashboard')

@section('title', 'Manage Orders - Admin')

@section('sidebar')
    @include('admin.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manage Orders</h1>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
        <div class="bg-blue-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-blue-600">{{ $stats['total'] }}</div>
            <div class="text-xs text-gray-600">Total</div>
        </div>
        <div class="bg-yellow-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
            <div class="text-xs text-gray-600">Pending</div>
        </div>
        <div class="bg-purple-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-purple-600">{{ $stats['processing'] }}</div>
            <div class="text-xs text-gray-600">Processing</div>
        </div>
        <div class="bg-green-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-green-600">{{ $stats['completed'] }}</div>
            <div class="text-xs text-gray-600">Completed</div>
        </div>
        <div class="bg-red-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-red-600">{{ $stats['cancelled'] }}</div>
            <div class="text-xs text-gray-600">Cancelled</div>
        </div>
        <div class="bg-green-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-green-600">KSh {{ number_format($stats['total_revenue'], 0) }}</div>
            <div class="text-xs text-gray-600">Revenue</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-4 flex gap-3">
        <form method="GET" class="flex-1 flex gap-3">
            <input type="text" name="search" placeholder="Search by order number..." 
                   value="{{ request('search') }}" class="flex-1 border rounded-lg px-3 py-2">
            <select name="status" class="border rounded-lg px-3 py-2">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Reset</a>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium">Order #</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Buyer</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Seller</th>
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
                    <td class="px-4 py-3">{{ $order->seller->name ?? 'N/A' }}</td>
                    <td class="px-4 py-3 font-semibold">KSh {{ number_format($order->total_amount, 2) }}</td>
                    <td class="px-4 py-3">
                        <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="text-xs rounded px-2 py-1 
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 
                                   ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                   ($order->status === 'processing' ? 'bg-purple-100 text-purple-700' : 
                                   ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700'))) }}">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline text-sm">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection
