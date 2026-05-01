{{-- resources/views/farmer/products/agrovet.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Agrovet Products - FarmNest')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Agrovet Products</h1>
            <p class="text-gray-500 text-sm mt-1">Quality agricultural inputs from trusted agrovets</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('cart.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                <i class="fas fa-shopping-cart"></i>
                <span>Cart</span>
                @php
                    $cartCount = App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                @endphp
                @if($cartCount > 0)
                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-0.5">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-gray-50 rounded-xl p-4 mb-6">
        <form method="GET" action="{{ route('farmer.products.agrovet') }}" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Search products..." 
                       value="{{ request('search') }}"
                       class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>
            <div class="w-48">
                <select name="category" class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                @if(request('search') || request('category'))
                    <a href="{{ route('farmer.products.agrovet') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <!-- Product Image -->
                <div class="relative overflow-hidden h-48">
                    <img src="{{ $product->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="{{ $product->name }}">
                    <div class="absolute top-2 right-2">
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">
                            {{ ucfirst($product->category) }}
                        </span>
                    </div>
                </div>
                
                <div class="p-4">
                    <!-- Product Title & Price -->
                    <div class="mb-2">
                        <h3 class="font-bold text-lg text-gray-800 line-clamp-1">{{ $product->name }}</h3>
                        <p class="text-2xl font-bold text-green-700 mt-1">KSh {{ number_format($product->price, 2) }}</p>
                    </div>
                    
                    <!-- Description -->
                    <p class="text-gray-500 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                    
                    <!-- Seller Info -->
                    <div class="bg-green-50 rounded-lg p-3 mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-store text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-sm text-gray-800">{{ $product->seller->name ?? 'Agrovet' }}</p>
                                <p class="text-xs text-gray-500">Agrovet Seller</p>
                            </div>
                            <a href="{{ route('farmer.messages.create', ['farmer_id' => $product->user_id, 'product_id' => $product->id]) }}" 
                               class="text-green-600 hover:text-green-700" title="Message Agrovet">
                                <i class="fas fa-envelope text-lg"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Stock Info -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-boxes text-gray-400 text-sm"></i>
                            <span class="text-sm text-gray-600">Stock: {{ $product->quantity }} {{ $product->unit }}</span>
                        </div>
                        @if($product->quantity <= 10)
                            <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">Low Stock</span>
                        @endif
                    </div>
                    
                    <!-- View Details Button Only (No Add to Cart) -->
                    <a href="{{ route('farmer.products.viewAgrovet', $product->id) }}" 
                       class="w-full bg-green-600 text-white text-center py-2 rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2">
                        <i class="fas fa-eye"></i>
                        <span>View Details</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="text-6xl mb-4">🏪</div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Agrovet Products Available</h3>
            <p class="text-gray-500 mb-6">No products from agrovets at the moment. Please check back later.</p>
        </div>
    @endif
</div>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection