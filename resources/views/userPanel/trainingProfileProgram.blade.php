<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Training Profile - Program</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color:rgb(255, 255, 255);
            padding: 0.5rem 1rem;
            box-shadow: 1px 3px 3px 0px #737373;
        }
        .navbar-brand {
            color: #003366 !important;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            height: 30px;
            margin-right: 10px;
        }
        .nav-link, .user-icon, .user-menu {
            color: black !important;
        }
        .sidebar {
            background-color: #003366;
            position: fixed;
            top: 56px;
            left: 0;
            width: 270px;
            height: calc(100vh - 56px);
            padding-top: 20px;
            z-index: 1030;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            font-size: 0.9rem;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #004080;
            font-weight: bold;
        }
        .main-content {
            margin-left: 270px;
            margin-top: 56px;
            height: calc(100vh - 56px);
            overflow-y: auto;
            background-color: rgb(187, 219, 252);
            padding: 20px;
            width: calc(100vw - 270px);
        }
        .content-header {
            background-color: #e7f1ff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .content-header h2 {
            color: #003366;
            font-size: 1.5rem;
            margin: 0;
            font-weight: bold;
        }
        .search-box {
            position: relative;
            width: 320px;
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
        .training-table th {
            background-color: #003366;
            color: white;
            font-weight: 500;
            padding: 12px 15px;
        }
        .training-table td {
            padding: 12px 15px;
            vertical-align: middle;
        }
        .training-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .btn-info {
            background-color: #003366;
            border-color: #003366;
            color: white;
        }
        .btn-info:hover {
            background-color: #004080;
            border-color: #004080;
            color: white;
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
        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .dropdown-item.text-danger:hover {
            background-color: #dc3545;
            color: white !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #fff; position: fixed; top: 0; left: 0; width: 100%; z-index: 1040;">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="/images/DEPDev_logo.png" alt="NEDA Logo" style="height: 30px; margin-right: 10px;">
                    <span style="color: #003366; font-size: 1rem; font-weight: bold;">
                        DEPDEV Learning and Development Database System Region VII
                    </span>
                </a>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown" style="cursor:pointer;">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->last_name && auth()->user()->first_name ? auth()->user()->last_name . ', ' . auth()->user()->first_name : (auth()->user()->last_name ?? auth()->user()->first_name ?? 'User') }}
                        <i class="bi bi-chevron-down ms-1"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item logout-btn">
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
        <div class="sidebar" style="top: 56px;">
            <a href="{{ route('user.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('user.training.profile') }}" class="active"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="{{ route('user.tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
            <a href="{{ route('user.training.effectiveness') }}"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
            <a href="{{ route('user.training.resources') }}"><i class="bi bi-archive me-2"></i>Training Resources</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-header">
                <h2>Training Profile</h2>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                <div class="tab-buttons">
                    <a href="{{ route('user.training.profile.program') }}" class="tab-button active">Programmed</a>
                    <a href="{{ route('user.training.profile.unprogrammed') }}" class="tab-button">Unprogrammed</a>
                    </div>
                    <!-- Filter Dropdown -->
                    <div class="dropdown ms-2">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-funnel-fill me-1"></i> Filter
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                            <li><a class="dropdown-item {{ request('sort') == 'title' && request('order') == 'asc' ? 'active' : '' }}" href="?sort=title&order=asc">Title (A-Z)</a></li>
                            <li><a class="dropdown-item {{ request('sort') == 'title' && request('order') == 'desc' ? 'active' : '' }}" href="?sort=title&order=desc">Title (Z-A)</a></li>
                            <li><a class="dropdown-item {{ request('sort') == 'created_at' && request('order') == 'desc' ? 'active' : '' }}" href="?sort=created_at&order=desc">Date Created (Newest)</a></li>
                            <li><a class="dropdown-item {{ request('sort') == 'created_at' && request('order') == 'asc' ? 'active' : '' }}" href="?sort=created_at&order=asc">Date Created (Oldest)</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item {{ request('sort') == 'status' && request('order') == 'asc' ? 'active' : '' }}" href="?sort=status&order=asc">Status (Implemented First)</a></li>
                            <li><a class="dropdown-item {{ request('sort') == 'status' && request('order') == 'desc' ? 'active' : '' }}" href="?sort=status&order=desc">Status (Not Yet Implemented First)</a></li>
                        </ul>
                    </div>
                </div>
                <div class="search-box">
                    <form method="GET" action="{{ route('user.training.profile.program') }}">
                        <input type="text" name="search" placeholder="Search by title, competency, or year..." value="{{ request('search') }}">
                        <button type="submit" style="border:none;background:none;position:absolute;right:10px;top:50%;transform:translateY(-50%);">
                    <i class="bi bi-search search-icon"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="training-table">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="background-color: #003366; color: white; border-right: 2px solid white;">Training Title</th>
                            <th class="text-center" style="background-color: #003366; color: white; border-right: 2px solid white;">Competency</th>
                            <th class="text-center" style="background-color: #003366; color: white; border-right: 2px solid white;">Period of Implementation</th>
                            <th class="text-center" style="background-color: #003366; color: white; border-right: 2px solid white;">No. of Hours</th>
                            <th class="text-center" style="background-color: #003366; color: white; border-right: 2px solid white;">Provider</th>
                            <th class="text-center" style="background-color: #003366; color: white; border-right: 2px solid white;">Status</th>
                            <th class="text-center" style="background-color: #003366; color: white; border-right: 2px solid white;">User Role</th>
                            <th class="text-center" style="background-color: #003366; color: white;">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainings as $training)
                        @php
                            $preEvaluated = !is_null($training->participant_pre_rating);
                        @endphp
                        <tr data-training-id="{{ $training->id }}"
                            data-pre-rating="{{ $training->participant_pre_rating ?? '' }}"
                            data-post-rating="{{ $training->participant_post_rating ?? '' }}">
                            <td class="text-center">{{ $training->title }}</td>
                            <td class="text-center">{{ $training->competency->name }}</td>
                            <td class="text-center">
                                @if($training->status === 'Implemented' )
                                    {{ $training->implementation_date_to ? \Carbon\Carbon::parse($training->implementation_date_to)->format('m/d/Y') : 'Not set' }}
                                @else
                                    {{ $training->period_from ?? 'Not set' }} - {{ $training->period_to ?? 'Not set' }}
                                @endif
                            </td>
                            <td class="text-center">{{ $training->no_of_hours }}</td>
                            <td class="text-center">{{ $training->provider }}</td>
                            <td class="text-center">
                                @php
                                    // Check if current user has completed pre-evaluation
                                    $userEvaluation = $training->evaluations->where('user_id', Auth::id())->first();
                                    $hasPreEvaluation = $userEvaluation && $userEvaluation->participant_pre_rating !== null;

                                    // Check if current user has completed tracking (has implementation dates)
                                    $hasTracking = $training->implementation_date_from !== null;

                                    // Determine status for current user - simplified to only Implemented or Not yet Implemented
                                    if ($hasPreEvaluation && $hasTracking) {
                                        $userStatus = 'Implemented';
                                    } else {
                                        $userStatus = 'Not yet Implemented';
                                    }
                                @endphp
                                {{ $userStatus }}
                            </td>
                            <td class="text-center">
                                @php
                                    $currentUser = Auth::user();
                                    $userRole = 'Resource Speaker';
                                    if ($currentUser) {
                                        $participant = $training->participants->where('id', $currentUser->id)->first();
                                        if ($participant && isset($participant->pivot->participation_type_id)) {
                                            $participationType = $participationTypes->get($participant->pivot->participation_type_id);
                                            $userRole = $participationType->name ?? 'Resource Speaker';
                                        }
                                    }
                                @endphp
                                {{ $userRole }}
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('user.training.profile.show', $training->id) }}" class="btn btn-info btn-sm">View</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $trainings->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @if($trainings->count())
                <div class="d-flex justify-content-end mt-3 mb-3">
                    <a href="{{ route('user.training.export', $trainings->first()->id) }}" class="btn btn-info">
                        <i class="bi bi-download me-2"></i>Export
                    </a>
                </div>  
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
