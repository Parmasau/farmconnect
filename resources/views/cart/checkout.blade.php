{{-- resources/views/cart/checkout.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Checkout - FarmNest')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
        <h1 class="text-2xl font-bold mb-6">Checkout</h1>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Order Summary -->
            <div>
                <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
                <div class="space-y-3">
                    @foreach($cartItems as $item)
                    <div class="flex justify-between items-center py-2 border-b">
                        <div>
                            <p class="font-medium">{{ $item->product->name }}</p>
                            <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                        </div>
                        <p class="font-semibold">KSh {{ number_format($item->product->price * $item->quantity, 2) }}</p>
                    </div>
                    @endforeach
                    <div class="flex justify-between items-center pt-3 font-bold">
                        <p>Total:</p>
                        <p class="text-green-700 text-xl">KSh {{ number_format($total, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div>
                <h2 class="text-lg font-semibold mb-4">Shipping & Payment</h2>
                <form method="POST" action="{{ route('cart.process') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Address *</label>
                        <textarea name="shipping_address" rows="3" 
                                  class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500"
                                  required>{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method *</label>
                        <select name="payment_method" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500" required>
                            <option value="">Select payment method</option>
                            <option value="mpesa">M-Pesa</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="cash_on_delivery">Cash on Delivery</option>
                        </select>
                        @error('payment_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-yellow-50 rounded-lg p-4 mb-4">
                        <p class="text-sm text-yellow-800">
                            <i class="fas fa-info-circle"></i> 
                            By placing this order, you agree to our terms and conditions.
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                            Place Order
                        </button>
                        <a href="{{ route('cart.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg text-center hover:bg-gray-400">
                            Back to Cart
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection