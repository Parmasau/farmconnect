@extends('layouts.dashboard')
@section('title', 'Order ' . $order->order_number)
@section('sidebar') @include('agrovet.dashboard') @endsection
@section('content')
<a href="{{ route('agrovet.orders.index') }}" class="text-green-700 text-sm hover:underline">← Back</a>
<div class="bg-white rounded-xl shadow p-6 mt-4">
    <div class="flex justify-between items-start mb-6">
        <div><h2 class="text-lg font-bold">{{ $order->order_number }}</h2><p class="text-gray-500 text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p></div>
        <form method="POST" action="{{ route('agrovet.orders.status', $order) }}" class="flex gap-2 items-center">
            @csrf @method('PATCH')
            <select name="status" class="border rounded-lg px-3 py-1.5 text-sm">
                @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm hover:bg-green-800">Update</button>
        </form>
    </div>
    <div class="grid md:grid-cols-2 gap-4 mb-6 text-sm">
        <div><p class="text-xs text-gray-500 mb-1">Buyer</p><p class="font-medium">{{ $order->buyer->name }}</p><p class="text-gray-500">{{ $order->buyer->phone }}</p></div>
        <div><p class="text-xs text-gray-500 mb-1">Delivery Address</p><p>{{ $order->delivery_address }}</p></div>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-xs uppercase text-gray-500"><tr><th class="px-4 py-2 text-left">Product</th><th class="px-4 py-2 text-right">Price</th><th class="px-4 py-2 text-right">Qty</th><th class="px-4 py-2 text-right">Subtotal</th></tr></thead>
        <tbody class="divide-y">
            @foreach($order->items as $item)
            <tr><td class="px-4 py-2">{{ $item->product->name }}</td><td class="px-4 py-2 text-right">KES {{ number_format($item->unit_price,2) }}</td><td class="px-4 py-2 text-right">{{ $item->quantity }}</td><td class="px-4 py-2 text-right font-semibold">KES {{ number_format($item->subtotal,2) }}</td></tr>
            @endforeach
        </tbody>
        <tfoot><tr class="border-t-2 font-bold"><td colspan="3" class="px-4 py-2 text-right">Total</td><td class="px-4 py-2 text-right text-green-700">KES {{ number_format($order->total_amount,2) }}</td></tr></tfoot>
    </table>
</div>
@endsection
