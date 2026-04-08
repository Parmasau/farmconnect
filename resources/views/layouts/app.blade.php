<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmConnect - @yield('title', 'Connecting Farmers & Agrovets')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-farm {
            background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2070&auto=format');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }
        .bg-farm::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 0;
        }
        .bg-farm > * {
            position: relative;
            z-index: 1;
        }
        .navbar-bg {
            background: linear-gradient(135deg, rgba(22, 101, 52, 0.95), rgba(21, 128, 61, 0.95));
            backdrop-filter: blur(10px);
        }
        .card-bg {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
        }
        .footer-bg {
            background: rgba(20, 83, 45, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-farm min-h-screen flex flex-col">

<nav class="navbar-bg text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <a href="{{ route('landing') }}" class="font-bold text-xl flex items-center gap-2">🌱 FarmConnect</a>
        <div class="flex items-center gap-4 text-sm">
            <a href="{{ route('marketplace.index') }}" class="hover:text-green-200">Marketplace</a>
            @auth
                @php $user = auth()->user(); @endphp
                @if($user->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-green-200">Admin Dashboard</a>
                @elseif($user->isFarmer())
                    <a href="{{ route('farmer.dashboard') }}" class="hover:text-green-200">Dashboard</a>
                @elseif($user->isAgrovet())
                    <a href="{{ route('agrovet.dashboard') }}" class="hover:text-green-200">Dashboard</a>
                @endif
                <span class="text-green-300">{{ $user->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="bg-white text-green-700 px-3 py-1 rounded text-xs font-semibold">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-green-200">Login</a>
                <a href="{{ route('register') }}" class="bg-white text-green-700 px-3 py-1 rounded font-semibold">Register</a>
            @endauth
        </div>
    </div>
</nav>

<main class="flex-1 max-w-7xl mx-auto w-full px-4 py-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4 flex justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()">✕</button>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif
    @yield('content')
</main>

<footer class="footer-bg text-green-200 text-center py-4 text-sm mt-auto">
    © {{ date('Y') }} FarmConnect — Connecting Farmers & Agrovets across Kenya
</footer>
</body>
</html>