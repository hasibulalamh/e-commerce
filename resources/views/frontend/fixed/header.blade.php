<header>
    <div class="header-area">
        <!-- Top Header -->
        <div class="header-top d-none d-sm-block" style="border-bottom: 1px solid #eee; padding: 10px 0; font-size: 14px;">
            <!-- Previous top header content remains the same until the main menu -->

            <!-- Main Header -->
            <div class="header-mid header-sticky bg-white py-3">
                <div class="container">
                    <div class="menu-wrapper d-flex justify-content-between align-items-center">
                        <!-- Logo section remains the same -->
                        <div class="logo">
                            <a href="{{route('Home')}}">
                                <img src="https://preview.colorlib.com/theme/capitalshop/assets/img/logo/logo.png.webp" alt="Logo" class="img-fluid" style="max-height: 50px;">
                            </a>
                        </div>

                        <!-- Main Menu with inline hover effects -->
                        <div class="main-menu d-none d-lg-block">
                            <nav>
                                <ul id="navigation" class="list-unstyled d-flex m-0">
                                    <li class="nav-item"><a href="{{route('Home')}}" class="nav-link px-3" style="color: #333; font-weight: 500; transition: color 0.3s ease;" onmouseenter="this.style.color='#ff2020'" onmouseleave="this.style.color='#333'">Home</a></li>
                                    <li class="nav-item"><a href="{{route('customer.brand')}}" class="nav-link px-3" style="color: #333; font-weight: 500; transition: color 0.3s ease;" onmouseenter="this.style.color='#ff2020'" onmouseleave="this.style.color='#333'">Brand</a></li>
                                    <li class="nav-item dropdown">
                                        <a href="{{route('product.listview')}}" class="nav-link px-3 dropdown-toggle" style="color: #333; font-weight: 500; transition: color 0.3s ease;" onmouseenter="this.style.color='#ff2020'" onmouseleave="this.style.color='#333'">Products</a>
                                        <!-- Dropdown menu remains the same -->
                                    </li>

                                </ul>
                            </nav>
                        </div>

                        <!-- Header Right with inline hover effects -->
                        <div class="header-right">
                            <ul class="list-unstyled d-flex align-items-center m-0">
                                <li class="nav-item me-4">
                                    <form action="{{ route('product.search') }}" method="GET" class="d-flex align-items-center">
                                        <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}" class="form-control form-control-sm" style="border-radius: 20px 0 0 20px; border: 1px solid #eee;">
                                        <button type="submit" class="btn btn-sm py-0 px-2" style="border-radius: 0 20px 20px 0; background: #eee; border: 1px solid #eee; height: 31px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                </li>
                                @php $cartCount = count(session('cart', [])); @endphp

                                <li class="nav-item me-4">
                                    <a href="{{ route('cart.view') }}" 
                                       style="position:relative; display:inline-flex; 
                                              align-items:center; gap:5px;
                                              text-decoration:none; color:#333;
                                              padding:6px 12px; border-radius:20px;
                                              background:#f8f8f8; border:1px solid #eee;">
                                        
                                        {{-- Cart Icon --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="9" cy="21" r="1"></circle>
                                            <circle cx="20" cy="21" r="1"></circle>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                        </svg>
                                        
                                        {{-- Count Badge --}}
                                        @if($cartCount > 0)
                                            <span class="cart-count-badge" style="background:#e44d26; color:white;
                                                         border-radius:50%; min-width:20px; height:20px;
                                                         font-size:11px; font-weight:700;
                                                         display:inline-flex; align-items:center; 
                                                         justify-content:center; padding:0 4px;">
                                                {{ $cartCount }}
                                            </span>
                                        @else
                                            <span class="cart-count-badge" style="color:#999; font-size:13px;">0</span>
                                        @endif
                                    </a>
                                </li>
                                @if(auth('customerg')->check())
                                <li class="nav-item" style="position: relative; list-style: none;">
                                    <a href="javascript:void(0)" id="accountDropdownBtn"
                                       style="color: #333; font-weight: 600; padding: 8px 15px; display: flex; align-items: center; gap: 5px; text-decoration: none; cursor: pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        {{ auth('customerg')->user()->name }}
                                        <small>▼</small>
                                    </a>
                                    <div id="accountDropdownMenu" 
                                         style="display: none; position: absolute; top: 100%; right: 0; min-width: 180px; 
                                                background: white; border: 1px solid #eee; box-shadow: 0 10px 25px rgba(0,0,0,0.15); 
                                                border-radius: 12px; padding: 10px; z-index: 999999; margin-top: 5px;">
                                        <a href="{{ route('customer.profile') }}" 
                                           style="display: block; padding: 10px 15px; color: #333; text-decoration: none; font-weight: 500; border-radius: 8px; transition: 0.2s;"
                                           onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='transparent'">
                                            👤 Profile
                                        </a>
                                        <a href="{{ route('customer.wishlist') }}" 
                                           style="display: block; padding: 10px 15px; color: #333; text-decoration: none; font-weight: 500; border-radius: 8px; transition: 0.2s;"
                                           onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='transparent'">
                                            ❤️ Wishlist
                                        </a>
                                        <div style="height: 1px; background: #eee; margin: 5px 0;"></div>
                                        <form action="{{ route('customer.logout') }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" 
                                                    style="display: block; width: 100%; text-align: left; padding: 10px 15px; color: #dc3545; 
                                                           text-decoration: none; font-weight: 500; border-radius: 8px; border: none; background: none; cursor: pointer; transition: 0.2s;"
                                                    onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='transparent'">
                                                🚪 Logout
                                            </button>
                                        </form>
                                    </div>
                                </li>
                                @else
                                <li class="nav-item">
                                    <a href="{{ route('customer.login') }}" class="nav-link" 
                                        style="color: #333; font-weight: 500; transition: color 0.3s ease; padding: 8px 15px;"
                                        onmouseenter="this.style.color='#ff2020'" onmouseleave="this.style.color='#333'">
                                        Login/Register
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rest of the code remains the same -->
        </div>
    </div>
</header>

<style>
    /* Ensure dropdown is visible when 'show' class is added */
    .nav-item.dropdown .dropdown-menu.show {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('accountDropdownBtn');
        const menu = document.getElementById('accountDropdownMenu');
        
        if (btn && menu) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const isVisible = menu.style.display === 'block';
                menu.style.display = isVisible ? 'none' : 'block';
            });

            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    menu.style.display = 'none';
                }
            });
        }
    });
</script>