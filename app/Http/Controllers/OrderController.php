<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function createOrder(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->quantity,
            'payment_method' => 'required|string',
            'mpesa_number' => 'nullable|string',
        ]);
        
        // Calculate total
        $total = $product->price * $request->quantity;
        
        // Create order
        $order = Order::create([
            'buyer_id' => Auth::id(),
            'seller_id' => $product->farmer_id ?? $product->user_id,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'subtotal' => $total,
            'tax' => 0,
            'shipping_cost' => 0,
            'total_amount' => $total,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
            'order_type' => 'farmer',
        ]);
        
        // Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $request->quantity,
            'unit_price' => $product->price,
            'total' => $total,
        ]);
        
        // Reduce product stock
        $product->reduceStock($request->quantity);
        
        // Notify seller
        Notification::create([
            'user_id' => $order->seller_id,
            'title' => 'New Order Received',
            'message' => 'You have received a new order #' . $order->order_number,
            'type' => 'order',
            'data' => ['order_id' => $order->id],
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully',
            'order_id' => $order->id
        ]);
    }
    
    public function myOrders()
    {
        $orders = Order::where('buyer_id', Auth::id())
                      ->with(['seller', 'items.product'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(15);
        
        return view('farmer.my-orders', compact('orders'));
    }
}