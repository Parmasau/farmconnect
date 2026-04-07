<div class="space-y-2">
    <a href="{{ route('farmer.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.dashboard') ? 'bg-white/20' : '' }}">
        <i class="fas fa-tachometer-alt w-5"></i> Dashboard
    </a>
    <a href="{{ route('farmer.products.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.products.index') ? 'bg-white/20' : '' }}">
        <i class="fas fa-box w-5"></i> My Products
    </a>
    <a href="{{ route('farmer.products.create') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.products.create') ? 'bg-white/20' : '' }}">
        <i class="fas fa-plus w-5"></i> Add Product
    </a>
    <a href="{{ route('farmer.products.marketplace', ['seller' => 'farmer']) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white">
        <i class="fas fa-store w-5"></i> Buy from Farmers
    </a>
    <a href="{{ route('farmer.advice.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.advice.*') ? 'bg-white/20' : '' }}">
        <i class="fas fa-stethoscope w-5"></i> Advice
    </a>
    <a href="{{ route('farmer.consultations.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.consultations.*') ? 'bg-white/20' : '' }}">
        <i class="fas fa-comments w-5"></i> Consultations
    </a>
    <a href="{{ route('farmer.analytics.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white">
        <i class="fas fa-chart-line w-5"></i> Analytics
    </a>
    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white mt-4 border-t border-white/20 pt-4">
        <i class="fas fa-user-circle w-5"></i> My Profile
    </a>
</div>
