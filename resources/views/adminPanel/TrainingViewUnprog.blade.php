<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DEPDEV Learning and Development System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            padding-top: 60px;
            background-color: rgb(187, 219, 252);
        }
        .navbar {
            background-color: #fff;
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
        .user-icon, .user-menu {
            color: black !important;
        }
        .sidebar {
            background-color: #003366;
            min-height: calc(100vh - 56px);
            width: 270px;
            padding-top: 20px;
            position: fixed;
            top: 56px;      
            left: 0;
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
            padding: 20px;
            background-color: rgb(187, 219, 252);
            margin-left: 270px;
            margin-top: 50px;
            padding-bottom: 20px;

        }
        .details-card {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        .details-title {
            color: #003366;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table tr {
            border-bottom: 1px solid #dee2e6;
        }
        .details-table td {
            padding: 12px 15px;
        }
        .details-table .label {
            width: 200px;
            font-weight: 500;
            color: #003366;
        }
        .btn-back {
            background-color: #003366;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .btn-back:hover {
            background-color: #004080;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.home') }}">
                <img src="/images/neda-logo.png" alt="NEDA Logo">
                DEPDEV Learning and Development Database System Region VII
            </a>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        Admin
                        <i class="bi bi-chevron-down ms-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="{{ route('admin.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('admin.training-plan') }}" class="active"><i class="bi bi-calendar-check me-2"></i>Training Plan</a>
            <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>Employee's Profile</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
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
                        <td class="label">Competency:</td>
                        <td>{{ $training->competency ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Role:</td>
                        <td>{{ }}</td>
                    </tr>
                    <tr>
                        <td class="label">Year of Implementation:</td>
                        <td>{{ $training->implementation_date ? $training->implementation_date->format('m/d/Y') : '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Learning Service Provider:</td>
                        <td>{{ $training->provider ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Status:</td>
                        <td>{{ $training->status ?? '' }}</td>
                    </tr>
                </table>
                <div class="mt-4">
                    <a href="{{ route('admin.training-plan.unprogrammed') }}" class="btn btn-back">
                        <i class="bi bi-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 