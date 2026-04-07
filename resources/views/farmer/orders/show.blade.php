@extends('layouts.dashboard')
@section('title', 'Order ' . $order->order_number)
@section('sidebar') @include('farmer.dashboard') @endsection
@section('content')
<a href="{{ route('farmer.orders.index') }}" class="text-green-700 text-sm hover:underline">← Back to Orders</a>
<div class="bg-white rounded-xl shadow p-6 mt-4">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h2 class="text-lg font-bold">{{ $order->order_number }}</h2>
            <p class="text-gray-500 text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        <span class="px-3 py-1 rounded-full text-sm font-semibold capitalize
            {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
            {{ $order->status }}
        </span>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <div><p class="text-xs text-gray-500 uppercase mb-1">Buyer</p><p class="font-medium">{{ $order->buyer->name }}</p><p class="text-sm text-gray-500">{{ $order->buyer->phone }}</p></div>
        <div><p class="text-xs text-gray-500 uppercase mb-1">Seller</p><p class="font-medium">{{ $order->seller->name }}</p><p class="text-sm text-gray-500">{{ $order->seller->phone }}</p></div>
        <div><p class="text-xs text-gray-500 uppercase mb-1">Delivery Address</p><p class="text-sm">{{ $order->delivery_address }}</p></div>
        <div><p class="text-xs text-gray-500 uppercase mb-1">Payment</p><span class="px-2 py-0.5 rounded-full text-xs capitalize {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $order->payment_status }}</span></div>
    </div>

    <table class="w-full text-sm mb-4">
        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
            <tr><th class="px-4 py-2 text-left">Product</th><th class="px-4 py-2 text-right">Unit Price</th><th class="px-4 py-2 text-right">Qty</th><th class="px-4 py-2 text-right">Subtotal</th></tr>
        </thead>
        <tbody class="divide-y">
            @foreach($order->items as $item)
            <tr>
                <td class="px-4 py-2">{{ $item->product->name }}</td>
                <td class="px-4 py-2 text-right">KES {{ number_format($item->unit_price, 2) }}</td>
                <td class="px-4 py-2 text-right">{{ $item->quantity }}</td>
                <td class="px-4 py-2 text-right font-semibold">KES {{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="border-t-2"><td colspan="3" class="px-4 py-2 text-right font-bold">Total</td><td class="px-4 py-2 text-right font-bold text-green-700">KES {{ number_format($order->total_amount, 2) }}</td></tr>
        </tfoot>
    </table>
</div>
@endsection
