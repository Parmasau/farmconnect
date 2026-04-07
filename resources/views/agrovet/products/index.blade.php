{{-- resources/views/agrovet/products/index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'My Products - Agrovet')

@section('sidebar')
    @include('agrovet.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Products</h1>
        <a href="{{ route('agrovet.products.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            + Add Product
        </a>
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
                        <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($products as $product)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->image_url }}" class="w-10 h-10 object-cover rounded" alt="{{ $product->name }}">
                                <div>
                                    <p class="font-medium">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst($product->category) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">KSh {{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-3">{{ $product->quantity }} {{ $product->unit }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full {{ $product->status === 'available' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('agrovet.products.edit', $product) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                                <button onclick="showStockModal({{ $product->id }}, '{{ $product->name }}', {{ $product->quantity }})" class="text-green-600 hover:underline text-sm">Stock</button>
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
            </table>
        </div>
        
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">🏪</div>
            <h3 class="text-lg font-medium mb-2">No Products Yet</h3>
            <p class="text-gray-500 mb-4">Start selling by adding your first product</p>
            <a href="{{ route('agrovet.products.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
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
                    <label class="block text-sm font-medium mb-1">Product</label>
                    <p id="productName" class="text-gray-700 font-medium"></p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Quantity</label>
                    <input type="number" name="quantity" id="stockQuantity" class="w-full border rounded-lg px-3 py-2" required min="0">
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="hideStockModal()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Cancel</button>
                    <button type="submit" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showStockModal(productId, productName, currentStock) {
        document.getElementById('stockModal').classList.remove('hidden');
        document.getElementById('stockModal').classList.add('flex');
        document.getElementById('productName').textContent = productName;
        document.getElementById('stockQuantity').value = currentStock;
        document.getElementById('stockForm').action = '/agrovet/products/' + productId + '/stock';
    }
    
    function hideStockModal() {
        document.getElementById('stockModal').classList.add('hidden');
        document.getElementById('stockModal').classList.remove('flex');
    }
</script>
@endsection