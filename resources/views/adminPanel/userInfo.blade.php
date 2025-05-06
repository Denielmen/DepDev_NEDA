<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEPDEV Learning and Development Database System Region VII</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            padding-top: 56px;
            background-color: rgb(187, 219, 252);
        }
        .navbar {
            background-color: rgb(255, 255, 255);
            padding: 0.5rem 1rem;
            box-shadow: 1px 3px 3px 0px #737373;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
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
            padding: 20px;
        }
        .user-info-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .user-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        .user-avatar i {
            font-size: 3rem;
            color: #6c757d;
        }
        .form-control {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 8px 12px;
        }
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        .table-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: auto;
            max-height: 400px;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            background-color: #003366;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1;
            text-align: center;
        }
        .table td, .table th {
            padding: 20px;
            vertical-align: middle;
        }
        .table th:nth-child(1), .table td:nth-child(1) {
            min-width: 250px;
        }
        .table th:nth-child(2), .table td:nth-child(2) {
            min-width: 250px;
        }
        .table th:nth-child(3), .table td:nth-child(3),
        .table th:nth-child(4), .table td:nth-child(4),
        .table th:nth-child(5), .table td:nth-child(5),
        .table th:nth-child(6), .table td:nth-child(6),
        .table th:nth-child(7), .table td:nth-child(7),
        .table th:nth-child(8), .table td:nth-child(8),
        .table th:nth-child(9), .table td:nth-child(9) {
            min-width: 120px;
        }
        .program-tabs {
            margin-bottom: 5px;
        }
        .program-tabs .nav-link {
            color: #d6d3d3 !important;
            /* background-color: white; */
            /* border: 1px solid #003366; */
            margin-right: 5px;
            border-radius: 5px;
            color: #003366 !important;
            background-color: white;

        }
        /* .program-tabs .nav-link:hover {
            color: #003366 !important;
            background-color: white;
        } */
        .program-tabs .nav-link.active {
            background-color: #003366;
            color: white !important;
            font-weight: bold;
        }
        .btn-outline-primary {
            color: #003366;
            border-color: #003366;
        }
        .btn-outline-primary:hover {
            background-color: #003366;
            color: white;
        }
        .back-button {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .user-info-card.text-center {
            padding: 25px 20px;
        }
        .user-info-card h4 {
            margin-bottom: 8px;
            font-size: 1.4rem;
        }
        .user-info-card p {
            font-size: 0.95rem;
            line-height: 1.4;
        }
        .user-avatar {
            margin-bottom: 20px;
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
        <a href="{{ route('admin.participants') }}" class="active"><i class="bi bi-people me-2"></i>Employee's Profile</a>
        <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <button class="btn btn-outline-primary" onclick="window.location.href='{{ route('admin.participants') }}'">
                <i class="fas fa-arrow-left"></i> Back
            </button>
        </div>

        <div class="row">
            <!-- User Info Card -->
            <div class="col-md-4">
                <div class="user-info-card text-center">
                    <div class="user-avatar">
                        <i class="fas fa-user fa-3x text-secondary"></i>
                    </div>
                    <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                    <p class="text-muted mb-0">ID: {{ $user->user_id }}</p>
                    <p class="text-muted mb-0">{{ $user->position }}</p>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="col-md-8">
                <div class="user-info-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Basic Information</h5>
                        <a href="" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Salary Grade</label>
                            <input type="text" class="form-control" value="{{ $user->salary_grade }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Years in CSC</label>
                            <input type="text" class="form-control" value="{{ $user->years_in_csc }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Division</label>
                        <input type="text" class="form-control" value="{{ $user->division }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Office/Department</label>
                        <input type="text" class="form-control" value="{{ $user->office }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name of Superior (Last, First, MI)</label>
                        <input type="text" class="form-control" value="{{ $user->superior }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Program Tabs -->
        <div class="program-tabs">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin.participants.info', ['id' => $user->id]) }}">Programmed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.participants.info.unprogrammed', ['id' => $user->id]) }}">Unprogrammed</a>
                </li>
            </ul>
        </div>

        <!-- Scrollable Table -->
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Training Title</th>
                        <th>Competency</th>
                        <th>Period of Implementation</th>
                        <th>No. of Hours</th>
                        <th>Provider</th>
                        <th>Status</th>
                        <th>User Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programmedTrainings as $training)
                    <tr>
                        <td>{{ $training->title }}</td>
                        <td>{{ $training->competency }}</td>
                        <td>{{ $training->implementation_date->format('m/d/y') }}</td>
                        <td>{{ $training->no_of_hours }}</td>
                        <td>{{ $training->provider }}</td>
                        <td>{{ $training->status }}</td>
                        <td>{{ $training->user_role }}</td>
                        <td>
                            <a href="{{ route('admin.viewUserInfo', ['id' => $training->id]) }}" class="btn btn-primary">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
</body>
</html>    