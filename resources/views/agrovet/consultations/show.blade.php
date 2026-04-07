@extends('layouts.dashboard')
@section('title', $consultation->topic)
@section('sidebar') @include('agrovet.dashboard') @endsection
@section('content')
<a href="{{ route('agrovet.consultations.index') }}" class="text-green-700 text-sm hover:underline">← Back</a>
<div class="bg-white rounded-xl shadow p-6 mt-4 max-w-2xl">
    <div class="flex justify-between items-start mb-4">
        <h2 class="text-lg font-bold">{{ $consultation->topic }}</h2>
        <span class="px-2 py-0.5 rounded-full text-xs capitalize bg-blue-100 text-blue-700">{{ $consultation->status }}</span>
    </div>
    <div class="grid grid-cols-2 gap-4 text-sm mb-4">
        <div><p class="text-xs text-gray-500">Farmer</p><p class="font-medium">{{ $consultation->farmer->name }}</p><p class="text-gray-500">{{ $consultation->farmer->phone }}</p></div>
        <div><p class="text-xs text-gray-500">Scheduled</p><p class="font-medium">{{ $consultation->scheduled_at?->format('d M Y, H:i') ?? 'Not set' }}</p></div>
    </div>
    @if($consultation->description)
    <div class="bg-gray-50 rounded-lg p-4 text-sm">{{ $consultation->description }}</div>
    @endif
</div>
@endsection
