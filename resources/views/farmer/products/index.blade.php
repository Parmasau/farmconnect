@extends('layouts.dashboard')

@section('title', 'My Products - Farmer')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Products (Selling)</h1>
        <a href="{{ route('farmer.products.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            + Add Product
        </a>
    </div>

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
                                <img src="{{ $product->image_url }}" class="w-10 h-10 object-cover rounded">
                                <div>
                                    <p class="font-medium">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst($product->category) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-semibold text-green-700">KSh {{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-3">{{ $product->quantity }} {{ $product->unit }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $product->status === 'active' ? 'Available' : ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('farmer.products.edit', $product) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                                <form action="{{ route('farmer.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
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
        <div class="mt-6">{{ $products->links() }}</div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">🌾</div>
            <h3 class="text-lg font-medium mb-2">No Products Yet</h3>
            <p class="text-gray-500 mb-4">Start selling by adding your first product</p>
            <a href="{{ route('farmer.products.create') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Add Product</a>
        </div>
    @endif
</div>
@endsection