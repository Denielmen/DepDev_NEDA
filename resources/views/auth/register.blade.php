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
            background-color: #f8f9fa;
        }
        .sidebar {
            background-color: #003366;
            min-height: 100vh;
            width: 270px;
            padding-top: 20px;
            position: fixed;
            top: 56px; /* Adjust for the height of the fixed navbar */
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
        .main-content {
            margin-left: 270px;
            padding: 20px;
            margin-top: 50px; 
            background-color: rgb(187, 219, 252);
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
        .form-group-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .form-group-row .form-control {
            flex: 1;
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/neda-logo.png" alt="NEDA Logo" style="height: 30px;">
                DEPDEV Learning and Development System
            </a>
            <div class="d-flex align-items-center">
                <i class="bi bi-bell-fill me-3 text-secondary"></i>
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        Guest
                        <i class="bi bi-chevron-down ms-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#"><i class="bi bi-house-door me-2"></i>Home</a>
        <a href="#"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
        <a href="#"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
        <a href="#"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
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
                <div class="form-group-row">
                    <div>
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                    </div>
                    <div>
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                    </div>
                    <div>
                        <label for="mid_init" class="form-label">Middle Initial</label>
                        <input type="text" id="mid_init" name="mid_init" class="form-control" value="{{ old('mid_init') }}">
                    </div>
                </div>

                <!-- Position and Office -->
                <div class="form-group-row">
                    <div>
                        <label for="position" class="form-label">Position</label>
                        <input type="text" id="position" name="position" class="form-control" value="{{ old('position') }}" required>
                    </div>
                    <div>
                        <label for="office" class="form-label">Office</label>
                        <input type="text" id="office" name="office" class="form-control" value="{{ old('office') }}" required>
                    </div>
                </div>

                <!-- Years in Position and CSC -->
                <div class="form-group-row">
                    <div>
                        <label for="years_in_position" class="form-label">Years in Position</label>
                        <input type="number" id="years_in_position" name="years_in_position" class="form-control" value="{{ old('years_in_position') }}" required>
                    </div>
                    <div>
                        <label for="years_in_csc" class="form-label">Years in CSC</label>
                        <input type="number" id="years_in_csc" name="years_in_csc" class="form-control" value="{{ old('years_in_csc') }}" required>
                    </div>
                </div>

                <!-- Division and Salary Grade -->
                <div class="form-group-row">
                    <div>
                        <label for="division" class="form-label">Division</label>
                        <input type="text" id="division" name="division" class="form-control" value="{{ old('division') }}" required>
                    </div>
                    <div>
                        <label for="salary_grade" class="form-label">Salary Grade</label>
                        <input type="number" id="salary_grade" name="salary_grade" class="form-control" value="{{ old('salary_grade') }}" required>
                    </div>
                </div>

                <!-- Role and Superior -->
                <div class="form-group-row">
                    <div>
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-control">
                            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div>
                        <label for="superior" class="form-label">Superior</label>
                        <input type="text" id="superior" name="superior" class="form-control" value="{{ old('superior') }}" placeholder="Lastname, Firstname, MI">
                    </div>
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