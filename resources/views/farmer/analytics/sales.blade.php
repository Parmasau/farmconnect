@extends('layouts.dashboard')

@section('title', 'Sales Report - FarmConnect')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Sales Report</h1>
        <div class="flex gap-2">
            <a href="{{ route('farmer.analytics.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Back to Analytics
            </a>
        </div>
    </div>

    @if(isset($sales) && $sales->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">Order #</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Buyer</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Amount</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($sales as $sale)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $sale->order_number }}</td>
                        <td class="px-4 py-3">{{ $sale->buyer->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 font-semibold">KSh {{ number_format($sale->total_amount, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $sale->status === 'completed' ? 'bg-green-100 text-green-700' : 
                                   ($sale->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $sale->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $sales->links() }}</div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📊</div>
            <h3 class="text-lg font-medium mb-2">No Sales Data</h3>
            <p class="text-gray-500">You haven't made any sales yet.</p>
        </div>
    @endif
</div>
@endsection
