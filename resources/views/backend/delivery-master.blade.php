<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Delivery Dashboard') - Capital Shop</title>

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicon/favicon-32x32.png')}}">

    <!-- Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        :root {
            --dp-primary: #16a34a;
            --dp-primary-dark: #15803d;
            --dp-primary-light: #22c55e;
            --dp-secondary: #64748b;
            --dp-success: #10b981;
            --dp-info: #06b6d4;
            --dp-warning: #f59e0b;
            --dp-danger: #ef4444;
            --dp-sidebar-bg: #0f172a;
            --dp-sidebar-hover: rgba(255, 255, 255, 0.08);
            --dp-sidebar-active: linear-gradient(135deg, #16a34a, #22c55e);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        /* ===== Sidebar Styles ===== */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1030;
            width: 260px;
            background: var(--dp-sidebar-bg);
            overflow-y: auto;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-header {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            color: #fff;
            font-size: 1.15rem;
            font-weight: 600;
        }

        .sidebar-nav {
            padding: 1rem 0;
            list-style: none;
        }

        .nav-item {
            margin: 0.15rem 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.7rem 1rem;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: all 0.25s ease;
            border-radius: 0.5rem;
            margin: 0 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #fff;
            background: var(--dp-sidebar-hover);
        }
+
.
        .nav-link.active {
            color: #fff;
            background: var(--dp-sidebar-active);
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
            stroke: currentColor;
            flex-shrink: 0;
        }

        /* ===== Main Wrapper ===== */
        .wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===== Header ===== */
        .header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .header .container-fluid {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
        }

        .header-toggler {
            background: none;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
            display: none;
        }

        .header-nav {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .header-nav .nav-link {
            padding: 0.5rem 1rem;
            color: #4f5d73;
            text-decoration: none;
        }

        .header-nav .nav-link:hover {
            color: var(--dp-primary);
        }

        /* ===== Body Content ===== */
        .body {
            flex: 1;
            padding: 1.5rem 0;
        }

        /* ===== Footer ===== */
        .footer {
            margin-top: auto;
            padding: 1rem;
            background: #fff;
            border-top: 1px solid #e2e8f0;
            font-size: 0.85rem;
            color: #64748b;
        }

        /* ===== Cards ===== */
        .card {
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* ===== Breadcrumb ===== */
        .breadcrumb {
            background: transparent;
            margin: 0;
            padding: 0.5rem 0;
            font-size: 0.85rem;
        }

        .breadcrumb-item a {
            color: var(--dp-primary);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: var(--dp-primary-dark);
        }

        /* ===== Alert styles ===== */
        .alert {
            border-radius: 0.75rem;
            border: none;
            font-size: 0.9rem;
        }

        /* ===== Mobile Responsive ===== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-260px);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .wrapper {
                margin-left: 0;
            }

            .header-toggler {
                display: block;
            }
        }

        /* ===== Dropdown ===== */
        .dropdown-menu {
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .dropdown-item:hover {
            background: #f1f5f9;
        }

        /* ===== Avatar ===== */
        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        /* ===== Scrollbar ===== */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        /* ===== Status Badges ===== */
        .badge-delivered {
            background: linear-gradient(135deg, #10b981, #34d399);
            color: #fff;
        }

        .badge-pending {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: #fff;
        }

        .badge-in-transit {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            color: #fff;
        }

        /* ===== Sidebar Mobile Overlay ===== */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1025;
        }

        .sidebar.show ~ .sidebar-backdrop {
            display: block;
        }
    </style>

    @notifyCss
    @stack('styles')
</head>
<body>
    <x-notify::notify />
    @include('backend.delivery.fixed.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100">
        @include('backend.delivery.fixed.header')

        <div class="body grow">
            @yield('content')
        </div>

        @include('backend.delivery.fixed.footer')
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggler = document.querySelector('.header-toggler');

            if (window.innerWidth <= 992) {
                if (!sidebar.contains(event.target) && toggler && !toggler.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Header shadow on scroll
        const header = document.querySelector('.header');
        window.addEventListener('scroll', () => {
            if (header) {
                if (window.scrollY > 0) {
                    header.style.boxShadow = '0 4px 12px rgba(0,0,0,0.06)';
                } else {
                    header.style.boxShadow = 'none';
                }
            }
        });
    </script>

    @notifyJs
    @stack('scripts')
</body>
</html>
