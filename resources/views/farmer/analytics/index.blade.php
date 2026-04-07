@extends('layouts.dashboard')

@section('title', 'Analytics - FarmConnect')

@section('sidebar')
    @include('farmer.dashboard')
@endsection

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold">Analytics Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="text-3xl mb-2">📦</div>
            <div class="text-2xl font-bold text-green-700">{{ $totalProducts ?? 0 }}</div>
            <div class="text-sm text-gray-500">Total Products</div>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <div class="text-3xl mb-2">🛒</div>
            <div class="text-2xl font-bold text-green-700">{{ $totalOrders ?? 0 }}</div>
            <div class="text-sm text-gray-500">Total Orders</div>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <div class="text-3xl mb-2">💰</div>
            <div class="text-2xl font-bold text-green-700">KSh {{ number_format($totalRevenue ?? 0, 2) }}</div>
            <div class="text-sm text-gray-500">Total Revenue</div>
        </div>
    </div>
    
    <!-- Monthly Sales Chart -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Monthly Sales</h2>
        @if(isset($monthlySales) && $monthlySales->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Month</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Year</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Total Sales</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($monthlySales as $sale)
                        <tr>
                            <td class="px-4 py-2 text-sm">
                                @php
                                    $monthName = DateTime::createFromFormat('!m', $sale->month)->format('F');
                                @endphp
                                {{ $monthName }}
                            </td>
                            <td class="px-4 py-2 text-sm">{{ $sale->year }}</td>
                            <td class="px-4 py-2 text-sm text-right font-semibold">
                                KSh {{ number_format($sale->total, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No sales data available yet.</p>
        @endif
    </div>
    
    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('farmer.analytics.sales') }}" class="bg-green-50 rounded-xl shadow p-6 hover:bg-green-100 transition">
            <div class="text-2xl mb-2">📊</div>
            <h3 class="font-semibold">Sales Report</h3>
            <p class="text-sm text-gray-600">View detailed sales report</p>
        </a>
        <a href="{{ route('farmer.analytics.products') }}" class="bg-green-50 rounded-xl shadow p-6 hover:bg-green-100 transition">
            <div class="text-2xl mb-2">📈</div>
            <h3 class="font-semibold">Product Performance</h3>
            <p class="text-sm text-gray-600">See which products are selling best</p>
        </a>
    </div>
</div>
@endsection
