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
        .nav-link, .user-icon, .user-menu {
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
            background-image: url('/images/neda-building.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 92vh;
        }
        .header {
            padding: 1rem;
            text-align: center;
            background-color: #f8f9fa;
            opacity: 0.7;
            margin-left: 270px;
            margin-right: 0%;
        }
        .header img {
            width: 50px;
            margin-bottom: 0.5rem;
        }
        .pic {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 300px;
           
            
        }
        .header h1 {
            color: #003366;
            font-size: 1.2rem;
            margin: 0;
            font-weight: bold;
        }
        .header p {
            color: bold, black;
            font-size: 0.9rem;
            margin-top: 1rem;
        }
        .menu-cards {
            padding: 4rem;
            position: relative;
            margin-left: 270px; /* Adjusted to account for the sidebar width */
            margin-right: 0;
        }
        /* .menu-cards::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        } */
        .flex {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
        }
        .card {
            background-color: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0px -7px 1px 0px #003366;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h5 {
            color: #003366;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .card p {
            color: #666;
            font-size: 0.9rem;
            margin: 0;
        }
        .user-menu {
            color: white;
            cursor: pointer;
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
            <a href="{{ route('admin.home') }}" class="active"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('admin.training-plan') }}"><i class="bi bi-calendar-check me-2"></i>Training Plan</a>
            <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>Employee's Profile</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="pic">
                <img src="/images/neda-logo.png" alt="NEDA Logo">
                <img src="/images/repub.png" alt="NEDA Logo">
                </div>
                <h1>REPUBLIC OF THE PHILIPPINES</h1>
                <h1>DEPARTMENT OF ECONOMY, PLANNING, AND DEVELOPMENT.</h1>
                <p>Please select a course from the menu to begin your learning and development journey.</p>
            </div>

            <div class="menu-cards">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="flex">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <a href="{{ route('admin.training-plan') }}" class="text-decoration-none">
                                    <h5>Training Plan</h5>
                                    <p>Evaluate the effectiveness of completed training progress.</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <a href="{{ route('admin.participants')}}" class="text-decoration-none">
                                    <h5>List of Participants</h5>
                                    <p>View and plan learning activities aligned with your role.</p>
                                </a>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <a href="{{ route('admin.reports')}}" class="text-decoration-none">
                                    <h5>Reports</h5>
                                    <p>Track your learning and development progress.</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
