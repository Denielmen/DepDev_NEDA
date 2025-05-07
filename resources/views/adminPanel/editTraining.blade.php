{{-- filepath: d:\tests\04-27\DepDev_NEDA\resources\views\adminPanel\editTraining.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Training</title>
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
            position: fixed;
            top: 56px;
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
            background: #f8f9fa;
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
            color: #003366;
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
            <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>Employee's Profile</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 main-content p-4" style="margin-top: 56px;">
            <div class="mb-4 training-header">
                <h2 class="mb-0">Edit Training</h2>
            </div>
            <div class="training-card">
                <h4 class="text-center mb-4">Training Information</h4>
                <form action="{{ route('admin.training-plan.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $training->id }}">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title/Area:</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $training->title }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="competency" class="form-label">Competency:</label>
                            <input type="text" class="form-control" id="competency" name="competency" value="{{ $training->competency }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="core_competency" class="form-label">Core Competency:</label>
                            <select class="form-control" id="core_competency" name="core_competency" required>
                                <option value="">Select Core Competency...</option>
                                <option value="Foundational/Mandatory" {{ $training->core_competency === 'Foundational/Mandatory' ? 'selected' : '' }}>Foundational/Mandatory</option>
                                <option value="Competency Enhancement" {{ $training->core_competency === 'Competency Enhancement' ? 'selected' : '' }}>Competency Enhancement</option>
                                <option value="Leadership/Executive Development" {{ $training->core_competency === 'Leadership/Executive Development' ? 'selected' : '' }}>Leadership/Executive Development</option>
                                <option value="Gender and Development (GAD)-Related" {{ $training->core_competency === 'Gender and Development (GAD)-Related' ? 'selected' : '' }}>Gender and Development (GAD)-Related</option>
                                <option value="Others" {{ $training->core_competency === 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="year" class="form-label">Year of Implementation:</label>
                            <input type="date" class="form-control" id="year" name="year" value="{{ $training->year }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="budget" class="form-label">Budget (per hour):</label>
                            <input type="number" class="form-control" id="budget" name="budget" value="{{ $training->budget }}">
                        </div>
                        <div class="col-md-6">
                            <label for="hours" class="form-label">No. of Hours:</label>
                            <input type="number" class="form-control" id="hours" name="hours" value="{{ $training->hours }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="provider" class="form-label">Learning Service Provider:</label>
                            <input type="text" class="form-control" id="provider" name="provider" value="{{ $training->provider }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="dev_target" class="form-label">Development Target:</label>
                        <textarea class="form-control" id="dev_target" name="dev_target" rows="2">{{ $training->dev_target }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="performance_goal" class="form-label">Performance Goal this Supports:</label>
                        <textarea class="form-control" id="performance_goal" name="performance_goal" rows="2">{{ $training->performance_goal }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="objective" class="form-label">Objective:</label>
                        <textarea class="form-control" id="objective" name="objective" rows="2">{{ $training->objective }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="Program" {{ $training->type === 'Program' ? 'selected' : '' }}>Program</option>
                            <option value="Unprogrammed" {{ $training->type === 'Unprogrammed' ? 'selected' : '' }}>Unprogrammed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="participation_type" class="form-label">Participation Type</label>
                        <select class="form-control" id="participation_type" name="participation_type" required>
                            <option value="Resource Person" {{ $training->participation_type === 'Resource Person' ? 'selected' : '' }}>Resource Person</option>
                            <option value="Participant" {{ $training->participation_type === 'Participant' ? 'selected' : '' }}>Participant</option>
                        </select>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('admin.training-plan') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>