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
    /**
     * Display a listing of agrovet products.
     */
    public function index()
    {
        $products = Product::where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->paginate(15);
        
        $stats = [
            'total' => $products->total(),
            'active' => Product::where('user_id', Auth::id())->where('status', 'active')->count(),
            'out_of_stock' => Product::where('user_id', Auth::id())->where('quantity', 0)->count(),
            'low_stock' => Product::where('user_id', Auth::id())->where('quantity', '<', 10)->where('quantity', '>', 0)->count(),
        ];
        
        return view('agrovet.products.index', compact('products', 'stats'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('agrovet.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
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
                         ->with('success', 'Product added successfully!');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('agrovet.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('agrovet.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
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

    /**
     * Remove the specified product from storage.
     */
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

    /**
     * Update product stock.
     */
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