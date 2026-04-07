@extends('layouts.dashboard')
@section('title', 'Orders')
@section('sidebar') @include('farmer.dashboard') @endsection
@section('content')
<div class="mb-6">
    <h2 class="text-lg font-semibold mb-3">My Purchases</h2>
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr><th class="px-4 py-3 text-left">Order #</th><th class="px-4 py-3 text-left">Seller</th><th class="px-4 py-3 text-left">Total</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-left">Date</th><th class="px-4 py-3"></th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse($purchases as $order)
                <tr>
                    <td class="px-4 py-3 font-mono text-xs">{{ $order->order_number }}</td>
                    <td class="px-4 py-3">{{ $order->seller->name }}</td>
                    <td class="px-4 py-3 font-semibold">KES {{ number_format($order->total_amount, 2) }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-700 capitalize">{{ $order->status }}</span></td>
                    <td class="px-4 py-3 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="{{ route('farmer.orders.show', $order) }}" class="text-green-700 hover:underline">View</a>
                        @if(in_array($order->status, ['pending','confirmed']))
                            <form method="POST" action="{{ route('farmer.orders.cancel', $order) }}">@csrf
                                <button class="text-red-500 hover:underline" onclick="return confirm('Cancel?')">Cancel</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">No purchases yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $purchases->links() }}</div>
</div>

<div>
    <h2 class="text-lg font-semibold mb-3">My Sales</h2>
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr><th class="px-4 py-3 text-left">Order #</th><th class="px-4 py-3 text-left">Buyer</th><th class="px-4 py-3 text-left">Total</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-left">Date</th><th class="px-4 py-3"></th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse($sales as $order)
                <tr>
                    <td class="px-4 py-3 font-mono text-xs">{{ $order->order_number }}</td>
                    <td class="px-4 py-3">{{ $order->buyer->name }}</td>
                    <td class="px-4 py-3 font-semibold">KES {{ number_format($order->total_amount, 2) }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700 capitalize">{{ $order->status }}</span></td>
                    <td class="px-4 py-3 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3"><a href="{{ route('farmer.orders.show', $order) }}" class="text-green-700 hover:underline">View</a></td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">No sales yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $sales->links() }}</div>
</div>
@endsection
