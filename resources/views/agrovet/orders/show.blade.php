{{-- resources/views/agrovet/orders/show.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Order Details - Agrovet')

@section('sidebar')
    @include('agrovet.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow">
        <div class="p-4 border-b">
            <div class="flex justify-between items-center">
                <div>
                    <a href="{{ route('agrovet.orders.index') }}" class="text-gray-600 hover:text-gray-800">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                    <h1 class="text-2xl font-bold mt-2">Order #{{ $order->order_number }}</h1>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('M d, Y g:i A') }}</p>
                    <span class="px-3 py-1 text-sm rounded-full 
                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 
                           ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                           ($order->status === 'processing' ? 'bg-blue-100 text-blue-700' : 
                           ($order->status === 'shipped' ? 'bg-purple-100 text-purple-700' : 
                           ($order->status === 'delivered' ? 'bg-indigo-100 text-indigo-700' : 'bg-red-100 text-red-700')))) }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Customer Info -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h3 class="font-semibold mb-3">Customer Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Name</p>
                        <p class="font-medium">{{ $order->buyer->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-medium">{{ $order->buyer->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <p class="font-medium">{{ $order->buyer->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Payment Method</p>
                        <p class="font-medium">{{ ucfirst($order->payment_method) }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <h3 class="font-semibold mb-3">Order Items</h3>
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
                            <td class="px-4 py-2">{{ $item->product_name }}</td>
                            <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                            <td class="px-4 py-2 text-right">KSh {{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-4 py-2 text-right">KSh {{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-right font-semibold">Total:</td>
                            <td class="px-4 py-2 text-right font-bold text-green-700">KSh {{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Order Actions -->
            <div class="border-t pt-4">
                <h3 class="font-semibold mb-3">Order Actions</h3>
                <div class="flex flex-wrap gap-2">
                    @if($order->status === 'pending')
                        <form action="{{ route('agrovet.orders.approve', $order) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                Approve Order
                            </button>
                        </form>
                    @endif
                    
                    @if($order->payment_status === 'pending' && $order->status !== 'cancelled')
                        <form action="{{ route('agrovet.orders.approvePayment', $order) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                Approve Payment
                            </button>
                        </form>
                    @endif
                    
                    @if($order->status === 'processing')
                        <form action="{{ route('agrovet.orders.ship', $order) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                                Mark as Shipped
                            </button>
                        </form>
                    @endif
                    
                    @if($order->status === 'shipped')
                        <form action="{{ route('agrovet.orders.deliver', $order) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                                Mark as Delivered
                            </button>
                        </form>
                    @endif
                    
                    @if($order->status === 'delivered')
                        <form action="{{ route('agrovet.orders.complete', $order) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                Complete Order
                            </button>
                        </form>
                    @endif
                    
                    @if(in_array($order->status, ['pending', 'processing']))
                        <form action="{{ route('agrovet.orders.cancel', $order) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                                Cancel Order
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection