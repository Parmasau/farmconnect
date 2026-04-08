@extends('layouts.dashboard')

@section('title', 'Add Product - Farmer')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
        <h1 class="text-2xl font-bold mb-6">Add New Product</h1>
        
        <form method="POST" action="{{ route('farmer.products.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Product Name *</label>
                <input type="text" name="name" class="w-full border rounded-lg px-3 py-2" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
                    <option value="pesticides">Pesticides</option>
                    <option value="other">Other</option>
                </select>
                @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Description *</label>
                <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2" required></textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Price (KSh) *</label>
                    <input type="number" step="0.01" name="price" class="w-full border rounded-lg px-3 py-2" required>
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Quantity *</label>
                    <input type="number" name="quantity" class="w-full border rounded-lg px-3 py-2" required>
                    @error('quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
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
                @error('unit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Product Image</label>
                <input type="file" name="image" accept="image/*" class="w-full border rounded-lg px-3 py-2">
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">Save Product</button>
                <a href="{{ route('farmer.products.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg text-center hover:bg-gray-400">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection