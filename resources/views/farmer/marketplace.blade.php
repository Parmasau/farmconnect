@extends('layouts.dashboard')
@section('title', 'Buy Farm Inputs')
@section('sidebar') @include('farmer.dashboard') @endsection
@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-lg font-semibold">Farm Inputs Marketplace</h2>
    <a href="{{ route('cart.index') }}" class="bg-green-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-800">🛒 View Cart</a>
</div>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @forelse($products as $product)
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="bg-green-50 h-28 flex items-center justify-center text-4xl">🌿</div>
            <div class="p-3">
                <p class="font-semibold text-sm truncate">{{ $product->name }}</p>
                <p class="text-xs text-gray-500">{{ $product->category?->name }}</p>
                <p class="text-green-700 font-bold text-sm mt-1">KES {{ number_format($product->price, 2) }}/{{ $product->unit }}</p>
                <p class="text-xs text-gray-400">by {{ $product->owner->name }}</p>
                <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-2 flex gap-1">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="w-14 border rounded px-2 py-1 text-xs">
                    <button class="flex-1 bg-green-700 text-white rounded text-xs py-1 hover:bg-green-800">Add</button>
                </form>
            </div>
        </div>
    @empty
        <p class="col-span-4 text-center text-gray-400 py-10">No inputs available.</p>
    @endforelse
</div>
<div class="mt-4">{{ $products->links() }}</div>
@endsection
