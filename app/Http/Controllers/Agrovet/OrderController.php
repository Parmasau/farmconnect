<?php
// app/Http/Controllers/Agrovet/OrderController.php

namespace App\Http\Controllers\Agrovet;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('seller_id', Auth::id())
                      ->with('buyer')
                      ->orderBy('created_at', 'desc')
                      ->paginate(15);
        
        $stats = [
            'pending' => Order::where('seller_id', Auth::id())->where('status', 'pending')->count(),
            'processing' => Order::where('seller_id', Auth::id())->where('status', 'processing')->count(),
            'shipped' => Order::where('seller_id', Auth::id())->where('status', 'shipped')->count(),
            'delivered' => Order::where('seller_id', Auth::id())->where('status', 'delivered')->count(),
            'completed' => Order::where('seller_id', Auth::id())->where('status', 'completed')->count(),
            'cancelled' => Order::where('seller_id', Auth::id())->where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('seller_id', Auth::id())->where('status', 'completed')->sum('total_amount'),
        ];
        
        return view('agrovet.orders.index', compact('orders', 'stats'));
    }
    
    public function show(Order $order)
    {
        if ($order->seller_id !== Auth::id()) {
            abort(403);
        }
        
        $order->load(['buyer', 'items.product']);
        
        return view('agrovet.orders.show', compact('order'));
    }
    
    public function approveOrder(Order $order)
    {
        if ($order->seller_id !== Auth::id()) {
            abort(403);
        }
        
        $order->update(['status' => 'processing']);
        
        Notification::create([
            'user_id' => $order->buyer_id,
            'title' => 'Order Approved',
            'message' => 'Your order #' . $order->order_number . ' has been approved and is being processed.',
            'type' => 'order',
            'data' => ['order_id' => $order->id],
        ]);
        
        return back()->with('success', 'Order approved successfully!');
    }
    
    public function approvePayment(Order $order)
    {
        if ($order->seller_id !== Auth::id()) {
            abort(403);
        }
        
        $order->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);
        
        Notification::create([
            'user_id' => $order->buyer_id,
            'title' => 'Payment Confirmed',
            'message' => 'Your payment for order #' . $order->order_number . ' has been confirmed.',
            'type' => 'order',
            'data' => ['order_id' => $order->id],
        ]);
        
        return back()->with('success', 'Payment approved successfully!');
    }
    
    public function shipOrder(Order $order)
    {
        if ($order->seller_id !== Auth::id()) {
            abort(403);
        }
        
        $order->update(['status' => 'shipped']);
        
        Notification::create([
            'user_id' => $order->buyer_id,
            'title' => 'Order Shipped',
            'message' => 'Your order #' . $order->order_number . ' has been shipped.',
            'type' => 'order',
            'data' => ['order_id' => $order->id],
        ]);
        
        return back()->with('success', 'Order marked as shipped!');
    }
    
    public function deliverOrder(Order $order)
    {
        if ($order->seller_id !== Auth::id()) {
            abort(403);
        }
        
        $order->update(['status' => 'delivered']);
        
        Notification::create([
            'user_id' => $order->buyer_id,
            'title' => 'Order Delivered',
            'message' => 'Your order #' . $order->order_number . ' has been delivered.',
            'type' => 'order',
            'data' => ['order_id' => $order->id],
        ]);
        
        return back()->with('success', 'Order marked as delivered!');
    }
    
    public function completeOrder(Order $order)
    {
        if ($order->seller_id !== Auth::id()) {
            abort(403);
        }
        
        $order->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
        
        Notification::create([
            'user_id' => $order->buyer_id,
            'title' => 'Order Completed',
            'message' => 'Your order #' . $order->order_number . ' has been completed.',
            'type' => 'order',
            'data' => ['order_id' => $order->id],
        ]);
        
        return back()->with('success', 'Order marked as completed!');
    }
    
    public function cancelOrder(Order $order)
    {
        if ($order->seller_id !== Auth::id()) {
            abort(403);
        }
        
        // Restore product stock
        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product) {
                $product->increment('quantity', $item->quantity);
            }
        }
        
        $order->update(['status' => 'cancelled']);
        
        Notification::create([
            'user_id' => $order->buyer_id,
            'title' => 'Order Cancelled',
            'message' => 'Your order #' . $order->order_number . ' has been cancelled.',
            'type' => 'order',
            'data' => ['order_id' => $order->id],
        ]);
        
        return back()->with('success', 'Order cancelled successfully!');
    }
}