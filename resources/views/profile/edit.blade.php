{{-- resources/views/profile/edit.blade.php --}}
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
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">My Profile</h1>
            <p class="text-gray-500 text-sm mt-1">Manage your account information and preferences</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('cart.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                <i class="fas fa-shopping-cart"></i>
                <span>Cart</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Profile Info Card -->
        <div class="md:col-span-2">
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-800">Profile Information</h2>
                    <p class="text-sm text-gray-500">Update your personal information</p>
                </div>
                
                <div class="p-6">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        
                        <!-- Name -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                       class="w-full border rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                                       placeholder="Enter your full name" required>
                            </div>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                       class="w-full border rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                                       placeholder="Enter your email" required>
                            </div>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Conditional Fields: For Farmers (Phone & M-Pesa) vs Agrovets (Till Number) -->
                        @if(auth()->user()->isFarmer())
                            <!-- Phone Number for Farmers -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <div class="relative">
                                    <i class="fas fa-phone absolute left-3 top-3 text-gray-400"></i>
                                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" 
                                           class="w-full border rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                                           placeholder="0712345678">
                                </div>
                                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <!-- M-Pesa Number for Farmers -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">M-Pesa Number</label>
                                <div class="relative">
                                    <i class="fab fa-cc-mpesa absolute left-3 top-3 text-green-600"></i>
                                    <input type="tel" name="mpesa_number" value="{{ old('mpesa_number', $user->mpesa_number) }}" 
                                           class="w-full border rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                                           placeholder="0712345678">
                                    <button type="button" onclick="verifyMpesaNumber()" 
                                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-blue-700 transition">
                                        Verify
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">This will be used for M-Pesa payments when buying products</p>
                                <div id="mpesaVerificationMessage" class="text-xs mt-1 hidden"></div>
                                @error('mpesa_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif
                        
                        @if(auth()->user()->isAgrovet())
                            <!-- Till Number for Agrovets -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Till Number (Paybill/Business Number)</label>
                                <div class="relative">
                                    <i class="fas fa-store absolute left-3 top-3 text-purple-600"></i>
                                    <input type="text" name="till_number" value="{{ old('till_number', $user->till_number) }}" 
                                           class="w-full border rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                                           placeholder="e.g., 123456">
                                    <button type="button" onclick="verifyTillNumber()" 
                                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-blue-700 transition">
                                        Verify
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">This will be used to receive payments from farmers</p>
                                <div id="tillVerificationMessage" class="text-xs mt-1 hidden"></div>
                                @error('till_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif
                        
                        <!-- Business Name (for Agrovets & Admins) -->
                        @if(auth()->user()->isAgrovet() || auth()->user()->isAdmin())
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Business Name</label>
                            <div class="relative">
                                <i class="fas fa-building absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" name="business_name" value="{{ old('business_name', $user->business_name) }}" 
                                       class="w-full border rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                                       placeholder="Your business name">
                            </div>
                            @error('business_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        @endif
                        
                        <!-- Address (Common for all) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <div class="relative">
                                <i class="fas fa-map-marker-alt absolute left-3 top-3 text-gray-400"></i>
                                <textarea name="address" rows="2" 
                                          class="w-full border rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none"
                                          placeholder="Your address">{{ old('address', $user->address) }}</textarea>
                            </div>
                            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Bio (Common for all) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bio / About</label>
                            <div class="relative">
                                <i class="fas fa-info-circle absolute left-3 top-3 text-gray-400"></i>
                                <textarea name="bio" rows="3" 
                                          class="w-full border rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none"
                                          placeholder="Tell us about yourself">{{ old('bio', $user->bio) }}</textarea>
                            </div>
                            @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Update Button -->
                        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>
                            <span>Update Profile</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Right Side Cards -->
        <div class="md:col-span-1">
            <!-- Password Change Card -->
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden mb-6">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-800">Change Password</h2>
                    <p class="text-sm text-gray-500">Secure your account</p>
                </div>
                
                <div class="p-6">
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                                <input type="password" name="current_password" 
                                       class="w-full border rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                                       required>
                            </div>
                            @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <div class="relative">
                                <i class="fas fa-key absolute left-3 top-3 text-gray-400"></i>
                                <input type="password" name="password" 
                                       class="w-full border rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                                       required>
                            </div>
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                            <div class="relative">
                                <i class="fas fa-check-circle absolute left-3 top-3 text-gray-400"></i>
                                <input type="password" name="password_confirmation" 
                                       class="w-full border rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" 
                                       required>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition flex items-center justify-center gap-2">
                            <i class="fas fa-key"></i>
                            <span>Change Password</span>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Payment Info Card (Dynamic based on role) -->
            @if(auth()->user()->isFarmer())
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden mb-6">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-800">M-Pesa Information</h2>
                    <p class="text-sm text-gray-500">Payment method details</p>
                </div>
                
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fab fa-cc-mpesa text-green-600 text-2xl"></i>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">Your registered M-Pesa number</p>
                    <p class="font-bold text-xl text-green-700">
                        {{ $user->mpesa_number ? substr($user->mpesa_number, 0, 4) . '****' . substr($user->mpesa_number, -4) : 'Not set' }}
                    </p>
                    <p class="text-xs text-gray-500 mt-3">Used for secure payments when buying products</p>
                </div>
            </div>
            @endif
            
            @if(auth()->user()->isAgrovet())
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden mb-6">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-800">Payment Information</h2>
                    <p class="text-sm text-gray-500">Business payment details</p>
                </div>
                
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-store text-purple-600 text-2xl"></i>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">Your Till / Paybill Number</p>
                    <p class="font-bold text-xl text-purple-700">
                        {{ $user->till_number ?: 'Not set' }}
                    </p>
                    <p class="text-xs text-gray-500 mt-3">Farmers will pay to this number when buying from you</p>
                </div>
            </div>
            @endif
            
            <!-- Account Actions Card -->
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-800">Account Actions</h2>
                    <p class="text-sm text-gray-500">Manage your account</p>
                </div>
                
                <div class="p-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition mb-3 flex items-center justify-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                    
                    <button type="button" onclick="showDeleteModal()" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-2">
                        <i class="fas fa-trash-alt"></i>
                        <span>Delete Account</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="text-center mb-4">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Delete Account</h3>
                <p class="text-gray-600 text-sm mt-1">This action cannot be undone</p>
            </div>
            
            <p class="text-gray-600 mb-4 text-center">Are you sure you want to delete your account? All your data will be permanently removed.</p>
            
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Enter your password to confirm</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                        <input type="password" name="password" class="w-full border rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-red-500 focus:outline-none" required>
                    </div>
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
    
    @if(auth()->user()->isFarmer())
    function verifyMpesaNumber() {
        const mpesaInput = document.querySelector('input[name="mpesa_number"]');
        const mpesaNumber = mpesaInput.value;
        const verificationMsg = document.getElementById('mpesaVerificationMessage');
        
        if (!mpesaNumber) {
            verificationMsg.textContent = 'Please enter your M-Pesa number';
            verificationMsg.className = 'text-xs mt-1 text-red-600';
            verificationMsg.classList.remove('hidden');
            return;
        }
        
        const cleanNumber = mpesaNumber.replace(/[^0-9]/g, '');
        let isValid = false;
        
        if (cleanNumber.length === 10 && cleanNumber.startsWith('07')) {
            isValid = true;
        } else if (cleanNumber.length === 12 && cleanNumber.startsWith('2547')) {
            isValid = true;
        } else if (cleanNumber.length === 9 && cleanNumber.startsWith('7')) {
            isValid = true;
            mpesaInput.value = '0' + cleanNumber;
        }
        
        if (isValid) {
            verificationMsg.textContent = '✓ M-Pesa number verified successfully!';
            verificationMsg.className = 'text-xs mt-1 text-green-600';
            verificationMsg.classList.remove('hidden');
        } else {
            verificationMsg.textContent = 'Invalid M-Pesa number. Please enter a valid Safaricom number (e.g., 0712345678)';
            verificationMsg.className = 'text-xs mt-1 text-red-600';
            verificationMsg.classList.remove('hidden');
        }
        
        setTimeout(() => {
            verificationMsg.classList.add('hidden');
        }, 5000);
    }
    @endif
    
    @if(auth()->user()->isAgrovet())
    function verifyTillNumber() {
        const tillInput = document.querySelector('input[name="till_number"]');
        const tillNumber = tillInput.value;
        const verificationMsg = document.getElementById('tillVerificationMessage');
        
        if (!tillNumber) {
            verificationMsg.textContent = 'Please enter your Till/Paybill number';
            verificationMsg.className = 'text-xs mt-1 text-red-600';
            verificationMsg.classList.remove('hidden');
            return;
        }
        
        const cleanNumber = tillNumber.replace(/[^0-9]/g, '');
        
        if (cleanNumber.length >= 5 && cleanNumber.length <= 7) {
            verificationMsg.textContent = '✓ Till/Paybill number verified successfully!';
            verificationMsg.className = 'text-xs mt-1 text-green-600';
            verificationMsg.classList.remove('hidden');
        } else {
            verificationMsg.textContent = 'Invalid Till/Paybill number. Please enter a valid number (5-7 digits)';
            verificationMsg.className = 'text-xs mt-1 text-red-600';
            verificationMsg.classList.remove('hidden');
        }
        
        setTimeout(() => {
            verificationMsg.classList.add('hidden');
        }, 5000);
    }
    @endif
</script>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection