@extends('layouts.app')
@section('title', 'Shopping Cart')
@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-xl font-bold mb-4">Shopping Cart</h1>
    @if($items->isEmpty())
        <div class="bg-white rounded-xl shadow p-10 text-center text-gray-400">
            Your cart is empty. <a href="{{ route('marketplace.index') }}" class="text-green-700 underline">Browse marketplace</a>
        </div>
    @else
    <div class="bg-white rounded-xl shadow overflow-hidden mb-4">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500"><tr><th class="px-4 py-3 text-left">Product</th><th class="px-4 py-3 text-right">Price</th><th class="px-4 py-3 text-right">Qty</th><th class="px-4 py-3 text-right">Subtotal</th><th class="px-4 py-3"></th></tr></thead>
            <tbody class="divide-y">
                @foreach($items as $item)
                <tr>
                    <td class="px-4 py-3">
                        <p class="font-medium">{{ $item->product->name }}</p>
                        <p class="text-xs text-gray-400">by {{ $item->product->owner->name }}</p>
                    </td>
                    <td class="px-4 py-3 text-right">KES {{ number_format($item->product->price,2) }}</td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST" action="{{ route('cart.update', $item) }}" class="flex justify-end gap-1">
                            @csrf @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->quantity }}" class="w-16 border rounded px-2 py-0.5 text-xs text-center">
                            <button class="text-xs text-green-700 hover:underline">Update</button>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right font-semibold">KES {{ number_format($item->quantity * $item->product->price,2) }}</td>
                    <td class="px-4 py-3">
                        <form method="POST" action="{{ route('cart.remove', $item) }}">@csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700">✕</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-t-2 font-bold"><td colspan="3" class="px-4 py-3 text-right">Total</td><td class="px-4 py-3 text-right text-green-700 text-lg">KES {{ number_format($total,2) }}</td><td></td></tr>
            </tfoot>
        </table>
    </div>
    <div class="flex justify-between">
        <form method="POST" action="{{ route('cart.clear') }}">@csrf @method('DELETE')
            <button class="text-red-500 hover:underline text-sm" onclick="return confirm('Clear cart?')">Clear Cart</button>
        </form>
        <a href="{{ route('cart.checkout') }}" class="bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800 font-semibold">Proceed to Checkout →</a>
    </div>
    @endif
</div>
@endsection
