@extends('layouts.dashboard')

@section('title', 'Manage Products - Admin')

@section('sidebar')
    @include('admin.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manage Products</h1>
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
        <div class="bg-red-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-red-600">{{ $stats['inactive'] }}</div>
            <div class="text-xs text-gray-600">Inactive</div>
        </div>
        <div class="bg-yellow-50 rounded-xl p-3 text-center">
            <div class="text-xl font-bold text-yellow-600">{{ $stats['out_of_stock'] }}</div>
            <div class="text-xs text-gray-600">Out of Stock</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-4 flex gap-3">
        <form method="GET" class="flex-1 flex gap-3">
            <input type="text" name="search" placeholder="Search by name..." 
                   value="{{ request('search') }}" class="flex-1 border rounded-lg px-3 py-2">
            <select name="status" class="border rounded-lg px-3 py-2">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
            </select>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Filter</button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Reset</a>
        </form>
    </div>

    <!-- Products Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium">Product</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Seller</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Price</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Stock</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-medium">Created</th>
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
                    <td class="px-4 py-3">{{ $product->farmer->name ?? 'N/A' }}<br>
                        <span class="text-xs text-gray-500">{{ ucfirst($product->farmer->role ?? '') }}</span>
                    </td>
                    <td class="px-4 py-3 font-semibold">KSh {{ number_format($product->price, 2) }}</td>
                    <td class="px-4 py-3">{{ $product->quantity }} {{ $product->unit }}</td>
                    <td class="px-4 py-3">
                        <form action="{{ route('admin.products.status', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="text-xs rounded px-2 py-1 
                                {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 
                                   ($product->status === 'inactive' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="out_of_stock" {{ $product->status === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $product->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 hover:underline text-sm">View</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
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
</div>
@endsection
