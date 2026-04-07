<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Product Name *</label>
    <input type="text" name="name" class="w-full border rounded-lg px-3 py-2" value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Category *</label>
    <select name="category" class="w-full border rounded-lg px-3 py-2" required>
        <option value="">Select Category</option>
        <option value="vegetables" {{ old('category', $product->category ?? '') == 'vegetables' ? 'selected' : '' }}>Vegetables</option>
        <option value="fruits" {{ old('category', $product->category ?? '') == 'fruits' ? 'selected' : '' }}>Fruits</option>
        <option value="grains" {{ old('category', $product->category ?? '') == 'grains' ? 'selected' : '' }}>Grains</option>
        <option value="dairy" {{ old('category', $product->category ?? '') == 'dairy' ? 'selected' : '' }}>Dairy</option>
        <option value="meat" {{ old('category', $product->category ?? '') == 'meat' ? 'selected' : '' }}>Meat</option>
        <option value="seeds" {{ old('category', $product->category ?? '') == 'seeds' ? 'selected' : '' }}>Seeds</option>
        <option value="fertilizer" {{ old('category', $product->category ?? '') == 'fertilizer' ? 'selected' : '' }}>Fertilizer</option>
        <option value="equipment" {{ old('category', $product->category ?? '') == 'equipment' ? 'selected' : '' }}>Equipment</option>
        <option value="pesticides" {{ old('category', $product->category ?? '') == 'pesticides' ? 'selected' : '' }}>Pesticides</option>
        <option value="other" {{ old('category', $product->category ?? '') == 'other' ? 'selected' : '' }}>Other</option>
    </select>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Description *</label>
    <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2" required>{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Price (KSh) *</label>
    <input type="number" step="0.01" name="price" class="w-full border rounded-lg px-3 py-2" value="{{ old('price', $product->price ?? '') }}" required>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Quantity *</label>
    <input type="number" name="quantity" class="w-full border rounded-lg px-3 py-2" value="{{ old('quantity', $product->quantity ?? '') }}" required>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Unit *</label>
    <select name="unit" class="w-full border rounded-lg px-3 py-2" required>
        <option value="kg" {{ old('unit', $product->unit ?? '') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
        <option value="g" {{ old('unit', $product->unit ?? '') == 'g' ? 'selected' : '' }}>Gram (g)</option>
        <option value="piece" {{ old('unit', $product->unit ?? '') == 'piece' ? 'selected' : '' }}>Piece</option>
        <option value="bunch" {{ old('unit', $product->unit ?? '') == 'bunch' ? 'selected' : '' }}>Bunch</option>
        <option value="liter" {{ old('unit', $product->unit ?? '') == 'liter' ? 'selected' : '' }}>Liter (L)</option>
        <option value="bag" {{ old('unit', $product->unit ?? '') == 'bag' ? 'selected' : '' }}>Bag</option>
    </select>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Product Image</label>
    <input type="file" name="image" accept="image/*" class="w-full border rounded-lg px-3 py-2">
    @if(isset($product) && $product->image)
        <div class="mt-2">
            <img src="{{ $product->image_url }}" class="h-20 w-20 object-cover rounded">
            <p class="text-xs text-gray-500 mt-1">Current image</p>
        </div>
    @endif
</div>
