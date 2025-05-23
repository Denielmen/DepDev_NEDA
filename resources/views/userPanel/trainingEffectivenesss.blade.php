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
            font-weight: bold;
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

        .sidebar a{
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

        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: rgb(187, 219, 252);
        }

        .form-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding-bottom: 50px;
        }

        .form-title {
            background-color: #e6f3ff;
            padding: 15px;
            margin: -20px -20px 20px -20px;
            border-radius: 8px 8px 0 0;
            color: #003366;
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 50px;
        }

        .roles {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            padding: 75px;
            border-radius: 10px;
            background-color: #f8f9fa;
            border: 1px solid black;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
            
        }

        .choicebox {
            display: flex;
            justify-content: center;
            align-items: stretch;
            gap: 20px;
            flex-wrap: wrap;
            width: 100%;
        }

        .choice {
            padding: 20px;
            border-radius: 30px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: calc(50% - 20px);
            max-width: 300px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: auto;
            transition: box-shadow 0.3s ease;
            cursor: pointer;
        }

        .choice:hover {
            box-shadow: -10px 8px 3px 0px #aaa;
        }


        .choice i {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .choice div {
            background-color: #79a7f5;
            padding: 15px;
            border-radius: 20px;
            text-align: left;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .choice h5 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .choice p {
            margin: 0;
            font-size: 14px;
            word-wrap: break-word;
            flex-grow: 1;
            display: flex;
            align-items: flex-start;
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
        <div class="sidebar" style="top: 56px;">
            <a href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('training.profile') }}"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="{{ route('tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
            <a href="{{ route('training.effectivenesss') }}" class="active"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
            <a href="{{ route('training.resources') }}"><i class="bi bi-archive me-2"></i>Training Resources</a>
        </div>
        <!-- Main Content -->
        <div class="main-content">

            <div class="form-container">
                <div class="form-title">
                    Training Effectiveness
                </div>

                <!-- Roles Container -->
                <div class="roles">
                    <!-- Text Role -->
                    <h1 class="text-role text-center">Choose your role</h1>
                    <div class="choicebox">
                        <!-- Evaluate Card -->
                        <div class="choice" onclick="window.location.href='{{ route('evalParticipant') }}'">
                            <i class="bi bi-people-fill" style="font-size: 2rem; margin-bottom: 10px;"></i>
                            <div style="background-color: #79a7f5; padding: 15px; border-radius: 20px; text-align: left;">
                                <h5 style="font-weight: bold;">Post Evaluation</h5>
                                <p style="margin-bottom: 0; font-size: 15px">Click here to evaluate yourself.</p>
                            </div>
                        </div>

                        <!-- View Evaluations Card -->
                        <div class="choice" onclick="window.location.href='{{ route('evalSupervisor') }}'">
                            <i class="bi bi-person-fill" style="font-size: 2rem; margin-bottom: 10px;"></i>
                            <div style="background-color: #79a7f5; padding: 15px; border-radius: 20px; text-align: left;">
                                <h5 style="font-weight: bold;">View Evaluations</h5>
                                <p style="margin-bottom: 0; font-size: 15px">Select Evaluiations to view. (Participant/Supervisor)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Main Content -->

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>