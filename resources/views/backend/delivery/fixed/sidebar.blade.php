<div class="sidebar sidebar-dark sidebar-fixed border-end" id="delivery-sidebar">
    <div class="sidebar-header border-bottom p-3">
        <a href="{{ route('delivery.dashboard') }}" class="sidebar-brand d-flex align-items-center text-decoration-none">
            <svg class="me-2" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="1" y="3" width="15" height="13" rx="2"></rect>
                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                <circle cx="18.5" cy="18.5" r="2.5"></circle>
            </svg>
            <div>
                <span class="fw-bold">Capital Shop</span>
                <div style="font-size: 11px; color: rgba(255,255,255,0.5); letter-spacing: 1px; text-transform: uppercase;">Delivery Panel</div>
            </div>
        </a>
    </div>

    <ul class="sidebar-nav list-unstyled px-2">
        {{-- Dashboard --}}
        <li class="nav-item my-1">
            <a class="nav-link {{ request()->routeIs('delivery.dashboard') ? 'active' : '' }}" href="{{ route('delivery.dashboard') }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Dashboard
            </a>
        </li>

        {{-- Assigned Orders --}}
        <li class="nav-item my-1">
            <a class="nav-link {{ request()->routeIs('delivery.assigned-orders') ? 'active' : '' }}" href="{{ route('delivery.assigned-orders') }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="3" width="15" height="13" rx="2"></rect>
                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                </svg>
                Assigned Orders
            </a>
        </li>

        {{-- Delivery History --}}
        <li class="nav-item my-1">
            <a class="nav-link {{ request()->routeIs('delivery.history') ? 'active' : '' }}" href="{{ route('delivery.history') }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 11 12 14 22 4"></polyline>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                </svg>
                Delivery History
            </a>
        </li>

        {{-- Wallet --}}
        <li class="nav-item my-1">
            <a class="nav-link {{ request()->routeIs('delivery.wallet') ? 'active' : '' }}" href="{{ route('delivery.wallet') }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
                Wallet
            </a>
        </li>

        <li class="nav-divider"></li>

        {{-- Profile --}}
        <li class="nav-item my-1">
            <a class="nav-link {{ request()->routeIs('delivery.profile') ? 'active' : '' }}" href="{{ route('delivery.profile') }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                My Profile
            </a>
        </li>

        {{-- Logout --}}
        <li class="nav-item my-1">
            @auth('delivery')
                <form action="{{ route('delivery.logout') }}" method="POST" id="delivery-logout-form">
                    @csrf
                    <a class="nav-link text-danger-subtle" href="#" onclick="event.preventDefault(); document.getElementById('delivery-logout-form').submit();">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Logout
                    </a>
                </form>
            @endauth
        </li>
    </ul>
</div>

<style>
    .nav-divider {
        height: 1px;
        margin: 0.5rem 0;
        background: rgba(255, 255, 255, 0.1);
    }
</style>
