{{-- resources/views/cart/index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'My Cart - FarmNest')

@section('sidebar')
    @auth
        @if(auth()->user()->isFarmer())
            @include('farmer.sidebar')
        @elseif(auth()->user()->isAgrovet())
            @include('agrovet.sidebar')
        @else
            @include('admin.sidebar')
        @endif
    @endauth
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Shopping Cart</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($cartItems->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">Product</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Price</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Quantity</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Total</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($cartItems as $item)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $item->product->image_url }}" class="w-12 h-12 object-cover rounded">
                                <div>
                                    <p class="font-medium">{{ $item->product->name }}</p>
                                    <p class="text-xs text-gray-500">by {{ $item->product->farmer->name ?? $item->product->seller->name ?? 'Seller' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">KSh {{ number_format($item->product->price, 2) }}</td>
                        <td class="px-4 py-3">
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                       min="1" max="{{ $item->product->quantity }}"
                                       class="w-20 border rounded-lg px-2 py-1 text-center">
                                <button type="submit" class="text-blue-600 hover:underline text-sm">Update</button>
                            </form>
                        </td>
                        <td class="px-4 py-3 font-semibold">KSh {{ number_format($item->product->price * $item->quantity, 2) }}</td>
                        <td class="px-4 py-3">
                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right font-bold">Total:</td>
                        <td class="px-4 py-3 font-bold text-green-700">KSh {{ number_format($total, 2) }}</td>
                        <td class="px-4 py-3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="flex justify-between items-center mt-6">
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700" onclick="return confirm('Clear entire cart?')">
                    Clear Cart
                </button>
            </form>
            <a href="{{ route('cart.checkout') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Proceed to Checkout
            </a>
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">🛒</div>
            <h3 class="text-lg font-medium mb-2">Your Cart is Empty</h3>
            <p class="text-gray-500 mb-4">Start shopping to add items to your cart.</p>
            <a href="{{ route('farmer.products.marketplace') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                Browse Products
            </a>
        </div>
    @endif
</div>
@endsection