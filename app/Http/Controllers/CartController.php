<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::with('product.owner')->where('user_id', Auth::id())->get();
        $total = $items->sum(fn($i) => $i->quantity * $i->product->price);
        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = Cart::firstOrNew(['user_id' => Auth::id(), 'product_id' => $product->id]);
        $cart->quantity = ($cart->quantity ?? 0) + $request->quantity;
        $cart->save();

        return back()->with('success', 'Added to cart.');
    }

    public function update(Request $request, Cart $cart)
    {
        $this->authorize('update', $cart);
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Cart updated.');
    }

    public function remove(Cart $cart)
    {
        $this->authorize('delete', $cart);
        $cart->delete();
        return back()->with('success', 'Item removed.');
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Cart cleared.');
    }

    public function checkout()
    {
        $items = Cart::with('product.owner')->where('user_id', Auth::id())->get();
        if ($items->isEmpty()) return redirect()->route('cart.index')->with('error', 'Cart is empty.');
        $total = $items->sum(fn($i) => $i->quantity * $i->product->price);
        return view('cart.checkout', compact('items', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate(['delivery_address' => 'required|string']);

        $items = Cart::with('product')->where('user_id', Auth::id())->get();
        if ($items->isEmpty()) return redirect()->route('cart.index');

        DB::transaction(function () use ($items, $request) {
            // Group by seller
            $bySeller = $items->groupBy(fn($i) => $i->product->farmer_id);

            foreach ($bySeller as $sellerId => $sellerItems) {
                $total = $sellerItems->sum(fn($i) => $i->quantity * $i->product->price);

                $order = Order::create([
                    'buyer_id'         => Auth::id(),
                    'seller_id'        => $sellerId,
                    'total_amount'     => $total,
                    'payment_status'   => 'paid',
                    'delivery_address' => $request->delivery_address,
                    'notes'            => $request->notes,
                ]);

                foreach ($sellerItems as $item) {
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $item->product_id,
                        'quantity'   => $item->quantity,
                        'unit_price' => $item->product->price,
                        'subtotal'   => $item->quantity * $item->product->price,
                    ]);
                    $item->product->decrement('quantity', $item->quantity);
                }
            }

            Cart::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('farmer.orders.index')->with('success', 'Order placed successfully!');
    }
}
