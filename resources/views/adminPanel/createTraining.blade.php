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
            position: fixed;
            top: 56px;  /* to fix the navbar */ 
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
            background-color: rgb(187, 219, 252);
            min-height: calc(100vh - 56px);
            margin-left: 270px;
            width: calc(100% - 270px);
        }
        .training-header {
            background-color: #e7f1ff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .training-header h2 {
            font-size: 1.5rem;
            margin-bottom: 0;
            color: #003366 ;
            font-weight: bold;
        }
        .training-card {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
            padding: 1.5rem;
            max-width: 900px;
            margin: 0 auto;
        }
        .training-card h4 {
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

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="{{ route('admin.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('admin.training-plan') }}" class="active"><i class="bi bi-calendar-check me-2"></i>Training Plan</a>
            <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>List of Participants</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 main-content p-4" style="margin-top: 56px;">
            <div class="mb-4 training-header">
                <h2 class="mb-0">Training Plan</h2>
            </div>
            <div class="training-card">
                <h4 class="text-center mb-4">Training Information</h4>
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title/Area:</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Three-Year Period:</label>
                            <div class="row g-2 align-items-center">
                                <div class="col-auto">
                                    <label for="from" class="form-label mb-0">From:</label>
                                </div>
                                <div class="col-auto">
                                    <input type="text" class="form-control" id="from" name="from" style="width: 80px;">
                                </div>
                                <div class="col-auto">
                                    <label for="to" class="form-label mb-0">To:</label>
                                </div>
                                <div class="col-auto">
                                    <input type="text" class="form-control" id="to" name="to" style="width: 80px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="competency" class="form-label">Competency:</label>
                            <input type="text" class="form-control" id="competency" name="competency">
                        </div>
                        <div class="col-md-6">
                            <label for="year" class="form-label">Year of Implementation:</label>
                            <input type="date" class="form-control" id="year" name="year" min="2020-01-01" max="2100-12-31" onfocus="this.showPicker && this.showPicker();">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="budget" class="form-label">Budget (per hour):</label>
                            <input type="text" class="form-control" id="budget" name="budget">
                        </div>
                        <div class="col-md-6">
                            <label for="hours" class="form-label">No. of Hours:</label>
                            <input type="text" class="form-control" id="hours" name="hours">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="superior" class="form-label">Superior:</label>
                            <input type="text" class="form-control" id="superior" name="superior" placeholder="Last, First, MI">
                        </div>
                        <div class="col-md-6">
                            <label for="provider" class="form-label">Learning Service Provider:</label>
                            <input type="text" class="form-control" id="provider" name="provider">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="dev_target" class="form-label">Development Target:</label>
                        <textarea class="form-control" id="dev_target" name="dev_target" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="performance_goal" class="form-label">Performances Goal this Support:</label>
                        <textarea class="form-control" id="performance_goal" name="performance_goal" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="objective" class="form-label">Objective:</label>
                        <textarea class="form-control" id="objective" name="objective" rows="2"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Participant</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
