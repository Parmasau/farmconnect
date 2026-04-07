<?php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('farmer')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }
}