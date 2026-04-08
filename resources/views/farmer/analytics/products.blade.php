@extends('layouts.dashboard')

@section('title', 'Product Performance - FarmConnect')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Product Performance</h1>
        <a href="{{ route('farmer.analytics.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
            Back to Analytics
        </a>
    </div>

    @if(isset($products) && $products->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">Product</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Category</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Price</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Sold</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Revenue</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Stock</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($products as $product)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->image_url }}" class="w-8 h-8 object-cover rounded">
                                <span class="font-medium">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ ucfirst($product->category) }}</td>
                        <td class="px-4 py-3">KSh {{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-3">{{ $product->order_items_count ?? 0 }} units</td>
                        <td class="px-4 py-3 font-semibold text-green-700">
                            KSh {{ number_format(($product->order_items_count ?? 0) * $product->price, 2) }}
                        </td>
                        <td class="px-4 py-3">{{ $product->quantity }} {{ $product->unit }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📦</div>
            <h3 class="text-lg font-medium mb-2">No Products Found</h3>
            <p class="text-gray-500">Add products to start selling.</p>
            <a href="{{ route('farmer.products.create') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 mt-4 inline-block">
                Add Product
            </a>
        </div>
    @endif
</div>
@endsection
