@extends('userPanel.layouts.app')

@push('styles')
<style>
    /* Add any specific styles for training profile pages here */
    .training-card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    .training-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    .training-card .card-header {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .training-details {
        padding: 15px;
    }
    .training-details p {
        margin-bottom: 8px;
    }
    .training-actions {
        padding: 10px 15px;
        border-top: 1px solid #dee2e6;
        background-color: #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
@endpush

@section('content')
        .main-content {
            flex-grow: 1;
            padding: 20px;  
            margin-left: 270px;
        }
        .content-header {
            background-color: #e7f1ff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .content-header h2 {
            color: #003366;
            font-size: 1.5rem;
            margin: 0;
            font-weight: bold;
        }
        .search-box {
            position: relative;
            width: 300px;
        }
        .search-box input {
            width: 100%;
            padding: 8px 15px;
            padding-right: 35px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            background-color: white;
        }
        .search-box .search-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .training-table {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .tab-buttons {
            display: inline-flex;
            gap: 5px;
        }
        .tab-button {
            background-color: transparent;
            border: none;
            padding: 8px 20px;
            font-weight: 500;
            color: #666;
            text-decoration: none;
            border-radius: 4px;
        }
        .tab-button:hover {
            text-decoration: none;
            color: #003366;
        }
        .tab-button.active {
            background-color: #003366;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a class="navbar-brand me-4" href="{{ route('user.home') }}">
                    <img src="{{ asset('images/DEPDev_logo.png') }}" alt="DEPDev Logo" class="me-2">
                    <span class="d-none d-md-inline">DEPARTMENT OF ECONOMIC PLANNING AND DEVELOPMENT</span>
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
        <div class="sidebar">
            <a href="{{ route('user.home') }}" class="active"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('user.training.profile') }}" class="active"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="{{ route('user.tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
            <a href="{{ route('user.training.effectiveness') }}"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
            <a href="{{ route('user.training.resources') }}"><i class="bi bi-archive me-2"></i>Training Resources</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-header">
                <h2>Training Profile</h2>
                <div class="search-box">
                    <form method="GET" action="{{ Request::is('training-profile/program') ? route('user.training.profile.program') : route('user.training.profile.unprogrammed') }}">
                        <input type="text" name="search" placeholder="Search by title or type..." value="{{ request('search') }}">
                        <button type="submit" style="border:none;background:none;position:absolute;right:10px;top:50%;transform:translateY(-50%);">
                            <i class="bi bi-search search-icon"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="tab-buttons">
                        <a href="{{ route('user.training.profile.program') }}" class="tab-button {{ Request::is('training-profile/program') ? 'active' : '' }}">Programmed</a>
                        <a href="{{ route('user.training.profile.unprogrammed') }}" class="tab-button {{ Request::is('training-profile/unprogrammed') ? 'active' : '' }}">Trainings Attended</a>
                    </div>
                    <!-- Filter Dropdown -->
                    <div class="dropdown ms-2">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-funnel-fill me-1"></i> Filter
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                            <li><a class="dropdown-item {{ request('sort') == 'title' && request('order') == 'asc' ? 'active' : '' }}" href="?{{ http_build_query(array_merge(request()->except(['sort', 'order']), ['sort' => 'title', 'order' => 'asc'])) }}">Title (A-Z)</a></li>
                            <li><a class="dropdown-item {{ request('sort') == 'title' && request('order') == 'desc' ? 'active' : '' }}" href="?{{ http_build_query(array_merge(request()->except(['sort', 'order']), ['sort' => 'title', 'order' => 'desc'])) }}">Title (Z-A)</a></li>
                            <li><a class="dropdown-item {{ request('sort') == 'created_at' && request('order') == 'desc' ? 'active' : '' }}" href="?{{ http_build_query(array_merge(request()->except(['sort', 'order']), ['sort' => 'created_at', 'order' => 'desc'])) }}">Date Created (Newest)</a></li>
                            <li><a class="dropdown-item {{ request('sort') == 'created_at' && request('order') == 'asc' ? 'active' : '' }}" href="?{{ http_build_query(array_merge(request()->except(['sort', 'order']), ['sort' => 'created_at', 'order' => 'asc'])) }}">Date Created (Oldest)</a></li>
                            @if(Request::is('training-profile/program'))
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item {{ request('sort') == 'status' && request('order') == 'asc' ? 'active' : '' }}" href="?{{ http_build_query(array_merge(request()->except(['sort', 'order']), ['sort' => 'status', 'order' => 'asc'])) }}">Status (Implemented First)</a></li>
                            <li><a class="dropdown-item {{ request('sort') == 'status' && request('order') == 'desc' ? 'active' : '' }}" href="?{{ http_build_query(array_merge(request()->except(['sort', 'order']), ['sort' => 'status', 'order' => 'desc'])) }}">Status (Not Yet Implemented First)</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            @yield('content')
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any specific JavaScript for training profile pages here
    });
</script>
@endpush
@endsection
