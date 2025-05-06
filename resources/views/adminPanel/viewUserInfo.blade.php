<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Training Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f7f8fa;
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
            font-weight: bold;
        }
        .main-content {
            flex-grow: 1;
            padding: 40px 0;
            background-color: rgb(187, 219, 252);
            min-height: calc(100vh - 56px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }
        .details-card {
            max-width: 1040px;
            width: 100%;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 32px 32px 24px 32px;
        }
        .details-title {
            color: #003366;
            font-weight: 700;
            text-align: center;
            margin-bottom: 32px;
        }
        .details-table {
            width: 100%;
        }
        .details-table td {
            padding: 10px 0;
            border-top: none;
            border-bottom: 1px solid #e9ecef;
            vertical-align: top;
        }
        .details-table td.label {
            color: #003366;
            font-weight: 500;
            width: 220px;
        }
        .details-table tr:last-child td {
            border-bottom: none;
        }
        .btn-back {
            background-color: #003366;
            color: #fff;
            border: none;
            padding: 8px 32px;
            border-radius: 4px;
            font-weight: 500;
            margin-bottom: 24px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            align-self: flex-start;
            margin-left: 20px;
        }
        .btn-back:hover {
            background-color: #004080;
            color: #fff;
        }
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
        }
        .btn-edit, .btn-delete {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
        }
        .btn-edit {
            background-color: #4a90e2;
            color: white;
        }
        .btn-edit:hover {
            background-color: #357abd;
            color: white;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c82333;
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
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Training Details</h4>
            <button class="btn btn-outline-primary" onclick="window.history.back()">
                <i class="bi bi-arrow-left"></i> Back
            </button>
        </div>

        <div class="info-card">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Training Information</h5>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Training Title</label>
                        <p>{{ $training->title }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Competency</label>
                        <p>{{ $training->competency->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Period of Implementation</label>
                        <p>{{ $training->implementation_date->format('F d, Y') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Number of Hours</label>
                        <p>{{ $training->no_of_hours }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">Additional Details</h5>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Provider</label>
                        <p>{{ $training->provider }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <p>{{ $training->status }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">User Role</label>
                        <p>{{ $training->user_role }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 