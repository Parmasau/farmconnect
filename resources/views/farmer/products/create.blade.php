@extends('layouts.dashboard')

@section('title', 'Add Product')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('farmer.products.index') }}" class="text-green-700 text-sm hover:underline">← Back</a>
    <div class="bg-white rounded-xl shadow p-6 mt-4">
        <h2 class="text-lg font-semibold mb-4">Add New Product</h2>
        <form method="POST" action="{{ route('farmer.products.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Product Name *</label>
                <input type="text" name="name" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Category *</label>
                <select name="category" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Select Category</option>
                    <option value="vegetables">Vegetables</option>
                    <option value="fruits">Fruits</option>
                    <option value="grains">Grains</option>
                    <option value="dairy">Dairy</option>
                    <option value="meat">Meat</option>
                    <option value="seeds">Seeds</option>
                    <option value="fertilizer">Fertilizer</option>
                    <option value="equipment">Equipment</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Description *</label>
                <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2" required></textarea>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Price (KSh) *</label>
                <input type="number" step="0.01" name="price" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Quantity *</label>
                <input type="number" name="quantity" class="w-full border rounded-lg px-3 py-2" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Unit *</label>
                <select name="unit" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="kg">Kilogram (kg)</option>
                    <option value="g">Gram (g)</option>
                    <option value="piece">Piece</option>
                    <option value="bunch">Bunch</option>
                    <option value="liter">Liter (L)</option>
                    <option value="bag">Bag</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Product Image</label>
                <input type="file" name="image" accept="image/*" class="w-full border rounded-lg px-3 py-2">
            </div>
            
            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded-lg hover:bg-green-800 font-semibold">Save Product</button>
        </form>
    </div>
</div>
@endsection