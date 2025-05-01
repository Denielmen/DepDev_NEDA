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
        .sidebar a:hover, .sidebar a.active {
            background-color: #004080;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
            background-color: rgb(187, 219, 252);   
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
            width: 300px;
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
            <a href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('training.profile') }}" class="active"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="{{ route('tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
            <a href="{{ route('training.effectivenesss') }}"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-header">
                <h2>List Of Training Plans</h2>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="tab-buttons">
                    <a href="{{ route('training.profile.program') }}" class="tab-button">Program</a>
                    <a href="{{ route('training.profile.unprogrammed') }}" class="tab-button active">Unprogrammed</a>
                </div>
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <i class="bi bi-search search-icon"></i>
                </div>
            </div>

            <div class="training-table">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="background-color: #003366; color: white; border-right: 2px solid white;">Training Title</th>
                            <th style="background-color: #003366; color: white; border-right: 2px solid white;">Competency</th>
                            <th style="background-color: #003366; color: white; border-right: 2px solid white;">Period of Implementation</th>
                            <th style="background-color: #003366; color: white; border-right: 2px solid white;">Provider</th>
                            <th style="background-color: #003366; color: white; border-right: 2px solid white;">Status</th>
                            <th colspan="2" style="background-color: #003366; color: white; text-align: center; border-right: 2px solid white;">Participant Ratings</th>
                            <th colspan="2" style="background-color: #003366; color: white; text-align: center;">Supervisor Ratings</th>
                        </tr>
                        <tr>
                            <th colspan="5"></th>
                            <th style="background-color: #004080; color: white; text-align: center; border: 1px solid #003366; border-right: 2px solid white; border-left: 2px solid white;">Pre</th>
                            <th style="background-color: #004080; color: white; text-align: center; border: 1px solid #003366; border-right: 2px solid white;">Post</th>
                            <th style="background-color: #004080; color: white; text-align: center; border: 1px solid #003366; border-right: 2px solid white;">Pre</th>
                            <th style="background-color: #004080; color: white; text-align: center; border: 1px solid #003366;">Post</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Project Management Fundamentals</td>
                            <td>Project Management</td>
                            <td>12/15/23</td>
                            <td>PMI Philippines</td>
                            <td>Implemented</td>
                            <td class="text-center">3.00</td>
                            <td class="text-center">4.00</td>
                            <td class="text-center">3.25</td>
                            <td class="text-center">4.25</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html></html>