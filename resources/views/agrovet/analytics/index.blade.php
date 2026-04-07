{{-- resources/views/agrovet/analytics/index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Analytics - Agrovet')

@section('sidebar')
    @include('agrovet.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold">Analytics Dashboard</h1>
    
    <!-- Order Statistics -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Order Statistics</h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $totalOrders ?? 0 }}</div>
                <div class="text-sm text-gray-600">Total Orders</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-yellow-600">{{ $pendingOrders ?? 0 }}</div>
                <div class="text-sm text-gray-600">Pending</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $processingOrders ?? 0 }}</div>
                <div class="text-sm text-gray-600">Processing</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $completedOrders ?? 0 }}</div>
                <div class="text-sm text-gray-600">Completed</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-700">KSh {{ number_format($totalRevenue ?? 0, 0) }}</div>
                <div class="text-sm text-gray-600">Revenue</div>
            </div>
        </div>
    </div>
    
    <!-- Product Statistics -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Product Statistics</h2>
        <div class="grid grid-cols-3 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $totalProducts ?? 0 }}</div>
                <div class="text-sm text-gray-600">Total Products</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-yellow-600">{{ $lowStockProducts ?? 0 }}</div>
                <div class="text-sm text-gray-600">Low Stock</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-red-600">{{ $outOfStockProducts ?? 0 }}</div>
                <div class="text-sm text-gray-600">Out of Stock</div>
            </div>
        </div>
    </div>
    
    <!-- Consultation & Advice Statistics -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Consultations</h2>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span>Total:</span>
                    <span class="font-bold">{{ $totalConsultations ?? 0 }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Pending:</span>
                    <span class="font-bold text-yellow-600">{{ $pendingConsultations ?? 0 }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Completed:</span>
                    <span class="font-bold text-green-600">{{ $completedConsultations ?? 0 }}</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Advice Requests</h2>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span>Total:</span>
                    <span class="font-bold">{{ $totalAdvice ?? 0 }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Pending:</span>
                    <span class="font-bold text-yellow-600">{{ $pendingAdvice ?? 0 }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Answered:</span>
                    <span class="font-bold text-green-600">{{ $answeredAdvice ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Top Selling Products -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Top Selling Products</h2>
        @if(isset($topProducts) && $topProducts->count() > 0)
            <div class="space-y-2">
                @foreach($topProducts as $product)
                    <div class="flex justify-between items-center py-2 border-b">
                        <span>{{ $product->name }}</span>
                        <span class="font-semibold text-green-600">{{ $product->total_sold ?? 0 }} sold</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center">No sales data yet</p>
        @endif
    </div>
</div>
@endsection