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
                            <i class="fas fa-user text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold">{{ $product->farmer->name ?? 'Farmer' }}</p>
                            <p class="text-sm text-gray-500">Seller</p>
                        </div>
                        <a href="{{ route('farmer.messages.create', ['farmer_id' => $product->farmer_id, 'product_id' => $product->id]) }}" 
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
                
                <div class="flex gap-3 mt-6">
                    <button onclick="showContactModal()" class="flex-1 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 font-semibold">
                        <i class="fas fa-phone-alt"></i> Contact Seller
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Seller's Other Products -->
    @if(isset($sellerProducts) && $sellerProducts->count() > 0)
    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">More from {{ $product->farmer->name ?? 'this seller' }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($sellerProducts as $sellerProduct)
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow overflow-hidden hover:shadow-lg transition">
                <img src="{{ $sellerProduct->image_url }}" class="w-full h-32 object-cover" alt="{{ $sellerProduct->name }}">
                <div class="p-3">
                    <h3 class="font-semibold text-sm">{{ $sellerProduct->name }}</h3>
                    <p class="text-green-700 font-bold text-sm">KSh {{ number_format($sellerProduct->price, 2) }}</p>
                    <a href="{{ route('farmer.products.view', $sellerProduct->id) }}" class="text-blue-600 text-xs hover:underline">View</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Contact Modal -->
<div id="contactModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Contact Seller</h3>
            <p class="text-gray-600 mb-4">You will be redirected to start a conversation with {{ $product->farmer->name ?? 'the seller' }} about this product.</p>
            <div class="flex gap-3">
                <button onclick="hideContactModal()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Cancel</button>
                <a href="{{ route('farmer.messages.create', ['farmer_id' => $product->farmer_id, 'product_id' => $product->id]) }}" 
                   class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg text-center hover:bg-green-700">
                    Continue
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function showContactModal() {
        document.getElementById('contactModal').classList.remove('hidden');
        document.getElementById('contactModal').classList.add('flex');
    }
    
    function hideContactModal() {
        document.getElementById('contactModal').classList.add('hidden');
        document.getElementById('contactModal').classList.remove('flex');
    }
</script>
@endsection