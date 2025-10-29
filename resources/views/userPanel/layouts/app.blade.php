<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DEPDEV - {{ $title ?? 'User Panel' }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background-color: #f8f9fa;
            padding-top: 60px;
        }
        .navbar {
            background-color: #fff;
            padding: 0.5rem 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1040;
            height: 60px;
        }
        .navbar-brand {
            color: #003366 !important;
            font-size: 1rem;
            display: flex;
            align-items: center;
            font-weight: bold;
        }
        .navbar-brand img {
            height: 30px;
            margin-right: 10px;
        }
        .nav-link, .user-menu {
            color: black !important;
        }
        .sidebar {
            background-color: #003366;
            min-height: calc(100vh - 60px);
            width: 270px;
            padding-top: 20px;
            position: fixed;
            top: 60px;
            left: 0;
            transition: transform 0.3s ease;
            z-index: 1030;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: all 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.1);
            padding-left: 25px;
        }
        .sidebar a i {
            width: 24px;
            text-align: center;
            margin-right: 10px;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
            width: calc(100% - 270px);
            transition: margin 0.3s ease, width 0.3s ease;
        }
        .profile-picture {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        .user-menu {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .user-menu:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
            padding: 0.5rem 0;
        }
        .dropdown-item {
            padding: 0.5rem 1.5rem;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .dropdown-divider {
            margin: 0.5rem 0;
        }
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            .sidebar.show + .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            margin-right: 1rem;
        }
        @media (max-width: 992px) {
            .sidebar-toggle {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <a class="navbar-brand" href="{{ route('user.home') }}">
                    <img src="{{ asset('images/DEPDev_logo.png') }}" alt="DEPDev Logo">
                    <span>DEPARTMENT OF ECONOMIC PLANNING AND DEVELOPMENT</span>
                </a>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown" style="cursor:pointer;">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="profile-picture">
                        @else
                            <i class="bi bi-person-circle"></i>
                        @endif
                        <span class="ms-2 d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('user.profile.info') }}">
                            <i class="bi bi-person me-2"></i> My Profile
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right text-danger me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <a href="{{ route('user.home') }}" class="{{ request()->routeIs('user.home') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i> Home
            </a>
            <a href="{{ route('user.training.profile') }}" class="{{ request()->routeIs('user.training.profile*') ? 'active' : '' }}">
                <i class="bi bi-person-vcard"></i> Training Profile
            </a>
            <a href="{{ route('user.tracking') }}" class="{{ request()->routeIs('user.tracking*') ? 'active' : '' }}">
                <i class="bi bi-journal-check"></i> Training Tracking
            </a>
            <a href="{{ route('user.training.effectiveness') }}" class="{{ request()->routeIs('user.training.effectiveness*') ? 'active' : '' }}">
                <i class="bi bi-graph-up"></i> Training Effectiveness
            </a>
            <a href="{{ route('user.training.resources') }}" class="{{ request()->routeIs('user.training.resources*') ? 'active' : '' }}">
                <i class="bi bi-folder"></i> Training Resources
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnToggle = sidebarToggle.contains(event.target);
                
                if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth <= 992) {
                    sidebar.classList.remove('show');
                }
            });

            // Handle window resize
            function handleResize() {
                if (window.innerWidth > 992) {
                    sidebar.classList.remove('show');
                }
            }

            window.addEventListener('resize', handleResize);
        });
    </script>
    @stack('scripts')
</body>
</html>
