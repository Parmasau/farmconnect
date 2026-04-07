<?php
// app/Http/Controllers/Public/MarketplaceController.php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status', 'available')
                       ->where('quantity', '>', 0);
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        // Category filter
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Sorting
        switch ($request->sort_by) {
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
        
        $products = $query->paginate(12);
        
        // Get categories for filter
        $categories = Category::withCount(['products' => fn($q) => $q->where('status', 'available')->where('quantity', '>', 0)])->get();
        
        return view('marketplace.index', compact('products', 'categories'));
    }
    
    public function show(Product $product)
    {
        if ($product->status !== 'available' || $product->quantity <= 0) {
            abort(404);
        }
        
        return view('marketplace.show', compact('product'));
    }
}