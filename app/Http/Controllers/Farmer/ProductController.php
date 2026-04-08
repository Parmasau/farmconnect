<?php
// app/Http/Controllers/Farmer/ProductController.php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Products the farmer is selling
    public function index()
    {
        $products = Product::where('farmer_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->paginate(15);
        
        return view('farmer.products.index', compact('products'));
    }

    // Products the farmer has purchased (bought from others)
    public function purchased()
    {
        $purchasedProducts = Order::where('buyer_id', Auth::id())
                                 ->with('items.product')
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(15);
        
        return view('farmer.products.purchased', compact('purchasedProducts'));
    }

    // Show agrovet products for farmers to buy
    public function agrovetProducts(Request $request)
    {
        $query = Product::where('user_id', '!=', Auth::id())
                       ->where('status', 'active')
                       ->where('quantity', '>', 0)
                       ->where('product_type', 'sell')
                       ->with('seller');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%")
                  ->orWhereHas('seller', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        $products = $query->paginate(20);
        
        $categories = Product::where('status', 'active')
                            ->distinct()
                            ->pluck('category')
                            ->filter()
                            ->values();
        
        return view('farmer.products.agrovet', compact('products', 'categories'));
    }

    // View a single agrovet product
    public function viewAgrovet($id)
    {
        $product = Product::where('id', $id)
                         ->where('status', 'active')
                         ->where('quantity', '>', 0)
                         ->with('seller')
                         ->firstOrFail();
        
        return view('farmer.products.view_agrovet', compact('product'));
    }

    public function create()
    {
        return view('farmer.products.create');
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
        
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $data = $request->all();
        $data['farmer_id'] = Auth::id();
        $data['user_id'] = Auth::id(); // Add this for compatibility
        $data['slug'] = $slug;
        $data['status'] = 'active';
        $data['product_type'] = 'sell';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('farmer.products.index')
                         ->with('success', 'Product added successfully! Other farmers can now see your product.');
    }

    public function show(Product $product)
    {
        if ($product->farmer_id !== Auth::id()) {
            abort(403);
        }
        
        return view('farmer.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if ($product->farmer_id !== Auth::id()) {
            abort(403);
        }
        
        return view('farmer.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->farmer_id !== Auth::id()) {
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

        return redirect()->route('farmer.products.index')
                         ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->farmer_id !== Auth::id()) {
            abort(403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('farmer.products.index')
                         ->with('success', 'Product deleted successfully!');
    }

    public function marketplace(Request $request)
    {
        $sellerType = $request->get('seller', 'farmer');
        
        $query = Product::where('status', 'active')
                       ->where('quantity', '>', 0)
                       ->where('product_type', 'sell')
                       ->with('farmer');
        
        if ($sellerType === 'farmer') {
            $query->where('farmer_id', '!=', Auth::id());
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%")
                  ->orWhereHas('farmer', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $products = $query->paginate(20);
        
        $categories = Product::where('status', 'active')
                            ->distinct()
                            ->pluck('category')
                            ->filter()
                            ->values();
        
        return view('farmer.products.marketplace', compact('products', 'categories', 'sellerType'));
    }
    
    public function viewProduct($id)
    {
        $product = Product::where('id', $id)
                         ->where('farmer_id', '!=', Auth::id())
                         ->where('status', 'active')
                         ->where('quantity', '>', 0)
                         ->with('farmer')
                         ->firstOrFail();
        
        $sellerProducts = Product::where('farmer_id', $product->farmer_id)
                                ->where('status', 'active')
                                ->where('quantity', '>', 0)
                                ->where('id', '!=', $product->id)
                                ->limit(4)
                                ->get();
        
        return view('farmer.products.view', compact('product', 'sellerProducts'));
    }
    
    public function contactSeller($productId)
    {
        $product = Product::findOrFail($productId);
        
        if ($product->farmer_id == Auth::id()) {
            return redirect()->back()->with('error', 'You cannot message yourself.');
        }
        
        return redirect()->route('farmer.messages.create', ['farmer_id' => $product->farmer_id, 'product_id' => $productId]);
    }
}