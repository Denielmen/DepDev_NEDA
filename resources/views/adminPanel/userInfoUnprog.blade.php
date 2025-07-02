<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEPDEV Learning and Development Database System Region VII</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            padding-top: 56px;
            background-color: rgb(187, 219, 252);
        }
        .navbar {
            background-color: rgb(255, 255, 255);
            padding: 0.5rem 1rem;
            box-shadow: 1px 3px 3px 0px #737373;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
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
            left: 0;
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
            font-weight: bold;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        .user-info-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .user-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            border: 2px solid #004080;
        }
        .user-avatar i {
            font-size: 3rem;
            color: #6c757d;
        }
        .form-control {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 8px 12px;
        }
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        .table-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow-y: hidden;
            overflow-x: auto;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            background-color: #003366;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1;
            text-align: center;
        }
        .table td, .table th {
            padding: 20px;
            vertical-align: middle;
        }
        .table th:nth-child(1), .table td:nth-child(1) {
            min-width: 250px;
        }
        .table th:nth-child(2), .table td:nth-child(2) {
            min-width: 250px;
        }
        .table th:nth-child(3), .table td:nth-child(3),
        .table th:nth-child(4), .table td:nth-child(4),
        .table th:nth-child(5), .table td:nth-child(5),
        .table th:nth-child(6), .table td:nth-child(6),
        .table th:nth-child(7), .table td:nth-child(7),
        .table th:nth-child(8), .table td:nth-child(8),
        .table th:nth-child(9), .table td:nth-child(9) {
            min-width: 120px;
        }
        .program-tabs {
            margin-bottom: 5px;
        }
        .program-tabs .nav-link {
            color: #d6d3d3 !important;
            margin-right: 5px;
            border-radius: 5px;
            color: #003366 !important;
            background-color: white;

        }
        .program-tabs .nav-link.active {
            background-color: #003366;
            color: white !important;
            font-weight: bold;
        }
        .btn-back {
            background-color: #003366;
            color: #fff;
            border: none;
            padding: 8px 25px;
            border-radius: 4px;
            font-weight: 500;
            margin-bottom: 15px;
            text-decoration: none;
            margin-right: 900px;

        }
        .btn-back:hover {
            background-color: #004080;
            color: #fff;
            transform: translateY(-1px);
        }
        .user-info-card.text-center {
            padding: 25px 20px;
        }
        .user-info-card h4 {
            margin-bottom: 8px;
            font-size: 1.4rem;
        }
        .user-info-card p {
            font-size: 0.95rem;
            line-height: 1.4;
        }
        .user-avatar {
            margin-bottom: 20px;
        }
        .form-label,.mb-0 {
            font-weight: bold;
        }
        .btn-primary{
            background-color: #003366;
            color: #fff;
            border: none;
            padding: 8px 25px;
            border-radius: 4px;
        }

        /* Pagination Styling */
        .pagination-info {
            color: #666;
            font-size: 0.9rem;
        }

        .pagination-links .pagination {
            margin: 0;
        }

        .pagination-links .page-link {
            color: #003366;
            border-color: #dee2e6;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        .pagination-links .page-link:hover {
            color: #004080;
            background-color: #e7f1ff;
            border-color: #003366;
        }

        .pagination-links .page-item.active .page-link {
            background-color: #003366;
            border-color: #003366;
            color: white;
        }

        .pagination-links .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }

        /* Style Previous/Next buttons with simple text */
        .pagination-links .page-item:first-child .page-link {
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
        }

        .pagination-links .page-item:last-child .page-link {
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
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
                    <div class="user-menu" data-bs-toggle="dropdown" style="cursor:pointer;">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->last_name ?? 'Admin' }}
                        <i class="bi bi-chevron-down ms-1"></i>
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

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="{{ route('admin.home') }}" ><i class="bi bi-house-door me-2"></i>Home</a>
        <a href="{{ route('admin.training-plan') }}"><i class="bi bi-calendar-check me-2"></i>Training Program</a>
        <a href="{{ route('admin.participants') }}" class="active"><i class="bi bi-people me-2"></i>List of Employees</a>
        <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Training Plan</a>
        <a href="{{ route('admin.search.index') }}"><i class="bi bi-search me-2"></i>Search</a>
    </div>

    <!-- Main Content -->
    <main class="main-content">
    <div class="top-actions">
                <button class="btn btn-back" onclick="window.location.href='{{ route('admin.participants') }}'">
                    <i class="bi bi-arrow-left"></i>
                    Back
                </button>
            </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

         <div class="row">
            <!-- User Info Card -->
            <div class="col-md-4">
                <div class="user-info-card text-center">
                    <div class="user-avatar">
                        <i class="fas fa-user fa-3x text-secondary"></i>
                    </div>
                    <div id="nameDisplay">
                        <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                    </div>
                    <p class="text-muted mb-0">ID: {{ $user->user_id }}</p>
                    <p class="text-muted mb-0">{{ $user->position }}</p>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="col-md-8">
                <div class="user-info-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Employee Information</h5>
                        <button id="editButton" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <div id="saveCancelButtons" style="display: none;">
                            <button id="saveButton" class="btn btn-success me-2">
                                <i class="fas fa-save"></i> Save
                            </button>
                            <button id="cancelButton" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                    <form id="employeeForm" action="{{ route('admin.employee.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div id="nameEdit" style="display: none;">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div id="employeeIdEdit" class="mb-3" style="display: none;">
                            <label class="form-label">Employee ID</label>
                            <input type="text" class="form-control" name="user_id" value="{{ $user->user_id }}" readonly>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Salary Grade</label>
                                <input type="text" class="form-control" name="salary_grade" value="{{ $user->salary_grade }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Years in Government</label>
                                <input type="number" class="form-control" name="years_in_csc" value="{{ $user->years_in_csc }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Division/Unit</label>
                            <input type="text" class="form-control" name="division" value="{{ $user->division }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Position</label>
                            <input type="text" class="form-control" name="position" value="{{ $user->position }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name of Supervisor (Last, First, MI)</label>
                            <input type="text" class="form-control" name="superior" value="{{ $user->superior }}" readonly>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Program Tabs -->
        <div class="program-tabs">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.participants.info', ['id' => $user->id]) }}">Programmed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin.participants.info.unprogrammed', ['id' => $user->id]) }}">Unprogrammed</a>
                </li>
            </ul>
        </div>

        <!-- Scrollable Table -->
        <div class="table-container">
            @if($unprogrammedTrainings->isEmpty())
                <div class="alert alert-info text-center">
                    <h5>No Unprogrammed Trainings Found</h5>
                    <p>This user has not created any unprogrammed trainings yet.</p>
                </div>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Training Title</th>
                            <th>Competency</th>
                            <th>Period of Implementation</th>
                            <th>No. of Hours</th>
                            <th>Provider</th>
                            <th>Status</th>
                            <th>User Role</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unprogrammedTrainings as $training)
                        <tr>
                            <td>{{ $training->title }}</td>
                            <td>{{ $training->competency->name }}</td>
                            <td>
                                @if($training->implementation_date_from && $training->implementation_date_to)
                                    {{ $training->implementation_date_from->format('m/d/y') }} - {{ $training->implementation_date_to->format('m/d/y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $training->no_of_hours }}</td>
                            <td>{{ $training->provider }}</td>
                            <td>{{ $training->status }}</td>
                             <td>
                            @php
                                $participationTypeName = 'N/A';
                                // Find the participant pivot data for the current user in this training
                                $participantPivot = $training->participants->first(function ($participant) use ($user) {
                                    return $participant->id === $user->id;
                                });

                                if ($participantPivot && $participantPivot->pivot) {
                                    // Now that we have the pivot, get the participation type ID
                                    $participationTypeId = $participantPivot->pivot->participation_type_id;
                                    // Find the participation type name using the ID
                                    $participationType = \App\Models\ParticipationType::find($participationTypeId);
                                    if ($participationType) {
                                        $participationTypeName = $participationType->name;
                                    }
                                }
                            @endphp
                            {{ $participationTypeName }}
                        </td>
                            <td>
                                <a href="{{ route('admin.viewUserInfoUnprog', ['training_id' => $training->id, 'user_id' => $user->id]) }}" class="btn btn-primary">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination Info and Links -->
                @if(!$unprogrammedTrainings->isEmpty())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="pagination-info">
                            <small class="text-muted">
                                Showing {{ $unprogrammedTrainings->firstItem() ?? 0 }} to {{ $unprogrammedTrainings->lastItem() ?? 0 }}
                                of {{ $unprogrammedTrainings->total() }} unprogrammed trainings
                            </small>
                        </div>
                        <div class="pagination-links">
                            @if ($unprogrammedTrainings->hasPages())
                                <nav aria-label="Pagination Navigation">
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        @if ($unprogrammedTrainings->onFirstPage())
                                            <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $unprogrammedTrainings->previousPageUrl() }}">Previous</a></li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach ($unprogrammedTrainings->getUrlRange(1, $unprogrammedTrainings->lastPage()) as $page => $url)
                                            @if ($page == $unprogrammedTrainings->currentPage())
                                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                            @else
                                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($unprogrammedTrainings->hasMorePages())
                                            <li class="page-item"><a class="page-link" href="{{ $unprogrammedTrainings->nextPageUrl() }}">Next</a></li>
                                        @else
                                            <li class="page-item disabled"><span class="page-link">Next</span></li>
                                        @endif
                                    </ul>
                                </nav>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButton = document.getElementById('editButton');
        const saveCancelButtons = document.getElementById('saveCancelButtons');
        const saveButton = document.getElementById('saveButton');
        const cancelButton = document.getElementById('cancelButton');
        const form = document.getElementById('employeeForm');
        const inputs = form.querySelectorAll('input[readonly]');
        const nameDisplay = document.getElementById('nameDisplay');
        const nameEdit = document.getElementById('nameEdit');
        const nameInputs = nameEdit.querySelectorAll('input[readonly]');
        let originalValues = {};

        // Store original values when edit is clicked
        editButton.addEventListener('click', function() {
            // Handle main form inputs
            inputs.forEach(input => {
                originalValues[input.name] = input.value;
                input.removeAttribute('readonly');
            });
            // Handle name inputs
            nameInputs.forEach(input => {
                originalValues[input.name] = input.value;
                input.removeAttribute('readonly');
            });
            // Show name edit fields and hide display
            nameDisplay.style.display = 'none';
            nameEdit.style.display = 'block';
            // Show employee ID edit field
            document.getElementById('employeeIdEdit').style.display = 'block';
            editButton.style.display = 'none';
            saveCancelButtons.style.display = 'block';
        });

        // Restore original values and readonly state when cancel is clicked
        cancelButton.addEventListener('click', function() {
            // Handle main form inputs
            inputs.forEach(input => {
                input.value = originalValues[input.name];
                input.setAttribute('readonly', true);
            });
            // Handle name inputs
            nameInputs.forEach(input => {
                input.value = originalValues[input.name];
                input.setAttribute('readonly', true);
            });
            // Show name display and hide edit fields
            nameDisplay.style.display = 'block';
            nameEdit.style.display = 'none';
            // Hide employee ID edit field
            document.getElementById('employeeIdEdit').style.display = 'none';
            editButton.style.display = 'block';
            saveCancelButtons.style.display = 'none';
        });

        // Handle form submission
        saveButton.addEventListener('click', function() {
            form.submit();
        });
    });
    </script>
</body>
</html>

