<div class="space-y-2">
    <!-- Dashboard -->
    <a href="{{ route('farmer.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.dashboard') ? 'bg-white/20' : '' }}">
        <i class="fas fa-tachometer-alt w-5"></i> Dashboard
    </a>

    <!-- Products Section -->
    <div class="pt-2">
        <p class="text-xs text-green-300 uppercase tracking-wider mb-2 px-3">PRODUCTS</p>
        <a href="{{ route('farmer.products.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.products.index') ? 'bg-white/20' : '' }}">
            <i class="fas fa-box w-5"></i> My Products (Selling)
        </a>
        <a href="{{ route('farmer.products.purchased') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.products.purchased') ? 'bg-white/20' : '' }}">
            <i class="fas fa-shopping-cart w-5"></i> Purchased Products
        </a>
        <a href="{{ route('farmer.products.create') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.products.create') ? 'bg-white/20' : '' }}">
            <i class="fas fa-plus w-5"></i> Add Product
        </a>
    </div>

    <!-- Marketplace Section -->
    <div class="pt-2">
        <p class="text-xs text-green-300 uppercase tracking-wider mb-2 px-3">MARKETPLACE</p>
        <a href="{{ route('farmer.products.marketplace', ['seller' => 'farmer']) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white">
            <i class="fas fa-store w-5"></i> Buy from Farmers
        </a>
        <a href="{{ route('farmer.products.agrovet') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.products.agrovet') ? 'bg-white/20' : '' }}">
            <i class="fas fa-flask w-5"></i> Buy from Agrovets
        </a>
    </div>

    <!-- Services Section -->
    <div class="pt-2">
        <p class="text-xs text-green-300 uppercase tracking-wider mb-2 px-3">SERVICES</p>
        <a href="{{ route('farmer.advice.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.advice.*') ? 'bg-white/20' : '' }}">
            <i class="fas fa-stethoscope w-5"></i> Advice
        </a>
        <a href="{{ route('farmer.consultations.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.consultations.*') ? 'bg-white/20' : '' }}">
            <i class="fas fa-comments w-5"></i> Consultations
        </a>
        <a href="{{ route('farmer.messages.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.messages.*') ? 'bg-white/20' : '' }}">
            <i class="fas fa-envelope w-5"></i> Messages
            <span id="unreadCount" class="bg-red-500 text-white text-xs rounded-full px-1 hidden ml-auto"></span>
        </a>
    </div>

    <!-- Analytics -->
    <div class="pt-2">
        <p class="text-xs text-green-300 uppercase tracking-wider mb-2 px-3">ANALYTICS</p>
        <a href="{{ route('farmer.analytics.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('farmer.analytics.*') ? 'bg-white/20' : '' }}">
            <i class="fas fa-chart-line w-5"></i> Analytics
        </a>
    </div>

    <!-- Profile & Logout -->
    <div class="pt-4 mt-4 border-t border-white/20">
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white/20 text-white {{ request()->routeIs('profile.edit') ? 'bg-white/20' : '' }}">
            <i class="fas fa-user-circle w-5"></i> My Profile
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-red-600/80 text-white w-full transition-colors">
                <i class="fas fa-sign-out-alt w-5"></i> Logout
            </button>
        </form>
    </div>
</div>

<script>
    function updateUnreadCount() {
        fetch('{{ route("farmer.messages.unread") }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('unreadCount');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.textContent = '';
                    badge.classList.add('hidden');
                }
            })
            .catch(error => console.error('Error:', error));
    }
    setInterval(updateUnreadCount, 30000);
    updateUnreadCount();
</script>