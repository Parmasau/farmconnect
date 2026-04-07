<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('buyer_id', Auth::id())
                      ->with('seller')
                      ->orderBy('created_at', 'desc')
                      ->paginate(15);
        
        return view('farmer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->buyer_id !== Auth::id(), 403);
        
        $order->load(['seller', 'items.product']);
        
        return view('farmer.orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        abort_if($order->buyer_id !== Auth::id(), 403);
        
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }
        
        $order->update(['status' => 'cancelled']);
        
        return redirect()->route('farmer.orders.index')
                         ->with('success', 'Order cancelled successfully.');
    }

    public function track(Order $order)
    {
        abort_if($order->buyer_id !== Auth::id(), 403);
        
        return view('farmer.orders.track', compact('order'));
    }

    public function invoice(Order $order)
    {
        abort_if($order->buyer_id !== Auth::id(), 403);
        
        return view('farmer.orders.invoice', compact('order'));
    }
}