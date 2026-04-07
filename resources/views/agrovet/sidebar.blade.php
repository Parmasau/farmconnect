<div class="space-y-2">
    <a href="{{ route('agrovet.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('agrovet.dashboard') ? 'bg-white/20' : '' }}">
        <i class="fas fa-tachometer-alt w-5"></i> Dashboard
    </a>
    <a href="{{ route('agrovet.products.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('agrovet.products.index') ? 'bg-white/20' : '' }}">
        <i class="fas fa-box w-5"></i> My Products
    </a>
    <a href="{{ route('agrovet.orders.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('agrovet.orders.index') ? 'bg-white/20' : '' }}">
        <i class="fas fa-shopping-cart w-5"></i> Orders
    </a>
    <a href="{{ route('agrovet.advice.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('agrovet.advice.*') ? 'bg-white/20' : '' }}">
        <i class="fas fa-stethoscope w-5"></i> Advice Requests
    </a>
    <a href="{{ route('agrovet.consultations.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('agrovet.consultations.*') ? 'bg-white/20' : '' }}">
        <i class="fas fa-comments w-5"></i> Consultations
    </a>
    <a href="{{ route('agrovet.messages.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('agrovet.messages.*') ? 'bg-white/20' : '' }}">
        <i class="fas fa-envelope w-5"></i> Messages
    </a>
    <a href="{{ route('agrovet.analytics.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white">
        <i class="fas fa-chart-line w-5"></i> Analytics
    </a>
    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white mt-4 border-t border-white/20 pt-4">
        <i class="fas fa-user-circle w-5"></i> My Profile
    </a>
</div>
