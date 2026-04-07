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
            'completed' => Order::where('seller_id', Auth::id())->where('status', 'completed')->count(),
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

    public function updateStatus(Request $request, Order $order)
    {
        if ($order->seller_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        // Create notification for buyer
        Notification::create([
            'user_id' => $order->buyer_id,
            'title' => 'Order Status Update',
            'message' => 'Your order #' . $order->order_number . ' is now ' . ucfirst($request->status),
            'type' => 'order',
            'data' => ['order_id' => $order->id],
        ]);

        return back()->with('success', 'Order status updated successfully!');
    }
    
    public function approvePayment(Request $request, Order $order)
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
            'message' => 'Your payment for order #' . $order->order_number . ' has been confirmed',
            'type' => 'order',
            'data' => ['order_id' => $order->id],
        ]);
        
        return back()->with('success', 'Payment approved successfully!');
    }
}