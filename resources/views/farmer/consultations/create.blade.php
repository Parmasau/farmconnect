@extends('layouts.dashboard')
@section('title', 'Book Consultation')
@section('sidebar') @include('farmer.dashboard') @endsection
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('farmer.consultations.index') }}" class="text-green-700 text-sm hover:underline">← Back</a>
    <div class="bg-white rounded-xl shadow p-6 mt-4">
        <h2 class="text-lg font-semibold mb-4">Book a Consultation</h2>
        <form method="POST" action="{{ route('farmer.consultations.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Agrovet</label>
                <select name="agrovet_id" required class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <option value="">— Select Agrovet —</option>
                    @foreach($agrovets as $av)
                        <option value="{{ $av->id }}" @selected(old('agrovet_id') == $av->id)>{{ $av->name }} {{ $av->location ? "({$av->location})" : '' }}</option>
                    @endforeach
                </select>
                @error('agrovet_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Topic</label>
                <input type="text" name="topic" value="{{ old('topic') }}" required class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('description') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Date & Time (optional)</label>
                <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>
            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded-lg hover:bg-green-800 font-semibold">Book Consultation</button>
        </form>
    </div>
</div>
@endsection
