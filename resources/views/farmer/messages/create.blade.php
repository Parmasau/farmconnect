@extends('layouts.dashboard')

@section('title', 'Send Message - FarmConnect')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ url()->previous() }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-2xl font-bold">Send Message</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(isset($receiver))
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-lg">To: {{ $receiver->name }}</p>
                        <p class="text-sm text-gray-500">{{ $receiver->email }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(isset($product))
            <div class="bg-blue-50 rounded-lg p-4 mb-6">
                <div class="flex items-center gap-3">
                    <img src="{{ $product->image_url }}" class="w-16 h-16 object-cover rounded" alt="{{ $product->name }}">
                    <div>
                        <p class="font-semibold">Regarding: {{ $product->name }}</p>
                        <p class="text-sm text-gray-600">Price: KSh {{ number_format($product->price, 2) }}</p>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('farmer.messages.send', $receiver->id ?? '') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Your Message</label>
                <textarea name="message" rows="6" 
                          class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                          placeholder="Write your message here..." 
                          required>{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 font-semibold">
                    <i class="fas fa-paper-plane mr-2"></i> Send Message
                </button>
                <a href="{{ url()->previous() }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg text-center hover:bg-gray-400 font-semibold">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
