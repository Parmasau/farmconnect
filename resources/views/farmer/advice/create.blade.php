@extends('layouts.dashboard')

@section('title', 'Ask for Advice - FarmConnect')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('farmer.advice.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-2xl font-bold">Ask for Advice</h1>
        </div>

        <form method="POST" action="{{ route('farmer.advice.store') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Agrovet (Optional)</label>
                <select name="agrovet_id" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <option value="">Any Agrovet</option>
                    @foreach($agrovets as $agrovet)
                        <option value="{{ $agrovet->id }}" {{ old('agrovet_id') == $agrovet->id ? 'selected' : '' }}>
                            {{ $agrovet->name }} - {{ $agrovet->business_name ?? 'Agrovet' }}
                        </option>
                    @endforeach
                </select>
                @error('agrovet_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                <input type="text" name="subject" value="{{ old('subject') }}" 
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                       placeholder="What is your question about?" required>
                @error('subject')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Your Message *</label>
                <textarea name="message" rows="6" 
                          class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                          placeholder="Describe your farming issue in detail..." 
                          required>{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 font-semibold">
                    <i class="fas fa-paper-plane mr-2"></i> Submit Request
                </button>
                <a href="{{ route('farmer.advice.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg text-center hover:bg-gray-400 font-semibold">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection