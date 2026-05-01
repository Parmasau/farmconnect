<?php
// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
                        ->with('product')
                        ->get();
        
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->quantity,
        ]);

        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $product->id)
                    ->first();

        if ($cart) {
            $cart->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cart->product->quantity,
        ]);

        $cart->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())
                        ->with('product')
                        ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.checkout', compact('cartItems', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())
                        ->with('product')
                        ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Group items by seller
        $itemsBySeller = $cartItems->groupBy(function($item) {
            return $item->product->farmer_id ?? $item->product->user_id;
        });

        foreach ($itemsBySeller as $sellerId => $items) {
            $subtotal = $items->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            $order = Order::create([
                'buyer_id' => Auth::id(),
                'seller_id' => $sellerId,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'subtotal' => $subtotal,
                'tax' => 0,
                'shipping_cost' => 0,
                'total_amount' => $subtotal,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
                'order_type' => 'farmer',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                    'total' => $item->product->price * $item->quantity,
                ]);

                // Reduce product stock
                $item->product->reduceStock($item->quantity);
            }
        }

        // Clear cart
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('farmer.my-orders')
                         ->with('success', 'Order placed successfully!');
    }
}