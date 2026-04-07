@extends('layouts.auth')
@section('title', 'Register')
@section('content')
<div class="w-full max-w-md bg-white p-8 rounded-xl shadow">
    <h2 class="text-2xl font-bold text-green-700 mb-2">Create Account</h2>
    <p class="text-gray-500 text-sm mb-6">Join FarmConnect as an Admin, Farmer, or Agrovet.</p>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">I am a</label>
            <select name="role" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="farmer" @selected(old('role') === 'farmer')>🌾 Farmer — I sell farm produce</option>
                <option value="agrovet" @selected(old('role') === 'agrovet')>🏪 Agrovet — I sell farm inputs</option>
                <option value="admin" @selected(old('role') === 'admin')>🛡️ Admin — I manage the platform</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Phone (optional)</label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required
                class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <button type="submit" class="w-full bg-green-700 text-white py-2 rounded-lg hover:bg-green-800 font-semibold">Create Account</button>
    </form>
    <p class="mt-4 text-center text-sm text-gray-600">
        Already have an account? <a href="{{ route('login') }}" class="text-green-700 font-semibold hover:underline">Login</a>
    </p>
</div>
@endsection
