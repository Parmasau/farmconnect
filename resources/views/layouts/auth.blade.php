<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmConnect — @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
<nav class="bg-green-700 text-white px-6 py-3 flex justify-between items-center">
    <a href="{{ route('landing') }}" class="font-bold text-xl">🌱 FarmConnect</a>
    <div class="flex gap-4 text-sm">
        @auth
            <a href="{{ auth()->user()->dashboardRoute() }}" class="hover:text-green-200">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">@csrf
                <button class="hover:text-green-200">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="hover:text-green-200">Login</a>
            <a href="{{ route('register') }}" class="bg-white text-green-700 px-3 py-1 rounded font-semibold">Register</a>
        @endauth
    </div>
</nav>
<main class="flex-1 flex items-center justify-center py-10 px-4">
    @yield('content')
</main>
</body>
</html>