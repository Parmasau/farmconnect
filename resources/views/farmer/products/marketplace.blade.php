@extends('layouts.dashboard')

@section('title', 'Farmer Marketplace - Buy from Farmers')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Products from Other Farmers</h1>
        <div class="flex gap-3">
            <form method="GET" action="{{ route('farmer.products.marketplace') }}" class="flex gap-2">
                <input type="text" name="search" placeholder="Search products..." 
                       value="{{ request('search') }}"
                       class="border rounded-lg px-3 py-1 text-sm">
                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded-lg text-sm">Search</button>
                @if(request('search'))
                    <a href="{{ route('farmer.products.marketplace') }}" class="bg-gray-500 text-white px-3 py-1 rounded-lg text-sm">Clear</a>
                @endif
            </form>
        </div>
    </div>

    @if(isset($products) && $products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
            <div class="border rounded-xl overflow-hidden hover:shadow-lg transition bg-white">
                <img src="{{ $product->image_url }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-lg">{{ $product->name }}</h3>
                        <span class="text-xl font-bold text-green-700">KSh {{ number_format($product->price, 2) }}</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($product->description, 80) }}</p>
                    
                    <!-- Seller Information -->
                    <div class="bg-gray-50 rounded-lg p-3 mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm">{{ $product->farmer->name ?? 'Farmer' }}</p>
                                <p class="text-xs text-gray-500">Seller</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm text-gray-500">Stock: {{ $product->quantity }} {{ $product->unit }}</span>
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">{{ ucfirst($product->category) }}</span>
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('farmer.products.view', $product->id) }}" 
                           class="flex-1 bg-green-600 text-white text-center py-2 rounded-lg hover:bg-green-700 text-sm">
                            View Details
                        </a>
                        <a href="{{ route('farmer.messages.create', ['farmer_id' => $product->farmer_id, 'product_id' => $product->id]) }}" 
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
            <div class="text-6xl mb-4">🌾</div>
            <h3 class="text-lg font-medium mb-2">No Products Available</h3>
            <p class="text-gray-500 mb-4">No products from other farmers at the moment.</p>
            <a href="{{ route('farmer.products.create') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Sell Your Products
            </a>
        </div>
    @endif
</div>

<style>
    .hover\:shadow-lg:hover {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endsection