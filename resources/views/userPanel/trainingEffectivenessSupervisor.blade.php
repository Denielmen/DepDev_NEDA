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
            background-color: rgb(187, 219, 252);

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

        .nav-link,
        .user-icon,
        .user-menu {
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

        .col {
            padding: 20px;
            margin-left: 20px;
            margin-right: 20px;
        }

        .card-body {
            padding: 30px;
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

        .text {
            font-size: 2rem;
            font-weight: bold;
            color: #003366;
            text-align: center;
            margin: 0;
            position: relative;
            top: 10px;
        }

        .text-profLevel {
            font-size: 1rem;
            color: rgb(0, 0, 0);
            text-align: center;
            margin: 0;
            position: relative;

        }

        .mb-3 {
            border-radius: 10px;
            border: 1px solid black;
            background-color: #f8f9fa;
            padding: 20px;
            margin-bottom: 20px;
            margin-top: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .mb-4 {
            border-radius: 10px;
            background-color: #f8f9fa;
        }

        .text-profLevel {
            font-size: 20px;
            color: rgb(0, 0, 0);
            text-align: center;
            margin: 0;
            position: relative;
            bottom: 5px;
        }

        .form-label {
            font-weight: bold;
            color: rgb(0, 0, 0);
            margin-bottom: 0;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid black;
            background-color: #f8f9fa;
        }

        .form-title {
            background-color: #e6f3ff;
            padding: 15px;
            margin: -20px -20px 20px -20px;
            border-radius: 8px 8px 0 0;
            color: #003366;
            font-size: 25px;
            font-weight: bold;
        }

        .back-button {
            text-decoration: none;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
            border-radius: 10px;
            color: #003366;
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .back-button:hover {
            color: #004080;
        }

        .bt {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-left: 20px;
            margin-right: 20px;
        }

        .bold-hr {
            border-top: 3px solid black;
            width: 100%;
            margin: 10px 0;
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
            <a href="{{ route('training.profile') }}"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="{{ route('tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
            <a href="{{ route('training.effectivenesss') }}"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
        </div>
        <!-- Main Content -->
        <div class="main-content">
            <a href="#" class="back-button">
                <i class="bi bi-arrow-left me-2"></i>
                Back
            </a>

            <div class="form-container">
                <div class="form-title">
                    Supervisor
                </div>

                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Proficiency Level Section -->
                    <div class="text-profLevel">Proficiency Level</div>
                    <div class="mb-3">
                        <label class="form-label">Before Training</label>
                        <hr class="bold-hr">
                        <div class="bt">
                            <label class="me-3"><input type="radio" name="beforeTraining" value="beginner"> Beginner</label>
                            <label class="me-3"><input type="radio" name="beforeTraining" value="intermediate"> Intermediate</label>
                            <label class="me-3"><input type="radio" name="beforeTraining" value="advanced"> Advanced</label>
                            <label><input type="radio" name="beforeTraining" value="expert"> Expert</label>
                        </div>
                    </div>

                    <!-- Learning Application Plan Section -->
                    <div class="mb-4">
                        <label class="form-label">Learning Application Plan</label>
                        <p class="form-text">(Activities/Outputs to Demonstrate Training Effectiveness)</p>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Outcome/Result of Activity/Output Section -->
                    <div class="mb-4">
                        <label class="form-label">Outcome/Result of Activity/Output</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>

                    <!-- After Training Section -->
                    <div class="mb-3">
                        <label class="form-label">After Training:</label>
                        <hr class="bold-hr">
                        <div class="bt">
                            <label class="me-3"><input type="radio" name="afterTraining" value="beginner"> Beginner</label>
                            <label class="me-3"><input type="radio" name="afterTraining" value="intermediate"> Intermediate</label>
                            <label class="me-3"><input type="radio" name="afterTraining" value="advanced"> Advanced</label>
                            <label><input type="radio" name="afterTraining" value="expert"> Expert</label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End of Main Content -->

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>