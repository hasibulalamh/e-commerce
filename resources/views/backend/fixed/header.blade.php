<header class="header header-sticky p-0 mb-4">
    <div class="container-fluid border-bottom px-4">
        <button class="header-toggler btn btn-link d-lg-none" type="button" onclick="toggleSidebar()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <ul class="header-nav d-none d-lg-flex list-unstyled mb-0">
            <li class="nav-item">
                <a class="nav-link" href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('product.list')}}">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('orders.list')}}">Orders</a>
            </li>
        </ul>

        <ul class="header-nav ms-auto list-unstyled mb-0 d-flex align-items-center">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </a>
            </li>

            <li class="nav-item py-1">
                <div class="vr h-100 mx-2"></div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link py-0 pe-0 d-flex align-items-center" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                    <div class="avatar avatar-md">
                        <img class="avatar-img rounded-circle" src="https://ui-avatars.com/api/?name={{auth()->user()->name ?? 'Admin'}}&background=321fdb&color=fff" alt="{{auth()->user()->name ?? 'Admin'}}">
                    </div>
                    <span class="ms-2 d-none d-md-inline">{{auth()->user()->name ?? 'Admin'}}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light fw-semibold mb-2">Account</div>

                    <a class="dropdown-item" href="{{route('profile.edit')}}">
                        <svg class="me-2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Profile
                    </a>

                    <a class="dropdown-item" href="#">
                        <svg class="me-2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M12 1v6m0 6v6m5.2-14.2l-4.2 4.2m0 6l4.2 4.2M23 12h-6m-6 0H5m14.2 5.2l-4.2-4.2m0-6l4.2-4.2"></path>
                        </svg>
                        Settings
                    </a>

                    <div class="dropdown-divider"></div>

                    <form action="{{route('admin.logout')}}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger" style="border: none; background: none; width: 100%; text-align: left;">
                            <svg class="me-2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>

    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 py-2">
                <li class="breadcrumb-item">
                    <a href="{{route('dashboard')}}">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    @yield('breadcrumb', 'Dashboard')
                </li>
            </ol>
        </nav>
    </div>
</header>

<style>
    .avatar {
        width: 36px;
        height: 36px;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .header-nav .nav-link {
        padding: 0.75rem 1rem;
        color: #4f5d73;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .header-nav .nav-link:hover {
        color: #321fdb;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
    }
</style>
