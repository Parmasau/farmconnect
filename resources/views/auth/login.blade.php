@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl p-8">
        <div class="text-center mb-8">
            <div class="text-4xl mb-2">🌱</div>
            <h1 class="text-2xl font-bold text-green-700">Create Account</h1>
            <p class="text-gray-500 mt-2">Join FarmConnect today</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('name') border-red-500 @enderror" 
                    required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('email') border-red-500 @enderror" 
                    required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Role</label>
                <select name="role" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="farmer">Farmer</option>
                    <option value="agrovet">Agrovet</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                <input type="password" name="password" 
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('password') border-red-500 @enderror" 
                    required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" 
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" 
                    required>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                Register
            </button>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:underline">Login</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection