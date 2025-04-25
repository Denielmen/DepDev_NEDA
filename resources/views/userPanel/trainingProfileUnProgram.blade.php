<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Training Profile - Unprogrammed</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: rgb(255, 255, 255);
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
            min-height: calc(100vh - 56px);
            width: 270px;
            padding-top: 20px;
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
        }
        .main-content {
            flex-grow: 1;
            padding: 20px 30px;
            background-color: white;
        }
        .content-header {
            margin-bottom: 25px;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 10px;
        }
        .content-header h2 {
            color: #003366;
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }
        .search-box {
            max-width: 300px;
            margin-bottom: 25px;
            margin-left: 70rem;
        }
        .search-box .input-group {
            border: 1px solid #ced4da;
            border-radius: 4px;
            overflow: hidden;
        }
        .search-box .form-control {
            border: none;
            box-shadow: none;
            font-size: 0.9rem;
        }
        .search-box .btn {
            border: none;
            background-color: #f8f9fa;
            color: #6c757d;
        }
        .search-box .btn:hover {
            background-color: #e9ecef;
            color: #003366;
        }
        .program-section {
            margin-bottom: 20px;
        }
        .program-header {
            background-color: #003366;
            color: white;
            padding: 8px 15px;
            display: inline-block;
            font-weight: 500;
            border-radius: 4px 0 0 4px;
        }
        .program-value {
            display: inline-block;
            padding: 8px 15px;
            font-weight: 500;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-left: none;
            border-radius: 0 4px 4px 0;
        }
        .table-responsive {
            border: 1px solid #dee2e6;
            border-radius: 4px;
            overflow: hidden;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            background-color: #f8f9fa;
            color: #003366;
            font-weight: 600;
            border: 1px solid #dee2e6;
            padding: 10px;
            font-size: 0.9rem;
            white-space: nowrap;
        }
        .table td {
            padding: 10px;
            border: 1px solid #dee2e6;
            font-size: 0.9rem;
            vertical-align: middle;
        }
        .table thead tr:first-child th {
            border-top: none;
        }
        .table thead tr:last-child th {
            border-bottom: 2px solid #dee2e6;
        }
        .status-implemented {
            color: #28a745;
            font-weight: 500;
        }
        .border-end {
            border-right: 2px solid #dee2e6 !important;
        }
        .ratings-section th {
            text-align: center;
            background-color: #f8f9fa;
        }
        .empty-cell {
            background-color: #f8f9fa;
            border-left: none !important;
            border-right: none !important;
        }
        .program-tabs {
            margin-bottom: 20px;
        }
        .program-tab {
            background-color: #fff;
            border: 1px solid #dee2e6;
            color: #003366;
            padding: 8px 20px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
            min-width: 120px;
            text-align: center;
        }
        .program-tab:first-child {
            border-radius: 4px 0 0 4px;
        }
        .program-tab:last-child {
            border-radius: 0 4px 4px 0;
            border-left: none;
        }
        .program-tab.active {
            background-color: #003366;
            color: white;
            border-color: #003366;
            text-decoration: none;
        }
        .program-tab:hover:not(.active) {
            background-color: #f8f9fa;
            text-decoration: none;
            color: #003366;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/neda-logo.png" alt="NEDA Logo">
                DEPDEV Learning and Development Database System Region VII
            </a>
            <div class="d-flex align-items-center">
                <i class="bi bi-bell-fill me-3 user-icon"></i>
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        User
                        <i class="bi bi-chevron-down ms-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="{{ url('/') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('training.profile') }}" class="active"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="{{ route('tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
            <a href="#"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-header">
                <h2>List Of Training Plans</h2>
            </div>

            <div class="search-box">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search...">
                    <button class="btn" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>

            <div class="program-tabs">
                <a href="{{ route('training.profile.program') }}" class="program-tab">Program</a>
                <a href="{{ route('training.profile.unprogrammed') }}" class="program-tab active">Unprogrammed</a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="min-width: 200px;">Training Title</th>
                            <th style="min-width: 150px;">Competency</th>
                            <th style="min-width: 150px;">Period of Implementation</th>
                            <th style="min-width: 150px;">Provider</th>
                            <th style="min-width: 120px;">Status</th>
                            <th colspan="4" class="text-center" style="min-width: 400px;">Ratings</th>
                        </tr>
                        <tr>
                            <th colspan="5" class="empty-cell"></th>
                            <th colspan="2" class="text-center border-end">Participant</th>
                            <th colspan="2" class="text-center">Supervisor</th>
                        </tr>
                        <tr>
                            <th colspan="5" class="empty-cell"></th>
                            <th class="text-center">Pre</th>
                            <th class="text-center border-end">Post</th>
                            <th class="text-center">Pre</th>
                            <th class="text-center">Post</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainings as $training)
                        <tr>
                            <td>{{ $training->title }}</td>
                            <td>{{ $training->competency }}</td>
                            <td>{{ $training->implementation_date->format('m/d/y') }}</td>
                            <td>{{ $training->provider }}</td>
                            <td class="status-implemented">{{ $training->status }}</td>
                            <td class="text-center">{{ $training->participant_pre_rating }}</td>
                            <td class="text-center border-end">{{ $training->participant_post_rating }}</td>
                            <td class="text-center">{{ $training->supervisor_pre_rating }}</td>
                            <td class="text-center">{{ $training->supervisor_post_rating }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>