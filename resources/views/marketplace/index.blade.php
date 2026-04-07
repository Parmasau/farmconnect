@extends('layouts.app')
@section('title', 'Marketplace')
@section('content')
<div class="flex gap-6">
    {{-- Sidebar categories --}}
    <aside class="w-48 shrink-0">
        <h3 class="font-semibold text-gray-700 mb-3">Categories</h3>
        <ul class="space-y-1 text-sm">
            <li><a href="{{ route('marketplace.index') }}" class="block px-3 py-1 rounded hover:bg-green-100 {{ !request('category') ? 'bg-green-100 text-green-700 font-semibold' : 'text-gray-600' }}">All Products</a></li>
            @foreach($categories as $cat)
                <li><a href="{{ route('marketplace.index', ['category' => $cat->slug]) }}"
                    class="block px-3 py-1 rounded hover:bg-green-100 {{ request('category') === $cat->slug ? 'bg-green-100 text-green-700 font-semibold' : 'text-gray-600' }}">
                    {{ $cat->name }} <span class="text-gray-400">({{ $cat->products_count }})</span>
                </a></li>
            @endforeach
        </ul>
    </aside>

    {{-- Products --}}
    <div class="flex-1">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-gray-800">Marketplace</h1>
            <form method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                    class="border rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                <button class="bg-green-700 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-green-800">Search</button>
            </form>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($products as $product)
                <a href="{{ route('marketplace.show', $product) }}" class="bg-white rounded-xl shadow hover:shadow-md overflow-hidden transition">
                    <div class="bg-green-50 h-32 flex items-center justify-center text-4xl">🌿</div>
                    <div class="p-3">
                        <p class="font-semibold text-sm truncate">{{ $product->name }}</p>
                        <p class="text-xs text-gray-500">{{ $product->category?->name }}</p>
                        <p class="text-green-700 font-bold text-sm mt-1">KES {{ number_format($product->price, 2) }}/{{ $product->unit }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">by {{ $product->owner->name }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-4 text-center text-gray-500 py-16">No products found.</p>
            @endforelse
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    </div>
</div>
@endsection
