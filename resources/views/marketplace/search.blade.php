@extends('layouts.app')
@section('title', 'Search Results')
@section('content')
<h1 class="text-xl font-bold mb-4">Search results for "{{ request('q') }}"</h1>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @forelse($products as $product)
        <a href="{{ route('marketplace.show', $product) }}" class="bg-white rounded-xl shadow hover:shadow-md overflow-hidden">
            <div class="bg-green-50 h-32 flex items-center justify-center text-4xl">🌿</div>
            <div class="p-3">
                <p class="font-semibold text-sm truncate">{{ $product->name }}</p>
                <p class="text-green-700 font-bold text-sm">KES {{ number_format($product->price, 2) }}/{{ $product->unit }}</p>
            </div>
        </a>
    @empty
        <p class="col-span-4 text-center text-gray-500 py-16">No results found.</p>
    @endforelse
</div>
<div class="mt-4">{{ $products->links() }}</div>
@endsection
