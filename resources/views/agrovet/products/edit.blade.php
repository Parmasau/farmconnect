{{-- resources/views/agrovet/products/edit.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Edit Product - Agrovet')

@section('sidebar')
    @include('agrovet.sidebar')
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('agrovet.products.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-2xl font-bold">Edit Product</h1>
        </div>

        <form method="POST" action="{{ route('agrovet.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Product Name *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Category *</label>
                <select name="category" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" required>
                    <option value="">Select Category</option>
                    <option value="fertilizer" {{ old('category', $product->category) == 'fertilizer' ? 'selected' : '' }}>Fertilizer</option>
                    <option value="pesticide" {{ old('category', $product->category) == 'pesticide' ? 'selected' : '' }}>Pesticide</option>
                    <option value="seed" {{ old('category', $product->category) == 'seed' ? 'selected' : '' }}>Seeds</option>
                    <option value="equipment" {{ old('category', $product->category) == 'equipment' ? 'selected' : '' }}>Equipment</option>
                    <option value="animal_feed" {{ old('category', $product->category) == 'animal_feed' ? 'selected' : '' }}>Animal Feed</option>
                    <option value="vaccine" {{ old('category', $product->category) == 'vaccine' ? 'selected' : '' }}>Vaccine</option>
                    <option value="other" {{ old('category', $product->category) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Description *</label>
                <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" required>{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Price (KSh) *</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" required>
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Quantity *</label>
                    <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" required>
                    @error('quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Unit *</label>
                <select name="unit" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" required>
                    <option value="kg" {{ old('unit', $product->unit) == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                    <option value="g" {{ old('unit', $product->unit) == 'g' ? 'selected' : '' }}>Gram (g)</option>
                    <option value="litre" {{ old('unit', $product->unit) == 'litre' ? 'selected' : '' }}>Litre (L)</option>
                    <option value="ml" {{ old('unit', $product->unit) == 'ml' ? 'selected' : '' }}>Millilitre (ml)</option>
                    <option value="piece" {{ old('unit', $product->unit) == 'piece' ? 'selected' : '' }}>Piece</option>
                    <option value="bag" {{ old('unit', $product->unit) == 'bag' ? 'selected' : '' }}>Bag</option>
                    <option value="bottle" {{ old('unit', $product->unit) == 'bottle' ? 'selected' : '' }}>Bottle</option>
                </select>
                @error('unit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Product Image</label>
                @if($product->image)
                    <div class="mb-2">
                        <img src="{{ $product->image_url }}" class="h-20 w-20 object-cover rounded">
                        <p class="text-xs text-gray-500 mt-1">Current image</p>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full border rounded-lg px-3 py-2">
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                    Update Product
                </button>
                <a href="{{ route('agrovet.products.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg text-center hover:bg-gray-400">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection