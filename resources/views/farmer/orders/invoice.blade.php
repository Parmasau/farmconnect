@extends('layouts.app')
@section('title', 'Invoice')
@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8 print:shadow-none">
    <div class="flex justify-between items-start mb-8">
        <div><h1 class="text-2xl font-bold text-green-700">🌱 FarmConnect</h1><p class="text-gray-500 text-sm">Invoice</p></div>
        <div class="text-right">
            <p class="font-bold text-lg">{{ $order->order_number }}</p>
            <p class="text-gray-500 text-sm">{{ $order->created_at->format('d M Y') }}</p>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-6 mb-8 text-sm">
        <div><p class="font-semibold text-gray-700 mb-1">Bill To</p><p>{{ $order->buyer->name }}</p><p class="text-gray-500">{{ $order->buyer->email }}</p></div>
        <div><p class="font-semibold text-gray-700 mb-1">From</p><p>{{ $order->seller->name }}</p><p class="text-gray-500">{{ $order->seller->email }}</p></div>
    </div>
    <table class="w-full text-sm mb-6">
        <thead class="bg-gray-50"><tr><th class="px-4 py-2 text-left">Item</th><th class="px-4 py-2 text-right">Price</th><th class="px-4 py-2 text-right">Qty</th><th class="px-4 py-2 text-right">Total</th></tr></thead>
        <tbody class="divide-y">
            @foreach($order->items as $item)
            <tr><td class="px-4 py-2">{{ $item->product->name }}</td><td class="px-4 py-2 text-right">KES {{ number_format($item->unit_price,2) }}</td><td class="px-4 py-2 text-right">{{ $item->quantity }}</td><td class="px-4 py-2 text-right">KES {{ number_format($item->subtotal,2) }}</td></tr>
            @endforeach
        </tbody>
        <tfoot><tr class="border-t-2 font-bold"><td colspan="3" class="px-4 py-2 text-right">Total</td><td class="px-4 py-2 text-right text-green-700">KES {{ number_format($order->total_amount,2) }}</td></tr></tfoot>
    </table>
    <button onclick="window.print()" class="bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800 print:hidden">Print Invoice</button>
</div>
@endsection
