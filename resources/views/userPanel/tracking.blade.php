<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Status Learning and Development Intervention</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color:rgb(255, 255, 255);
            padding: 0.5rem 1rem;
            box-shadow: 1px 3px 3px 0px #737373;
        }
        .navbar-brand {
            color:  #003366 !important;
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
            width: 255px;
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
        }
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .back-button {
            text-decoration: none;
            color: #003366;
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .back-button:hover {
            color: #004080;
        }
        .form-title {
            background-color: #e6f3ff;
            padding: 15px;
            margin: -20px -20px 20px -20px;
            border-radius: 8px 8px 0 0;
            color: #003366;
            font-size: 1.2rem;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .form-control {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 0.5rem;
        }
        .date-range {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .upload-box {
            border: 2px dashed #ced4da;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }
        .upload-box:hover {
            border-color: #003366;
        }
        .btn-save {
            background-color: #003366;
            color: white;
            padding: 8px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-save:hover {
            background-color: #004080;
        }
        .text-muted {
            color: #6c757d;
            font-size: 0.8rem;
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
            <a href="#"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="#"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="#" class="active"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
            <a href="#"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <a href="#" class="back-button">
                <i class="bi bi-arrow-left me-2"></i>
                Back
            </a>

            <div class="form-container">
                <div class="form-title">
                    Status Learning and Development Intervention
                </div>

                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label">Title of Training:</label>
                            <input type="text" class="form-control" name="training_title" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label">Competency:</label>
                            <input type="text" class="form-control" name="competency" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="form-label">No. of Hours:</label>
                            <input type="text" class="form-control" name="hours" placeholder="1000hrs" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="form-label">Actual Expenses:</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" class="form-control" name="expenses" required>
                            </div>
                        </div> 
                        <div class="col-md-4 form-group">
                            <label class="form-label">Date of Attendance:</label>
                            <div class="date-range">
                                <input type="date" class="form-control" name="date_from" id="date_from" required onchange="updateDateTo()">
                                <span>To:</span>
                                <input type="date" class="form-control" name="date_to" id="date_to" required readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Conducted/Sponsored by/Learning Services Provider:</label>
                        <input type="text" class="form-control" name="provider" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Upload Learning Materials, etc...</label>
                        <div class="upload-box">
                            <i class="bi bi-upload mb-2"></i>
                            <div>Upload Files</div>
                            <small class="text-muted">Ex. JPEG, PNG, GIF and etc.</small>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn-save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateDateTo() {
            const dateFromInput = document.getElementById('date_from');
            const dateToInput = document.getElementById('date_to');
            
            if (dateFromInput.value) {
                const dateFrom = new Date(dateFromInput.value);
                const dateTo = new Date(dateFrom);
                dateTo.setFullYear(dateFrom.getFullYear() + 3);
                
                // Format the date to YYYY-MM-DD
                const formattedDate = dateTo.toISOString().split('T')[0];
                dateToInput.value = formattedDate;
            } else {
                dateToInput.value = '';
            }
        }
    </script>
</body>
</html> 