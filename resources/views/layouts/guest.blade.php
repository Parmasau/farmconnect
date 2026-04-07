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
    </style>
</head>
<body class="bg-farm min-h-screen flex flex-col">
    <main class="flex-1">
        @yield('content')
    </main>
</body>
</html>