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
            <a href="{{ route('admin.home') }}" class="active"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('admin.training-plan') }}"><i class="bi bi-calendar-check me-2"></i>Training Plan</a>
            <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>List of Participants</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
        </div>

        <div class="flex-grow-1 p-4" style="background: #e9f0fb; min-height: calc(100vh - 56px);">
            <div class="bg-white rounded shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0">Training Reports</h2>
                    <div>
                        <input type="text" class="form-control d-inline-block" placeholder="Search" style="width: 200px;">
                        <button class="btn btn-light border ms-2"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                <div style="overflow-x: auto; max-height: 500px;">
                    <table class="table table-bordered align-middle" style="min-width: 1000px;">
                        <thead>
                            <tr class="text-center align-middle">
                                <th style="background: #003366; color: #fff;">Training Program</th>
                                <th style="background: #003366; color: #fff;">Competency</th>
                                <th style="background: #003366; color: #fff;">CY 2025</th>
                                <th style="background: #003366; color: #fff;">CY 2026</th>
                                <th style="background: #003366; color: #fff;">CY 2027</th>
                                <th style="background: #003366; color: #fff;">Provider</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" style="background: #133b6b; color: #fff; font-weight: bold;">I. Foundational/Mandatory</td>
                            </tr>
                            <tr>
                                <td>1. Orientation Course for New NEDAns - Batch 1</td>
                                <td>Core Social Economic Development Planning Advocacy</td>
                                <td>
                                    1. Juan Dela-Cruz<br>
                                    2. John Smith<br>
                                    3. John Doe
                                </td>
                                <td>New Hires in 2025</td>
                                <td>New Hires in 2026</td>
                                <td>NCO</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="background: #133b6b; color: #fff; font-weight: bold;">II. Competency Enhancement</td>
                            </tr>
                            <tr>
                                <td>1. Gross Regional Domestic Product Estimation (GRDPE) Phase 1: Concepts and Classification</td>
                                <td>Functional - Managing Data and Information</td>
                                <td>
                                    1. Juan Dela-Cruz<br>
                                    2. John Smith<br>
                                    3. John Doe
                                </td>
                                <td>
                                    1. Juan Dela-Cruz<br>
                                    2. John Smith<br>
                                    3. John Doe
                                </td>
                                <td>
                                    1. Juan Dela-Cruz<br>
                                    2. John Smith<br>
                                    3. John Doe
                                </td>
                                <td>NCO</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
