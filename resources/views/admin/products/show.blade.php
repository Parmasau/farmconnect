@extends('layouts.dashboard')

@section('title', 'Product Details - Admin')

@section('sidebar')
    @include('admin.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow">
        <div class="p-4 border-b flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-2xl font-bold">Product Details</h1>
        </div>

        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <img src="{{ $product->image_url }}" class="w-full rounded-lg shadow">
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-2">{{ $product->name }}</h2>
                    <p class="text-3xl font-bold text-green-700 mb-4">KSh {{ number_format($product->price, 2) }}</p>
                    
                    <div class="space-y-2 mb-4">
                        <p><strong>Category:</strong> {{ ucfirst($product->category) }}</p>
                        <p><strong>Stock:</strong> {{ $product->quantity }} {{ $product->unit }}</p>
                        <p><strong>Status:</strong> 
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 
                                   ($product->status === 'inactive' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </p>
                        <p><strong>Seller:</strong> {{ $product->farmer->name ?? 'N/A' }}</p>
                        <p><strong>Seller Email:</strong> {{ $product->farmer->email ?? 'N/A' }}</p>
                        <p><strong>Created:</strong> {{ $product->created_at->format('M d, Y g:i A') }}</p>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold mb-2">Description</h3>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
