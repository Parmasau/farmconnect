<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('farmer_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->paginate(15);
        
        return view('farmer.products.index', compact('products'));
    }

    public function create()
    {
        $categories = [
        'Vegetables' => 'Vegetables',
        'Fruits' => 'Fruits',
        'Grains' => 'Grains',
        'Dairy' => 'Dairy',
        'Meat' => 'Meat',
        'Seeds' => 'Seeds',
        'Fertilizer' => 'Fertilizer',
        'Equipment' => 'Equipment',
        'Pesticides' => 'Pesticides',
        'Other' => 'Other',
    ];
    
    return view('farmer.products.create', compact('categories'));
}
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

        $data = $request->all();
        $data['farmer_id'] = Auth::id();
        $data['slug'] = Str::slug($request->name);
        $data['status'] = 'available';
        $data['product_type'] = 'sell';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('farmer.products.index')
                         ->with('success', 'Product added successfully!');
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
        $data['slug'] = Str::slug($request->name);

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
        
        $query = Product::where('status', 'available')
                       ->where('quantity', '>', 0)
                       ->with('farmer');
        
        if ($sellerType === 'farmer') {
            $query->where('farmer_id', '!=', Auth::id());
        }
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
                
                if (Schema::hasColumn('products', 'category')) {
                    $q->orWhere('category', 'LIKE', "%{$search}%");
                }
                  
                $q->orWhereHas('farmer', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            });
        }
        
        // Category filter
        if ($request->filled('category') && Schema::hasColumn('products', 'category')) {
            $query->where('category', $request->category);
        }
        
        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Sorting
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
        
        // Get categories
        $categories = collect([]);
        if (Schema::hasColumn('products', 'category')) {
            $categories = Product::where('status', 'available')
                                ->whereNotNull('category')
                                ->distinct()
                                ->pluck('category')
                                ->filter()
                                ->values();
        }
        
        return view('farmer.products.marketplace', compact('products', 'categories', 'sellerType'));
    }
    
    public function viewProduct($id)
    {
        $product = Product::where('id', $id)
                         ->where('farmer_id', '!=', Auth::id())
                         ->where('status', 'available')
                         ->where('quantity', '>', 0)
                         ->with('farmer')
                         ->firstOrFail();
        
        $sellerProducts = Product::where('farmer_id', $product->farmer_id)
                                ->where('status', 'available')
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

public function agrovetProducts(Request $request)
{
    $query = Product::where('user_id', '!=', Auth::id())
                   ->where('status', 'available')
                   ->where('quantity', '>', 0)
                   ->where('product_type', 'sell')
                   ->with('farmer');
    
    // Search filter
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
    
    // Category filter
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }
    
    $products = $query->paginate(20);
    
    $categories = Product::where('user_id', '!=', Auth::id())
                        ->where('status', 'available')
                        ->distinct()
                        ->pluck('category')
                        ->filter()
                        ->values();
    
    return view('farmer.products.agrovet', compact('products', 'categories'));
}