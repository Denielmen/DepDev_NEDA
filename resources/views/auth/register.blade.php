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
            background-color: rgb(187, 219, 252);
            padding-top: 60px; /* Adjust this value based on your navbar height */
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
            margin-top: 36px;
            padding-bottom: 20px;
        }
        .register-container {
            max-width: 800px;
            margin: 2rem auto;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .header h1 {
            font-size: 1.8rem;
            color: #003366;
            font-weight: bold;
        }
        .header p {
            font-size: 0.9rem;
            color: #666;
        }
        .btn-register {
            background-color: #003366;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            width: 100%;
        }
        .btn-register:hover {
            background-color: #004080;
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
            <a href="{{ route('admin.training-plan') }}"><i class="bi bi-calendar-check me-2"></i>Training Plan</a>
            <a href="{{ route('admin.participants') }}" class="active"><i class="bi bi-people me-2"></i>Employee's Profile</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
        </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Registration Form Container -->
        <div class="register-container">
            <!-- Header -->
            <div class="header">
                <h1>DEPDEV Learning and Development System</h1>
                <p>Register a new account to access the system.</p>
            </div>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name Fields -->
                <div class="row mb-3">
                    <div class="col">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                    </div>
                    <div class="col">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                    </div>
                    <div class="col">
                        <label for="mid_init" class="form-label">Middle Initial</label>
                        <input type="text" id="mid_init" name="mid_init" class="form-control" value="{{ old('mid_init') }}">
                    </div>
                </div>

                <!-- Position -->
                <div class="row mb-3">
                    <div class="col">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" id="position" name="position" class="form-control" value="{{ old('position') }}" required>
                    </div>
                </div>

                <!-- Years in Position and CSC -->
                <div class="row mb-3">
                    <div class="col">
                        <label for="years_in_position" class="form-label">Years in Position</label>
                        <input type="number" id="years_in_position" name="years_in_position" class="form-control" value="{{ old('years_in_position') }}" required>
                    </div>
                    <div class="col">
                        <label for="years_in_csc" class="form-label">Years in Goverment</label>
                        <input type="number" id="years_in_csc" name="years_in_csc" class="form-control" value="{{ old('years_in_csc') }}" required>
                    </div>
                </div>

                <!-- Division and Salary Grade -->
                <div class="row mb-3">
                    <div class="col">
                        <label for="division" class="form-label">Division/Unit</label>
                        <input type="text" id="division" name="division" class="form-control" value="{{ old('division') }}" required>
                    </div>
                    <div class="col">
                        <label for="salary_grade" class="form-label">Salary Grade</label>
                        <input type="number" id="salary_grade" name="salary_grade" class="form-control" value="{{ old('salary_grade') }}" required>
                    </div>
                </div>

                <!-- Role and Superior -->
                <div class="row mb-3">
                    <div class="col">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-control" required>
                            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="superior" class="form-label">Name Of Immediate Supervisor</label>
                        <select id="superior" name="superior" class="form-control">
                            <option value="">None</option>
                            @foreach(App\Models\User::getSuperiors() as $superior)
                                <option value="{{ $superior->full_name }}" {{ old('superior') == $superior->full_name ? 'selected' : '' }}>
                                    {{ $superior->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Superior Eligibility -->
                <div class="row mb-3">
                    <div class="col">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_superior_eligible" name="is_superior_eligible" value="1" {{ old('is_superior_eligible') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_superior_eligible">Eligible for Superior Position</label>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-register">Register</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>