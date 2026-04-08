<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FarmConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        .bg-farm {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                url('https://images.pexels.com/photos/80709/pexels-photo-80709.jpeg?auto=compress&cs=tinysrgb&w=1920&h=1080&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }
        
        .bg-farm::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.6) 100%);
            z-index: 0;
        }
        
        .bg-farm > * {
            position: relative;
            z-index: 1;
        }
        
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transition: transform 0.3s ease;
        }
        
        .register-card:hover {
            transform: translateY(-5px);
        }
        
        .input-field {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }
        
        .input-field:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
        }
        
        .btn-register {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            transition: all 0.3s ease;
        }
        
        .btn-register:hover {
            background: linear-gradient(135deg, #15803d 0%, #166534 100%);
            transform: scale(1.02);
        }
        
        /* Hide admin role by default - only show for first user or via special access */
        .admin-role-hidden {
            display: none;
        }
        
        /* Show admin role when special key is pressed or checkbox is checked */
        .show-admin:checked ~ .admin-role-hidden {
            display: block;
        }
    </style>
</head>
<body class="bg-farm min-h-screen flex items-center justify-center py-8">
    <div class="max-w-md w-full mx-4">
        <div class="register-card p-8">
            <div class="text-center mb-6">
                <div class="text-6xl mb-3 animate-pulse">🌱</div>
                <h1 class="text-3xl font-bold text-green-700" style="font-family: 'Playfair Display', serif;">Create Account</h1>
                <p class="text-gray-500 mt-2">Join FarmConnect today</p>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    @foreach($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Full Name *</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" name="name" value="{{ old('name') }}" 
                            class="input-field w-full pl-10 pr-4 py-2 rounded-lg focus:outline-none" 
                            placeholder="Enter your full name"
                            required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Email *</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="input-field w-full pl-10 pr-4 py-2 rounded-lg focus:outline-none" 
                            placeholder="Enter your email"
                            required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Phone Number</label>
                    <div class="relative">
                        <i class="fas fa-phone absolute left-3 top-3 text-gray-400"></i>
                        <input type="tel" name="phone" value="{{ old('phone') }}" 
                            class="input-field w-full pl-10 pr-4 py-2 rounded-lg focus:outline-none" 
                            placeholder="Enter your phone number">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Role *</label>
                    <div class="relative">
                        <i class="fas fa-users absolute left-3 top-3 text-gray-400"></i>
                        <select name="role" class="input-field w-full pl-10 pr-4 py-2 rounded-lg focus:outline-none" required>
                            <option value="farmer" {{ old('role') == 'farmer' ? 'selected' : '' }}>🌾 Farmer</option>
                            <option value="agrovet" {{ old('role') == 'agrovet' ? 'selected' : '' }}>🔬 Agrovet</option>
                            @if(app()->environment('local') || (isset($allowAdmin) && $allowAdmin))
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>👑 Admin</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Password *</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                        <input type="password" name="password" 
                            class="input-field w-full pl-10 pr-4 py-2 rounded-lg focus:outline-none" 
                            placeholder="Create a password"
                            required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-1">Confirm Password *</label>
                    <div class="relative">
                        <i class="fas fa-check-circle absolute left-3 top-3 text-gray-400"></i>
                        <input type="password" name="password_confirmation" 
                            class="input-field w-full pl-10 pr-4 py-2 rounded-lg focus:outline-none" 
                            placeholder="Confirm your password"
                            required>
                    </div>
                </div>

                <button type="submit" class="btn-register w-full text-white py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-user-plus mr-2"></i> Register
                </button>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:underline">Login</a>
                    </p>
                </div>
            </form>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-white text-sm opacity-75">
                <i class="fas fa-handshake mr-1"></i> Join thousands of farmers and agrovets
            </p>
        </div>
    </div>
</body>
</html>
