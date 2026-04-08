<div class="space-y-2">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">
        <i class="fas fa-tachometer-alt w-5"></i> Dashboard
    </a>
    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('admin.users.*') ? 'bg-white/20' : '' }}">
        <i class="fas fa-users w-5"></i> Users
    </a>
    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('admin.products.*') ? 'bg-white/20' : '' }}">
        <i class="fas fa-box w-5"></i> Products
    </a>
    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('admin.orders.*') ? 'bg-white/20' : '' }}">
        <i class="fas fa-shopping-cart w-5"></i> Orders
    </a>
    <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white">
        <i class="fas fa-chart-line w-5"></i> Reports
    </a>
    <a href="{{ route('admin.contact.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white">
        <i class="fas fa-envelope w-5"></i> Contact Messages
    </a>
    
    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white mt-4 border-t border-white/20 pt-4">
        <i class="fas fa-user-circle w-5"></i> My Profile
    </a>
    
    <div class="pt-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-red-600/80 text-white w-full transition-colors">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</div>
