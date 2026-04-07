<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmConnect - @yield('title')</title>
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
            background: rgba(0, 0, 0, 0.7);
            z-index: 0;
        }
        .bg-farm > * {
            position: relative;
            z-index: 1;
        }
        .sidebar-bg {
            background: linear-gradient(135deg, rgba(22, 101, 52, 0.95), rgba(21, 128, 61, 0.95));
            backdrop-filter: blur(10px);
        }
        .card-bg {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
        }
    </style>
</head>
<body class="bg-farm">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 sidebar-bg text-white flex flex-col shadow-xl">
            <div class="p-4 text-xl font-bold border-b border-white/20">🌱 FarmConnect</div>
            <nav class="flex-1 p-4 overflow-y-auto">
                @yield('sidebar')
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
