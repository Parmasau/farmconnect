{{-- resources/views/farmer/products/agrovet.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Agrovet Products - FarmConnect')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Agrovet Products</h1>
    </div>

    <!-- Search and Filter -->
    <div class="mb-6">
        <form method="GET" action="{{ route('farmer.products.agrovet') }}" class="flex gap-4">
            <input type="text" name="search" placeholder="Search products..." 
                   value="{{ request('search') }}"
                   class="flex-1 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500">
            <select name="category" class="border rounded-lg px-4 py-2">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                        {{ ucfirst($cat) }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Search
            </button>
        </form>
    </div>

    @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
            <div class="border rounded-xl overflow-hidden hover:shadow-lg transition">
                <img src="{{ $product->image_url }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">
                <div class="p-4">
                    <h3 class="font-bold text-lg mb-1">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->description, 80) }}</p>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-2xl font-bold text-green-700">KSh {{ number_format($product->price, 2) }}</span>
                        <span class="text-sm text-gray-500">Stock: {{ $product->quantity }} {{ $product->unit }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">{{ ucfirst($product->category) }}</span>
                        <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full">Seller: {{ $product->farmer->name ?? 'Agrovet' }}</span>
                    </div>
                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('farmer.products.view', $product->id) }}" 
                           class="flex-1 bg-green-600 text-white text-center py-2 rounded-lg hover:bg-green-700">
                            View Details
                        </a>
                        <a href="{{ route('farmer.messages.create', ['farmer_id' => $product->user_id, 'product_id' => $product->id]) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">🏪</div>
            <h3 class="text-lg font-medium mb-2">No Products Found</h3>
            <p class="text-gray-500">No agrovet products available at the moment.</p>
        </div>
    @endif
</div>
@endsection