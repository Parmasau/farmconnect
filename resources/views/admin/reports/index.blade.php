@extends('layouts.dashboard')

@section('title', 'Reports - Admin Dashboard')

@section('sidebar')
    @include('admin.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold">Reports & Analytics</h1>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
            <div class="text-3xl mb-2">👥</div>
            <div class="text-2xl font-bold text-green-700">{{ $totalUsers ?? 0 }}</div>
            <div class="text-sm text-gray-500">Total Users</div>
            <div class="text-xs text-gray-400 mt-2">
                👨‍🌾 Farmers: {{ $totalFarmers ?? 0 }} | 🔬 Agrovets: {{ $totalAgrovets ?? 0 }}
            </div>
        </div>
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
            <div class="text-3xl mb-2">📦</div>
            <div class="text-2xl font-bold text-green-700">{{ $totalProducts ?? 0 }}</div>
            <div class="text-sm text-gray-500">Total Products</div>
        </div>
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
            <div class="text-3xl mb-2">📋</div>
            <div class="text-2xl font-bold text-green-700">{{ $totalOrders ?? 0 }}</div>
            <div class="text-sm text-gray-500">Total Orders</div>
        </div>
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
            <div class="text-3xl mb-2">💰</div>
            <div class="text-2xl font-bold text-green-700">KSh {{ number_format($totalRevenue ?? 0, 0) }}</div>
            <div class="text-sm text-gray-500">Total Revenue</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- User Distribution Chart -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">User Distribution</h2>
            <canvas id="userChart" height="250"></canvas>
        </div>

        <!-- Order Status Chart -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Order Status Distribution</h2>
            <canvas id="orderStatusChart" height="250"></canvas>
        </div>
    </div>

    <!-- Recent Activity Tables -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Recent Users</h2>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-green-600 hover:underline">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($recentUsers ?? [] as $user)
                <div class="flex justify-between items-center py-2 border-b">
                    <div>
                        <p class="font-medium">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-xs px-2 py-1 rounded-full 
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 
                               ($user->role === 'agrovet' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                        <p class="text-xs text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No users found</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-green-600 hover:underline">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($recentOrders ?? [] as $order)
                <div class="flex justify-between items-center py-2 border-b">
                    <div>
                        <p class="font-medium">#{{ $order->order_number }}</p>
                        <p class="text-xs text-gray-500">{{ $order->buyer->name ?? 'N/A' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-green-700">KSh {{ number_format($order->total_amount, 2) }}</p>
                        <span class="text-xs px-2 py-1 rounded-full 
                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 
                               ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                               ($order->status === 'processing' ? 'bg-purple-100 text-purple-700' : 'bg-red-100 text-red-700')) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No orders found</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // User Distribution Chart
    const userCtx = document.getElementById('userChart').getContext('2d');
    new Chart(userCtx, {
        type: 'doughnut',
        data: {
            labels: ['Farmers', 'Agrovets', 'Admins'],
            datasets: [{
                data: [{{ $totalFarmers ?? 0 }}, {{ $totalAgrovets ?? 0 }}, {{ $totalAdmins ?? 0 }}],
                backgroundColor: ['#22c55e', '#8b5cf6', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Order Status Chart
    const orderCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(orderCtx, {
        type: 'bar',
        data: {
            labels: ['Pending', 'Processing', 'Completed', 'Cancelled'],
            datasets: [{
                label: 'Number of Orders',
                data: [{{ $pendingOrders ?? 0 }}, {{ $processingOrders ?? 0 }}, {{ $completedOrders ?? 0 }}, {{ $cancelledOrders ?? 0 }}],
                backgroundColor: ['#eab308', '#8b5cf6', '#22c55e', '#ef4444'],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection
