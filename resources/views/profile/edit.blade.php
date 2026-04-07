@extends('layouts.dashboard')

@section('title', 'My Profile')

@section('sidebar')
    @if(auth()->user()->isAdmin())
        @include('admin.sidebar')
    @elseif(auth()->user()->isFarmer())
        @include('farmer.sidebar')
    @elseif(auth()->user()->isAgrovet())
        @include('agrovet.sidebar')
    @endif
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">My Profile</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Profile Info Card -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2">Profile Information</h2>
                
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    @if(auth()->user()->isAgrovet() || auth()->user()->isAdmin())
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Business Name</label>
                        <input type="text" name="business_name" value="{{ old('business_name', $user->business_name) }}" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
                        @error('business_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    @endif
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea name="address" rows="2" 
                                  class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('address', $user->address) }}</textarea>
                        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bio / About</label>
                        <textarea name="bio" rows="3" 
                                  class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-800 transition">
                        Update Profile
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Password Change Card -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2">Change Password</h2>
                
                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                        <input type="password" name="current_password" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
                        @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input type="password" name="password" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" 
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Change Password
                    </button>
                </form>
            </div>
            
            <!-- Logout Button -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2">Account Actions</h2>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition mb-3">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
                
                <button type="button" onclick="showDeleteModal()" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                    <i class="fas fa-trash-alt mr-2"></i> Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Delete Account</h3>
            <p class="text-gray-600 mb-4">Are you sure you want to delete your account? This action cannot be undone.</p>
            
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Enter your password to confirm</label>
                    <input type="password" name="password" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:outline-none" required>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="hideDeleteModal()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }
    
    function hideDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }
</script>
@endsection