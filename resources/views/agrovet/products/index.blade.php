{{-- resources/views/agrovet/products/index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'My Products - Agrovet')

@section('sidebar')
    @include('agrovet.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Products</h1>
        <a href="{{ route('agrovet.products.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i> Add Product
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-blue-600">{{ $stats['total'] }}</div>
            <div class="text-xs text-gray-600">Total Products</div>
        </div>
        <div class="bg-green-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-green-600">{{ $stats['active'] }}</div>
            <div class="text-xs text-gray-600">Active</div>
        </div>
        <div class="bg-yellow-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-yellow-600">{{ $stats['low_stock'] }}</div>
            <div class="text-xs text-gray-600">Low Stock</div>
        </div>
        <div class="bg-red-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-red-600">{{ $stats['out_of_stock'] }}</div>
            <div class="text-xs text-gray-600">Out of Stock</div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($products->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">Product</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Price</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Stock</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Category</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($products as $product)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->image_url }}" class="w-10 h-10 object-cover rounded">
                                <div>
                                    <p class="font-medium">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Str::limit($product->description, 40) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-semibold text-green-700">KSh {{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-3">
                            {{ $product->quantity }} {{ $product->unit }}
                            <button onclick="openStockModal({{ $product->id }}, {{ $product->quantity }})" class="ml-2 text-blue-600 hover:underline text-xs">Update</button>
                        </td>
                        <td class="px-4 py-3">{{ ucfirst($product->category) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 
                                   ($product->status === 'inactive' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ $product->status === 'active' ? 'Active' : ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('agrovet.products.edit', $product) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                                <form action="{{ route('agrovet.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            <tr>
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">🏪</div>
            <h3 class="text-lg font-medium mb-2">No Products Yet</h3>
            <p class="text-gray-500 mb-4">Start selling by adding your first product</p>
            <a href="{{ route('agrovet.products.create') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Add Product
            </a>
        </div>
    @endif
</div>

<!-- Stock Update Modal -->
<div id="stockModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Update Stock</h3>
            <form id="stockForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Quantity</label>
                    <input type="number" name="quantity" id="stockQuantity" class="w-full border rounded-lg px-3 py-2" required min="0">
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeStockModal()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Cancel</button>
                    <button type="submit" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openStockModal(productId, currentStock) {
        const modal = document.getElementById('stockModal');
        const form = document.getElementById('stockForm');
        const quantityInput = document.getElementById('stockQuantity');
        
        form.action = '/agrovet/products/' + productId + '/stock';
        quantityInput.value = currentStock;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeStockModal() {
        const modal = document.getElementById('stockModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    // Close modal when clicking outside
    document.getElementById('stockModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeStockModal();
        }
    });
</script>
@endsection