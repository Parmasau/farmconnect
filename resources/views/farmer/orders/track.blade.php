@extends('layouts.dashboard')
@section('title', 'Track Order')
@section('sidebar') @include('farmer.dashboard') @endsection
@section('content')
<a href="{{ route('farmer.orders.show', $order) }}" class="text-green-700 text-sm hover:underline">← Back</a>
<div class="bg-white rounded-xl shadow p-6 mt-4 max-w-lg">
    <h2 class="text-lg font-bold mb-4">Tracking: {{ $order->order_number }}</h2>
    @php $steps = ['pending','confirmed','processing','shipped','delivered']; $current = array_search($order->status, $steps); @endphp
    <div class="space-y-3">
        @foreach($steps as $i => $step)
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                {{ $i <= $current ? 'bg-green-700 text-white' : 'bg-gray-200 text-gray-400' }}">
                {{ $i < $current ? '✓' : ($i === $current ? '●' : $i+1) }}
            </div>
            <span class="capitalize {{ $i <= $current ? 'text-green-700 font-semibold' : 'text-gray-400' }}">{{ $step }}</span>
        </div>
        @if(!$loop->last)<div class="ml-4 w-0.5 h-4 {{ $i < $current ? 'bg-green-700' : 'bg-gray-200' }}"></div>@endif
        @endforeach
    </div>
</div>
@endsection
