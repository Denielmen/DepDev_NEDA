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
        .sidebar a:hover {
            background-color: #004080;
        }
        .sidebar a.active {
            background-color: #004080;
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

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="{{ route('admin.home') }}" class="{{ Route::is('admin.home') ? 'active' : '' }}">
                <i class="bi bi-house-door me-2"></i>Home
            </a>
            <a href="{{ route('admin.training-plan') }}" class="{{ Route::is('admin.training-plan') ? 'active' : '' }}">
                <i class="bi bi-calendar-check me-2"></i>Training Plan
            </a>
            <a href="{{ route('admin.listOfUsers') }}" class="{{ Route::is('admin.listOfUsers') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i>List of Participants
            </a>
            <a href="{{ route('admin.report') }}" class="{{ Route::is('admin.report') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text me-2"></i>Reports
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content" style="padding: 20px; flex-grow: 1;">
            <div class="table-container" style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <h2 style="margin-bottom: 20px;">List of Staffs</h2>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>User ID</th>
                            <th>Position</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->position }}</td>
                                <td>
                                    <a href="{{ route('admin.editUser', $user->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    @if ($user->is_active)
                                        <a href="{{ route('admin.disableUser', $user->id) }}" class="btn btn-secondary btn-sm">
                                            <i class="bi bi-toggle-off"></i> Disable
                                        </a>
                                    @else
                                        <a href="{{ route('admin.enableUser', $user->id) }}" class="btn btn-success btn-sm">
                                            <i class="bi bi-toggle-on"></i> Enable
                                        </a>
                                    @endif
                                </td>
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



