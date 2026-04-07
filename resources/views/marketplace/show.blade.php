@extends('layouts.app')
@section('title', $product->name)
@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('marketplace.index') }}" class="text-green-700 text-sm hover:underline">← Back to Marketplace</a>
    <div class="bg-white rounded-xl shadow mt-4 overflow-hidden">
        <div class="md:flex">
            <div class="bg-green-50 md:w-80 h-64 flex items-center justify-center text-7xl shrink-0">🌿</div>
            <div class="p-6 flex-1">
                <p class="text-xs text-gray-400 uppercase tracking-wide">{{ $product->category?->name }}</p>
                <h1 class="text-2xl font-bold mt-1 mb-2">{{ $product->name }}</h1>
                <p class="text-3xl font-bold text-green-700 mb-1">KES {{ number_format($product->price, 2) }}<span class="text-base font-normal text-gray-500">/{{ $product->unit }}</span></p>
                <p class="text-sm text-gray-500 mb-4">{{ $product->quantity }} {{ $product->unit }}(s) available · Sold by <strong>{{ $product->owner->name }}</strong></p>
                <p class="text-gray-700 mb-6">{{ $product->description }}</p>

                @auth
                    @if(auth()->user()->isFarmer() || auth()->user()->isAgrovet())
                        <form method="POST" action="{{ route('cart.add', $product) }}" class="flex gap-3 items-center">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}"
                                class="w-20 border rounded-lg px-3 py-2 text-sm">
                            <button class="bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800 font-semibold">Add to Cart</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800 font-semibold inline-block">Login to Buy</a>
                @endauth
            </div>
        </div>
    </div>

    @if($related->isNotEmpty())
        <h2 class="text-lg font-bold mt-8 mb-4">Related Products</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($related as $r)
                <a href="{{ route('marketplace.show', $r) }}" class="bg-white rounded-xl shadow hover:shadow-md overflow-hidden">
                    <div class="bg-green-50 h-28 flex items-center justify-center text-3xl">🌿</div>
                    <div class="p-3">
                        <p class="font-semibold text-sm truncate">{{ $r->name }}</p>
                        <p class="text-green-700 font-bold text-sm">KES {{ number_format($r->price, 2) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
