<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
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
        }
        .dropdown-menu {
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/neda-logo.png" alt="NEDA Logo" height="30">
                DEPDEV Learning and Development System
            </a>
            <div class="d-flex align-items-center">
                <i class="bi bi-bell-fill me-3"></i>
                <div class="dropdown">
                    <div class="dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> Admin
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
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
        <div class="sidebar">
            <a href="{{ route('admin.home') }}" class="active"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('admin.training-plan') }}"><i class="bi bi-calendar-check me-2"></i>Training Plan</a>
            <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>List of Participants</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
            <a href="{{ route('search.index') }}"><i class="bi bi-search me-2"></i>Search</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h1 class="mb-4">Search and Export</h1>
            <form action="{{ route('search.results') }}" method="GET">
                <div class="row mb-3">
                    <!-- Keyword Filter -->
                    <div class="col-md-6">
                        <label for="keyword" class="form-label">Search Item/s</label>
                        <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Search">
                    </div>

                    <!-- Type Filter -->
                    <div class="col-md-4">
                        <label for="type" class="form-label">Type</label>
                        <select name="type" id="type" class="form-select">
                            <option value="">Select Type</option>
                            <option value="training">Training</option>
                            <option value="user">User</option>
                        </select>
                    </div>

                    <!-- Year of Implementation Filter -->
                    <div class="col-md-4">
                        <label for="year" class="form-label">Year of Implementation</label>
                        <input type="number" name="year" id="year" class="form-control" placeholder="YYYY" min="1900" max="{{ date('Y') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Competencies Filter -->
                    <div class="col-md-6">
                        <label for="competencies" class="form-label">Competencies</label>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="competenciesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Competencies
                            </button>
                            <ul class="dropdown-menu px-3" aria-labelledby="competenciesDropdown">
                                <li>
                                    <div class="form-check px-3 mb-2">
                                        <input class="form-check-input" type="checkbox" name="competencies[]" value="competency_1" id="competency_1">
                                        <label class="form-check-label" for="competency_1">Competency 1</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check px-3 mb-2">
                                        <input class="form-check-input" type="checkbox" name="competencies[]" value="competency_2" id="competency_2">
                                        <label class="form-check-label" for="competency_2">Competency 2</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check px-3 mb-2">
                                        <input class="form-check-input" type="checkbox" name="competencies[]" value="competency_3" id="competency_3">
                                        <label class="form-check-label" for="competency_3">Competency 3</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check px-3 mb-2">
                                        <input class="form-check-input" type="checkbox" name="competencies[]" value="competency_4" id="competency_4">
                                        <label class="form-check-label" for="competency_4">Competency 4</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check px-3 mb-2">
                                        <input class="form-check-input" type="checkbox" name="competencies[]" value="competency_1" id="competency_1">
                                        <label class="form-check-label" for="competency_1">Competency 1</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check px-3 mb-2">
                                        <input class="form-check-input" type="checkbox" name="competencies[]" value="competency_2" id="competency_2">
                                        <label class="form-check-label" for="competency_2">Competency 2</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check px-3 mb-2">
                                        <input class="form-check-input" type="checkbox" name="competencies[]" value="competency_3" id="competency_3">
                                        <label class="form-check-label" for="competency_3">Competency 3</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check px-3 mb-2">  
                                        <input class="form-check-input" type="checkbox" name="competencies[]" value="competency_4" id="competency_4">
                                        <label class="form-check-label" for="competency_4">Competency 4</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Search</button>
                    <div>
                        <a href="{{ route('search.export', ['format' => 'pdf']) }}" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
                        <a href="{{ route('search.export', ['format' => 'excel']) }}" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
                    </div>
                </div>
            </form>

            <!-- Results Section -->
            <div class="mt-5">
                <h2>Search Results</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Competencies</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Results -->
                        <tr>
                            <td>1</td>
                            <td>Sample Training</td>
                            <td>Training</td>
                            <td>2025-04-27</td>
                            <td>Competency 1, Competency 2</td>
                        </tr>
                        <!-- Dynamic results will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>