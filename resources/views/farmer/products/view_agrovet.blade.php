{{-- resources/views/farmer/products/view_agrovet.blade.php --}}
@extends('layouts.dashboard')

@section('title', $product->name . ' - Product Details')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow overflow-hidden">
        <div class="md:flex">
            <!-- Product Image -->
            <div class="md:w-1/2">
                <img src="{{ $product->image_url }}" class="w-full h-96 object-cover" alt="{{ $product->name }}">
            </div>
            
            <!-- Product Details -->
            <div class="md:w-1/2 p-6">
                <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
                <p class="text-3xl font-bold text-green-700 mb-4">KSh {{ number_format($product->price, 2) }}</p>
                
                <!-- Seller Info -->
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-store text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold">{{ $product->seller->name ?? 'Agrovet' }}</p>
                            <p class="text-sm text-gray-500">Agrovet</p>
                        </div>
                        <a href="{{ route('farmer.messages.create', ['farmer_id' => $product->user_id, 'product_id' => $product->id]) }}" 
                           class="ml-auto bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                            <i class="fas fa-envelope"></i> Message Seller
                        </a>
                    </div>
                </div>
                
                <!-- Product Details -->
                <div class="mb-4">
                    <h3 class="font-semibold mb-2">Description</h3>
                    <p class="text-gray-600">{{ $product->description }}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <h3 class="font-semibold mb-1">Category</h3>
                        <p class="text-gray-600">{{ ucfirst($product->category) }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">Stock</h3>
                        <p class="text-gray-600">{{ $product->quantity }} {{ $product->unit }}</p>
                    </div>
                </div>
                
                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-6">
                    @csrf
                    <div class="flex gap-3">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}" 
                               class="w-24 border rounded-lg px-3 py-2 text-center">
                        <button type="submit" class="flex-1 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 font-semibold">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection