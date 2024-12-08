<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Meals on Wheels')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2ECC71;
            --secondary-color: #27AE60;
            --accent-color: #F1C40F;
            --text-dark: #2C3E50;
            --text-light: #ECF0F1;
        }

        /* Navigation Styles */
        .navbar-custom {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px 0;
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
        }

        .btn-donate {
            background-color: var(--primary-color);
            color: white !important;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-donate:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        /* Footer Styles */
        .footer {
            background-color: var(--text-dark);
            color: var(--text-light);
            padding: 70px 0 20px;
        }

        .footer-links, .footer-contact {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li, .footer-contact li {
            margin-bottom: 12px;
        }

        .footer-links a, .footer-bottom-links a {
            color: var(--text-light);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover, .footer-bottom-links a:hover {
            color: var(--primary-color);
        }

        .social-links a {
            color: var(--text-light);
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: var(--primary-color);
        }

        .footer h5 {
            margin-bottom: 20px;
            font-weight: 600;
        }

        .footer-bottom-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-bottom-links li {
            display: inline-block;
            margin-left: 20px;
        }

        @media (max-width: 768px) {
            .footer-bottom-links li {
                margin: 0 10px;
            }
        }

        /* Add these new styles for member navigation */
        .member-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        .member-navbar .navbar-brand {
            font-weight: 600;
            color: var(--primary-color);
        }

        .member-navbar .nav-link {
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin: 0 0.3rem;
        }

        .member-navbar .nav-link:hover,
        .member-navbar .nav-link.active {
            background: rgba(46, 204, 113, 0.1);
            color: var(--primary-color) !important;
        }

        .member-navbar .dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 12px;
        }

        .member-navbar .dropdown-item {
            padding: 0.8rem 1.2rem;
            transition: all 0.3s ease;
        }

        .member-navbar .dropdown-item:hover {
            background: rgba(46, 204, 113, 0.1);
            color: var(--primary-color);
        }

        @media (max-width: 991.98px) {
            .member-navbar .navbar-collapse {
                background: white;
                margin-top: 1rem;
                padding: 1rem;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }
        }

        /* Admin Navigation Styles */
        .admin-navbar {
            background: linear-gradient(to right, #1a1c23, #23272f);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.2);
            padding: 0.8rem 0;
        }

        .admin-navbar .navbar-brand {
            color: #fff;
            font-weight: 600;
        }

        .admin-navbar .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin: 0 0.3rem;
            font-weight: 500;
        }

        .admin-navbar .nav-link:hover,
        .admin-navbar .nav-link.active {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }

        .admin-navbar .btn-donate {
            background: linear-gradient(45deg, #2ECC71, #27AE60);
            border: none;
            padding: 0.8rem 1.5rem;
            color: white !important;
            font-weight: 600;
            border-radius: 25px;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .admin-navbar .btn-donate:hover {
            background: linear-gradient(45deg, #27AE60, #219A52);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
        }

        .admin-navbar .dropdown-menu {
            background: #2c3038;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border-radius: 12px;
            margin-top: 0.5rem;
        }

        .admin-navbar .dropdown-item {
            color: rgba(255, 255, 255, 0.85);
            padding: 0.8rem 1.2rem;
            transition: all 0.3s ease;
        }

        .admin-navbar .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .admin-navbar .dropdown-item.text-danger {
            color: #ff6b6b !important;
        }

        .admin-navbar .dropdown-item.text-danger:hover {
            background: rgba(255, 107, 107, 0.1);
        }

        @media (max-width: 991.98px) {
            .admin-navbar .navbar-collapse {
                background: #2c3038;
                margin-top: 1rem;
                padding: 1rem;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            }

            .admin-navbar .nav-link {
                margin: 0.3rem 0;
            }
        }
    </style>
    @yield('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
</head>
<body>
    @auth
        @switch(Auth::user()->role)
            @case('admin')
                @include('layouts.admin-navigation')
                @break
            @case('volunteer')
                @include('layouts.volunteer-navigation')
                @break
            @case('member')
                @include('layouts.member-navigation')
                @break
            @case('caregiver')
                @include('layouts.caregiver-navigation')
                @break
            @case('partner')
                @include('layouts.partner-navigation')
                @break
            @default
                @include('layouts.navigation')
        @endswitch
    @else
        @include('layouts.navigation')
    @endauth

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <!-- Core JS Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    @stack('scripts')
    @yield('scripts')
</body>
</html> 