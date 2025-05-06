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
            padding-top: 60px; /* Adjust this value based on your navbar height */
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
            position: fixed;
            left: 0;
            top: 56px;
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
            background: #e9f0fb; 
            min-height: calc(100vh - 56px);
            margin-left: 270px; /* Match sidebar width */
            width: calc(100% - 270px);
            background-color: rgb(187, 219, 252);
        }
        .content-card {
            background-color: white;
            border-radius: 0.25rem;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
            padding: 1.5rem;
        }
        .content-card h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #003366;
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
        }
        .search-box .search-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .table-container {
            overflow-x: auto; 
            max-height: 500px;
        }
        .training-table {
            min-width: 1000px;
        }
        .table-header {
            background: #002e67 !important; 
            color: #fff !important; 
            font-weight: bold;
            
        }
        .category-header {
            background: #133b6b !important; 
            color: #fff  !important; 
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
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
                        Admin
                        <i class="bi bi-chevron-down ms-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="{{ route('admin.home') }}" ><i class="bi bi-house-door me-2"></i>Home</a>
        <a href="{{ route('admin.training-plan') }}"><i class="bi bi-calendar-check me-2"></i>Training Plan</a>
        <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>Employee's Profile</a>
        <a href="{{ route('admin.reports') }}" class="active"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
    </div>

    <!-- Main Content -->
    <div class="main-content p-4">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Training Reports</h2>
                <div class="search-box">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" placeholder="Search...">
                </div>
            </div>
            <div class="table-container">
                <table class="table table-bordered align-middle training-table">
                    <thead>
                        <tr class="text-center align-middle">
                            <th class="table-header">Training Program</th>
                            <th class="table-header">Competency</th>
                            <th class="table-header">CY 2025</th>
                            <th class="table-header">CY 2026</th>
                            <th class="table-header">CY 2027</th>
                            <th class="table-header">Provider</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainings as $category => $categoryTrainings)
                            <tr>
                                <td colspan="6" class="category-header">{{ $category }}</td>
                            </tr>
                            @foreach($categoryTrainings as $training)
                                <tr>
                                    <td>{{ $training->title }}</td>
                                    <td>{{ $training->competency }}</td>
                                    <td>
                                        @foreach($training->participants_2025 as $participant)
                                            {{ $loop->iteration }}. {{ $participant->name }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($training->participants_2026 as $participant)
                                            {{ $loop->iteration }}. {{ $participant->name }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($training->participants_2027 as $participant)
                                            {{ $loop->iteration }}. {{ $participant->name }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $training->provider }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
