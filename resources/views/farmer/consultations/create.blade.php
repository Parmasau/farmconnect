@extends('layouts.dashboard')

@section('title', 'Request Consultation - FarmConnect')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('farmer.consultations.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-2xl font-bold">Request Consultation</h1>
        </div>

        <form method="POST" action="{{ route('farmer.consultations.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Agrovet *</label>
                <select name="agrovet_id" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
                    <option value="">Select an agrovet...</option>
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Topic *</label>
                <input type="text" name="topic" value="{{ old('topic') }}" 
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                       placeholder="What do you need help with?" required>
                @error('topic')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea name="description" rows="6" 
                          class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                          placeholder="Describe your issue in detail..." 
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Consultation Type *</label>
                <select name="type" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
                    <option value="chat" {{ old('type') == 'chat' ? 'selected' : '' }}>💬 Chat</option>
                    <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>📹 Video Call</option>
                    <option value="phone" {{ old('type') == 'phone' ? 'selected' : '' }}>📞 Phone Call</option>
                    <option value="in_person" {{ old('type') == 'in_person' ? 'selected' : '' }}>🏢 In Person</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Date (Optional)</label>
                <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}" 
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
                @error('scheduled_at')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 font-semibold">
                    <i class="fas fa-paper-plane mr-2"></i> Request Consultation
                </button>
                <a href="{{ route('farmer.consultations.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg text-center hover:bg-gray-400 font-semibold">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
