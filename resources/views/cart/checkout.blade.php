@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-green-600">Checkout</p>
                <h1 class="text-3xl font-bold text-gray-900">Confirm your order</h1>
            </div>
            <div class="rounded-full bg-green-50 px-4 py-2 text-green-700">Total: KES {{ number_format($total, 2) }}</div>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900">Items in your cart</h2>
        <div class="mt-4 space-y-4">
            @foreach($items as $item)
                <div class="rounded-3xl border border-gray-100 p-4">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                            <p class="text-sm text-gray-500">Seller: {{ $item->product->owner->name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">KES {{ number_format($item->product->price, 2) }} x {{ $item->quantity }}</p>
                            <p class="text-sm text-gray-500">Subtotal: KES {{ number_format($item->quantity * $item->product->price, 2) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <form method="POST" action="{{ route('cart.process') }}" class="rounded-3xl bg-white p-6 shadow-sm space-y-6">
        @csrf
        <div>
            <label class="text-sm font-medium text-gray-700">Delivery Address</label>
            <textarea name="delivery_address" rows="4" required class="mt-2 w-full rounded-3xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-100">{{ old('delivery_address') }}</textarea>
            @error('delivery_address') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700">Notes</label>
            <textarea name="notes" rows="3" class="mt-2 w-full rounded-3xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-100">{{ old('notes') }}</textarea>
        </div>

        <button type="submit" class="w-full rounded-3xl bg-green-700 px-6 py-3 text-sm font-semibold text-white hover:bg-green-800">Place Order & Pay</button>
    </form>
</div>
@endsection
