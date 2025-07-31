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
        .nav-link, .user-menu {
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
            margin-left: 270px; 
            margin-right: 0;
        }
        
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
        .dropdown-menu {
            min-width: 200px;
            padding: 0.5rem 0;
            margin: 0.5rem 0 0;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #fff; position: fixed; top: 0; left: 0; width: 100%; z-index: 1040;">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="/images/DEPDev_logo.png" alt="NEDA Logo" style="height: 30px; margin-right: 10px;">
                    <span style="color: #003366; font-size: 1rem; font-weight: bold;">
                        DEPDEV Learning and Development Database System Region VII
                    </span>
                </a>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown" style="cursor:pointer;">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->last_name && auth()->user()->first_name ? auth()->user()->last_name . ', ' . auth()->user()->first_name : (auth()->user()->last_name ?? auth()->user()->first_name ?? 'User') }}
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
        <div class="sidebar" style="top: 56px;">
            <a href="{{ route('user.home') }}" class="active"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('user.training.profile') }}"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="{{ route('user.tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
            <a href="{{ route('user.training.effectiveness') }}"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
            <a href="{{ route('user.training.resources') }}"><i class="bi bi-archive me-2"></i>Training Resources</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="pic">
                    <img src="/images/DEPDev_logo.png" alt="NEDA Logo">
                    <img src="/images/repub.png" alt="NEDA Logo">
                </div>
                <h1>REPUBLIC OF THE PHILIPPINES</h1>
                <h1>DEPARTMENT OF ECONOMY, PLANNING, AND DEVELOPMENT</h1>
                <p>Please select a feature from the menu to begin your learning and development journey.</p>
            </div>

            <div class="menu-cards">
                <div class="container d-flex justify-content-center">
                    <div class="row w-100" style="max-width: 900px;">
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card text-center h-100">
                                <a href="{{ route('user.training.profile.program') }}" class="text-decoration-none">
                                    <h5>Training Profile</h5>
                                    <p>View and plan learning activities aligned with your role.</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card text-center h-100">
                                <a href="{{ route('user.tracking') }}" class="text-decoration-none">
                                    <h5>Training Tracking & History</h5>
                                    <p>Track your learning and development progress.</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card text-center h-100">
                                <a href="{{ route('user.training.effectiveness') }}" class="text-decoration-none">
                                    <h5>Training Effectiveness</h5>
                                    <p>Evaluate the effectiveness of completed trainings.</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card text-center h-100">
                                <a href="{{ route('user.training.resources') }}" class="text-decoration-none">
                                    <h5>Training Resources</h5>
                                    <p>Access to Training Materials.</p>
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
