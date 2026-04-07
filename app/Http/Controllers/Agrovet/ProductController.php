<?php
// app/Http/Controllers/Agrovet/ProductController.php

namespace App\Http\Controllers\Agrovet;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->paginate(15);
        
        return view('agrovet.products.index', compact('products'));
    }

    public function create()
    {
        return view('agrovet.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string',
            'category' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Generate unique slug
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        
        // Check if slug exists and make it unique
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['slug'] = $slug;
        $data['status'] = 'active';
        $data['product_type'] = 'sell';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('agrovet.products.index')
                         ->with('success', 'Product added successfully! Farmers can now see and purchase this product.');
    }

    public function show(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('agrovet.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('agrovet.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'unit' => 'required|string',
            'category' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        
        // Update slug if name changed
        if ($product->name !== $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;
            
            while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $data['slug'] = $slug;
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('agrovet.products.index')
                         ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('agrovet.products.index')
                         ->with('success', 'Product deleted successfully!');
    }

    public function updateStock(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $product->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Stock updated successfully!');
    }
}