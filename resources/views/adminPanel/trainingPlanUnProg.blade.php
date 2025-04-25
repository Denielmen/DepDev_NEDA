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

        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
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
        }
        .search-container {
            margin-left: 55rem;
            justify-content: space-between;
            align-items: center;
            /* margin-bottom: 5px; */
        }
        .search-box {
            width: 300px;
            padding: 8px 15px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            background-color: white;
        }
        .btn-create {
            background-color: #003366;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .btn-create:hover {
            background-color: #004080;
            color: white;
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
        .btn-view {
            background-color: #4a90e2;
            color: white;
            padding: 5px 15px;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        .btn-view:hover {
            background-color: #357abd;
            color: white;
        }
        .dropdown-toggle::after {
            display: none;
        }
        .tab-buttons {
            margin-bottom: 10px;
        }
        .tab-button {
            background-color: transparent;
            border: none;
            padding: 10px 20px;
            font-weight: 500;
            color: #666;
        }
        .tab-button.active {
            background-color: #003366;
            color: white;
            border-radius: 5px;
        }
        /* .main-content {
            flex-grow: 1;
            background-image: url('/images/neda-building.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 10vh;
        }
        .header {
            padding: 1rem;
            text-align: center;
            background-color: #f8f9fa;
            opacity: 0.7;
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
        } */
        /* .menu-cards::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        } */
        /* .flex {
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
            box-shadow: -19px 1px 4px 1px #003366;
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
        } */
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
            <a href="#"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="#"><i class="bi bi-calendar-check me-2"></i>Training Plan</a>
            <a href="#"><i class="bi bi-people me-2"></i>List of Participants</a>
            <a href="#"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-header">
                <h2>List of Training Plans</h2>
            </div>

            <div class="search-container">
                <input type="text" class="search-box" placeholder="Search...">
                {{-- <a href="#" class="btn btn-create">
                    <i class="bi bi-plus-circle"></i>
                    Create New
                </a> --}}
            </div>

            <div class="tab-buttons">
                <button class="tab-button ">Program</button>
                <button class="tab-button active">Unprogrammed</button>
            </div>

            <div class="training-table">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Training Title</th>
                            <th>Competency</th>
                            <th>Period of Implementation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Orientation Course for...</td>
                            <td>Core- Socio-Economic,...</td>
                            <td>07/25/22</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-view">View</button>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Orientation Course for...</td>
                            <td>Core- Socio-Economic,...</td>
                            <td>08/26/23</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-view">View</button>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
