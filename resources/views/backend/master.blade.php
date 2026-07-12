<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title', 'Admin Dashboard - E-Commerce')</title>

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicon/favicon-32x32.png')}}">

    <!-- Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        :root {
            --cui-primary: #321fdb;
            --cui-secondary: #9da5b1;
            --cui-success: #2eb85c;
            --cui-info: #39f;
            --cui-warning: #f9b115;
            --cui-danger: #e55353;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #f8f9fa;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1030;
            width: 256px;
            background: #1e1e2d;
            overflow-y: auto;
            transition: all 0.3s;
        }

        .sidebar-header {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            color: #fff;
            font-size: 1.25rem;
            font-weight: 600;
            text-decoration: none;
        }

        .sidebar-nav {
            padding: 1rem 0;
            list-style: none;
        }

        .nav-item {
            margin: 0.25rem 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-radius: 0.375rem;
            margin: 0 0.5rem;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            color: #fff;
            background: var(--cui-primary);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
            stroke: currentColor;
        }

        /* Main Wrapper */
        .wrapper {
            margin-left: 256px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }

        /* Header */
        .header {
            background: #fff;
            border-bottom: 1px solid #d8dbe0;
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
            color: var(--cui-primary);
        }

        /* Body Content */
        .body {
            flex: 1;
            padding: 1.5rem 0;
        }

        /* Footer */
        .footer {
            margin-top: auto;
            padding: 1rem;
            background: #fff;
            border-top: 1px solid #d8dbe0;
        }

        /* Cards */
        .card {
            border: 1px solid #d8dbe0;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            margin: 0;
            padding: 0.5rem 0;
        }

        .breadcrumb-item a {
            color: var(--cui-primary);
            text-decoration: none;
        }

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-256px);
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

        /* Dropdown */
        .dropdown-menu {
            border: 1px solid #d8dbe0;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
        }

        /* Avatar */
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
    </style>

    @stack('styles')
</head>
<body>
    @include('backend.fixed.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100">
        @include('backend.fixed.header')

        <div class="body grow">
            @yield('content')
        </div>

        @include('backend.fixed.footer')
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

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
                if (!sidebar.contains(event.target) && !toggler.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Header shadow on scroll
        const header = document.querySelector('.header');
        window.addEventListener('scroll', () => {
            if (header) {
                if (window.scrollY > 0) {
                    header.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
                } else {
                    header.style.boxShadow = 'none';
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
