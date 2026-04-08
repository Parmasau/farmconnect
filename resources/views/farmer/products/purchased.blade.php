@extends('layouts.dashboard')

@section('title', 'Purchased Products')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Purchased Products</h1>
    
    @if(auth()->check())
        <div class="bg-green-100 p-4 rounded mb-4">
            <p>✅ You are logged in as: {{ auth()->user()->name }} (ID: {{ auth()->id() }})</p>
        </div>
        
        @if(isset($purchasedProducts) && $purchasedProducts->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left">Order #</th>
                            <th class="px-4 py-3 text-left">Total</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchasedProducts as $order)
                        <tr>
                            <td class="px-4 py-3">{{ $order->order_number }}</td>
                            <td class="px-4 py-3">KSh {{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-3">{{ $order->status }}</td>
                            <td class="px-4 py-3">{{ $order->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $purchasedProducts->links() }}</div>
        @else
            <div class="bg-yellow-100 p-4 rounded">
                <p>⚠️ No orders found for user ID: {{ auth()->id() }}</p>
                <p class="text-sm mt-2">Try creating an order using tinker:</p>
                <pre class="bg-gray-800 text-white p-2 rounded text-xs mt-2">
App\Models\Order::create([
    'buyer_id' => {{ auth()->id() }},
    'seller_id' => 2,
    'order_number' => 'ORD-' . strtoupper(uniqid()),
    'total_amount' => 1000,
    'status' => 'pending',
    'payment_status' => 'unpaid',
]);
                </pre>
            </div>
        @endif
    @else
        <div class="bg-red-100 p-4 rounded">
            <p>❌ You are NOT logged in!</p>
            <p>Please <a href="{{ route('login') }}" class="text-blue-600 underline">login</a> first.</p>
        </div>
    @endif
</div>
@endsection
