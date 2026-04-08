@extends('layouts.dashboard')

@section('title', 'Order Details - Admin')

@section('sidebar')
    @include('admin.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow">
        <div class="p-4 border-b flex items-center gap-3">
            <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-2xl font-bold">Order #{{ $order->order_number }}</h1>
        </div>

        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="font-semibold mb-2">Buyer Information</h3>
                    <p><strong>Name:</strong> {{ $order->buyer->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $order->buyer->email ?? 'N/A' }}</p>
                    <p><strong>Phone:</strong> {{ $order->buyer->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Seller Information</h3>
                    <p><strong>Name:</strong> {{ $order->seller->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $order->seller->email ?? 'N/A' }}</p>
                    <p><strong>Role:</strong> {{ ucfirst($order->seller->role ?? 'N/A') }}</p>
                </div>
            </div>

            <h3 class="font-semibold mb-2">Order Items</h3>
            <div class="overflow-x-auto mb-6">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Product</th>
                            <th class="px-4 py-2 text-center">Quantity</th>
                            <th class="px-4 py-2 text-right">Unit Price</th>
                            <th class="px-4 py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-4 py-2">{{ $item->product_name ?? $item->product->name }}</td>
                            <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                            <td class="px-4 py-2 text-right">KSh {{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-4 py-2 text-right">KSh {{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-right font-semibold">Total:</td>
                            <td class="px-4 py-2 text-right font-bold">KSh {{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold mb-2">Payment Information</h3>
                    <p><strong>Status:</strong> 
                        <span class="px-2 py-1 text-xs rounded-full {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                    <p><strong>Method:</strong> {{ $order->payment_method ?? 'N/A' }}</p>
                    <p><strong>Paid At:</strong> {{ $order->paid_at ? $order->paid_at->format('M d, Y g:i A') : 'Not paid' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Delivery Information</h3>
                    <p><strong>Address:</strong> {{ $order->delivery_address ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                    <p><strong>Notes:</strong> {{ $order->notes ?? 'None' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
