<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Training Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f7f8fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
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
            font-weight: bold;
        }
        .main-content {
            flex-grow: 1;
            padding: 40px 0;
            background-color: rgb(187, 219, 252);
            min-height: calc(100vh - 56px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }
        .details-card {
            max-width: 1040px;
            width: 100%;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 32px 32px 24px 32px;
        }
        .details-title {
            color: #003366;
            font-weight: 700;
            text-align: center;
            margin-bottom: 32px;
        }
        .details-table {
            width: 100%;
        }
        .details-table td {
            padding: 10px 0;
            border-top: none;
            border-bottom: 1px solid #e9ecef;
            vertical-align: top;
        }
        .details-table td.label {
            color: #003366;
            font-weight: 500;
            width: 220px;
        }
        .details-table tr:last-child td {
            border-bottom: none;
        }
        .btn-back, .btn-eval {
            background-color: #003366;
            color: #fff;
            border: none;
            padding: 8px 32px;
            border-radius: 4px;
            font-weight: 500;
            margin-top: 24px;
            text-decoration: none;
        }
        .btn-back:hover, .btn-eval:hover {
            background-color: #004080;
            color: #fff;
        }
        .btn-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
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
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/DEPDev_logo.png" alt="NEDA Logo">
                DEPDEV Learning and Development Database System Region VII
            </a>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown" style="cursor:pointer;">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->last_name ?? 'User' }}
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
        <div class="sidebar">
            <a href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('training.profile') }}" class="active"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="{{ route('tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
            <a href="{{ route('training.effectivenesss') }}"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
            <a href="{{ route('training.resources') }}"><i class="bi bi-archive me-2"></i>Training Resources</a>
        </div>
        <!-- Main Content -->
        <div class="main-content">
            <div class="details-card">
                <h2 class="details-title">Training Details</h2>
                <table class="details-table">
                    <tr>
                        <td class="label">Title/Area:</td>
                        <td>{{ $training->title ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Three-Year Period:</td>
                        <td>From: {{ $training->period_from ?? '' }} To: {{ $training->period_to ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Competency:</td>
                        <td>{{ $training->competency ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Year of Implementation:</td>
                        <td>{{ $training->implementation_date ? $training->implementation_date->format('m/d/Y') : '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Budget (per hour):</td>
                        <td>{{ $training->budget ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">No. of Hours:</td>
                        <td>{{ $training->no_of_hours ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">User Role:</td>
                        <td>{{ isset($user) ? $user->user_role : 'Participant' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Superior:</td>
                        <td>{{ $training->superior ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Learning Service Provider:</td>
                        <td>{{ $training->provider ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Development Target:</td>
                        <td>{{ $training->development_target ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Performance Goal this Support:</td>
                        <td>{{ $training->performance_goal ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Objective:</td>
                        <td>{{ $training->objective ?? '' }}</td>
                    </tr>
                    @if($training->type === 'Program')
                    <tr>
                        <td class="label">Participant Pre Rating:</td>
                        <td>{{ $training->participant_pre_rating ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Participant Post Rating:</td>
                        <td>{{ $training->participant_post_rating ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Supervisor Pre Rating:</td>
                        <td>{{ $training->supervisor_pre_rating ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Supervisor Post Rating:</td>
                        <td>{{ $training->supervisor_post_rating ?? '' }}</td>
                    </tr>
                    @endif
                </table>
                <div class="btn-row">
                    <a href="{{ route('training.profile.program') }}" class="btn btn-back">Back</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 