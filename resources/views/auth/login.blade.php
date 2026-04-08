<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FarmConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        .bg-farm {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                url('https://images.pexels.com/photos/164504/agriculture-field-soil-nature-164504.jpeg?auto=compress&cs=tinysrgb&w=1920&h=1080&fit=crop');
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
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transition: transform 0.3s ease;
        }
        
        .login-card:hover {
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
        
        .btn-login {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #15803d 0%, #166534 100%);
            transform: scale(1.02);
        }
    </style>
</head>
<body class="bg-farm min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="login-card p-8">
            <div class="text-center mb-8">
                <div class="text-6xl mb-3 animate-bounce">🌾</div>
                <h1 class="text-3xl font-bold text-green-700" style="font-family: 'Playfair Display', serif;">FarmConnect</h1>
                <p class="text-gray-500 mt-2">Welcome back! Login to your account</p>
            </div>

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    @foreach($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="input-field w-full pl-10 pr-4 py-2 rounded-lg focus:outline-none" 
                            placeholder="Enter your email"
                            required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                        <input type="password" name="password" 
                            class="input-field w-full pl-10 pr-4 py-2 rounded-lg focus:outline-none" 
                            placeholder="Enter your password"
                            required>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:underline">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login w-full text-white py-2 rounded-lg font-semibold transition">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </button>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-green-600 font-semibold hover:underline">Register</a>
                    </p>
                </div>
            </form>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-white text-sm opacity-75">
                <i class="fas fa-seedling mr-1"></i> Connecting Farmers & Agrovets across Kenya
            </p>
        </div>
    </div>
</body>
</html>
