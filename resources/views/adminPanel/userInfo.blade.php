<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lnd.dro7.depdev</title>
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
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        .user-avatar i {
            font-size: 3rem;
            color: #6c757d;
        }
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        .user-avatar:hover .avatar-overlay {
            opacity: 1;
        }
        .avatar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 50%;
        }
        .avatar-overlay i {
            color: white;
            font-size: 1.5rem;
        }
        .avatar-upload-input {
            display: none;
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
            min-width: 270px; /* Training Title */
        }
        .table th:nth-child(2), .table td:nth-child(2) {
            min-width: 250px; /* Competency */
        }
        .table th:nth-child(3), .table td:nth-child(3) {
            min-width: 150px; /* Period of Implementation */
        }
        .table th:nth-child(4), .table td:nth-child(4) {
            min-width: 100px; /* No. of Hours */
        }
        .table th:nth-child(5), .table td:nth-child(5) {
            min-width: 150px; /* Provider */
        }
        .table th:nth-child(6), .table td:nth-child(6) {
            min-width: 200px; /* Status */
        }
        .table th:nth-child(7), .table td:nth-child(7) {
            min-width: 200px; /* User Role */
        }
        .table th:nth-child(8), .table td:nth-child(8) {
            min-width: 100px; /* Details */
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

        /* Analytics Section Styles */
        .analytics-year-container {
            border: 2px solid #4a90e2;
            border-radius: 8px;
            background-color: white;
            margin-bottom: 30px;
        }

        .analytics-year-header {
            background-color: #b8d4f0;
            border-bottom: 1px solid #4a90e2;
            padding: 15px;
            text-align: center;
            border-radius: 6px 6px 0 0;
        }

        .year-title {
            margin: 0;
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
        }

        .competency-chart-container {
            border-bottom: 1px solid #e0e0e0;
            background-color: #f8f9fa;
        }

        .competency-chart-container:last-child {
            border-bottom: none;
            border-radius: 0 0 6px 6px;
        }

        .competency-chart-header {
            background-color: #e9ecef;
            padding: 10px 20px;
            border-bottom: 1px solid #d0d0d0;
        }

        .competency-chart-header h5 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .chart-wrapper {
            padding: 20px;
            background-color: white;
            position: relative;
            height: 300px;
        }

        .chart-wrapper canvas {
            max-width: 100%;
            height: 100% !important;
        }
    </style>
</head>
<body>
     <!-- Navbar -->
     <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/neda-logo.png" alt="NEDA Logo">
                DEPDEV Region VII Learning and Development Database System
            </a>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown" style="cursor:pointer;">
                        <i class="bi bi-person-circle"></i>
                        {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
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
                    <div class="user-avatar" onclick="document.getElementById('profilePictureInput').click()" title="Click to upload profile picture">
                        @if($user->profile_picture && file_exists(public_path('storage/' . $user->profile_picture)))
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" id="profileImage">
                        @else
                            <i class="fas fa-user fa-3x text-secondary" id="defaultIcon"></i>
                        @endif
                        <div class="avatar-overlay">
                            <i class="fas fa-camera"></i>
                            <small style="color: white; font-size: 0.7rem; margin-top: 5px;">Upload</small>
                        </div>
                    </div>
                    <input type="file" id="profilePictureInput" class="avatar-upload-input" accept="image/*" onchange="uploadProfilePicture(this)">
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
                            <div class="col-md-4">
                                <label class="form-label">Salary Grade</label>
                                <input type="text" class="form-control" name="salary_grade" value="{{ $user->salary_grade }}" readonly>
                            </div>
                            <div class="col-md-8">
                                <!-- Display mode -->
                                <div class="division-display">
                                    <label class="form-label">Division/Unit</label>
                                    <input type="text" class="form-control" value="{{ $user->division }}" readonly>
                                </div>
                                <!-- Edit mode -->
                                <div class="division-edit" style="display: none;">
                                    <label class="form-label">Division/Unit</label>
                                    <select class="form-control" name="division" readonly disabled>
                                        <option value="">Select Division/Unit</option>
                                        <option value="ORD - Office of the Regional Director" {{ $user->division == 'ORD - Office of the Regional Director' ? 'selected' : '' }}>ORD - Office of the Regional Director</option>
                                        <option value="FAD - Finance and Administrative Division" {{ $user->division == 'FAD - Finance and Administrative Division' ? 'selected' : '' }}>FAD - Finance and Administrative Division</option>
                                        <option value="PFPD - Policy Formulation and Planning Division" {{ $user->division == 'PFPD - Policy Formulation and Planning Division' ? 'selected' : '' }}>PFPD - Policy Formulation and Planning Division</option>
                                        <option value="DRD - Development Research Division" {{ $user->division == 'DRD - Development Research Division' ? 'selected' : '' }}>DRD - Development Research Division</option>
                                        <option value="PDIPBD - Project Development, Investment Programming and Budget Division" {{ $user->division == 'PDIPBD - Project Development, Investment Programming and Budget Division' ? 'selected' : '' }}>PDIPBD - Project Development, Investment Programming and Budget Division</option>
                                        <option value="PMED - Project Monitoring and Educational Division" {{ $user->division == 'PMED - Project Monitoring and Educational Division' ? 'selected' : '' }}>PMED - Project Monitoring and Educational Division</option>
                                        <option value="ORD-RDC - Office of the Regional Director - Regional Development Council" {{ $user->division == 'ORD-RDC - Office of the Regional Director - Regional Development Council' ? 'selected' : '' }}>ORD-RDC - Office of the Regional Director - Regional Development Council</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <!-- Display mode -->
                                <div class="years-display">
                                    <label class="form-label">Years in Position</label>
                                    <input type="text" class="form-control" value="{{ $user->position_start_date ? \Carbon\Carbon::parse($user->position_start_date)->format('m/d/Y') : '' }}" readonly>
                                    <small class="text-muted">{{ $user->getFormattedYearsInPosition() }}</small>
                                </div>
                                <!-- Edit mode -->
                                <div class="years-edit" style="display: none;">
                                    <label class="form-label">Position Start Date</label>
                                    <input type="date" class="form-control" name="position_start_date" value="{{ $user->position_start_date }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Display mode -->
                                <div class="years-display">
                                    <label class="form-label">Years in Government</label>
                                    <input type="text" class="form-control" value="{{ $user->government_start_date ? \Carbon\Carbon::parse($user->government_start_date)->format('m/d/Y') : '' }}" readonly>
                                    <small class="text-muted">{{ $user->getFormattedYearsInGovernment() }}</small>
                                </div>
                                <!-- Edit mode -->
                                <div class="years-edit" style="display: none;">
                                    <label class="form-label">Government Start Date</label>
                                    <input type="date" class="form-control" name="government_start_date" value="{{ $user->government_start_date }}" readonly>
                                </div>
                            </div>
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
                    <a class="nav-link active" href="{{ route('admin.participants.info', ['id' => $user->id]) }}">Programmed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.participants.info.unprogrammed', ['id' => $user->id]) }}">Unprogrammed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="analyticsTab">Analytics</a>
                </li>
            </ul>
        </div>

        <!-- Scrollable Table -->
        <div class="table-container" id="trainingTable">
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
                    @foreach($programmedTrainings as $training)
                    <tr>
                        <td>{{ $training->title }}</td>
                        <td>{{ $training->competency->name}}</td>
                        <td>@if($training->status === 'Implemented' )
                                    {{ $training->implementation_date_to ? \Carbon\Carbon::parse($training->implementation_date_to)->format('m/d/Y') : 'Not set' }}
                                @else
                                    {{ $training->period_from ?? 'Not set' }} - {{ $training->period_to ?? 'Not set' }}
                                @endif</td>
                        <td>{{ $training->no_of_hours }}</td>
                        <td>{{ $training->provider }}</td>
                        <td>
                            @php
                                // Check if this user has completed pre-evaluation for this training
                                $userEvaluation = $training->evaluations->where('user_id', $user->id)->first();
                                $hasPreEvaluation = $userEvaluation && $userEvaluation->participant_pre_rating !== null;

                                // Check if this user has completed tracking (has implementation dates)
                                $hasTracking = $training->implementation_date_from !== null;

                                // Determine status for this specific user
                                if ($hasPreEvaluation && $hasTracking) {
                                    $userStatus = 'Implemented';
                                } else {
                                    $userStatus = 'Not yet Implemented';
                                }
                            @endphp
                            {{ $userStatus }}
                        </td>
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
                            <a href="{{ route('admin.viewUserInfo', ['training_id' => $training->id, 'user_id' => $user->id]) }}" class="btn btn-primary">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Info and Links -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="pagination-info">
                    <small class="text-muted">
                        Showing {{ $programmedTrainings->firstItem() ?? 0 }} to {{ $programmedTrainings->lastItem() ?? 0 }}
                        of {{ $programmedTrainings->total() }} programmed trainings
                    </small>
                </div>
                <div class="pagination-links">
                    @if ($programmedTrainings->hasPages())
                        <nav aria-label="Pagination Navigation">
                            <ul class="pagination">
                                {{-- Previous Page Link --}}
                                @if ($programmedTrainings->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $programmedTrainings->previousPageUrl() }}">Previous</a></li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($programmedTrainings->getUrlRange(1, $programmedTrainings->lastPage()) as $page => $url)
                                    @if ($page == $programmedTrainings->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($programmedTrainings->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $programmedTrainings->nextPageUrl() }}">Next</a></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>

        <!-- Analytics Section -->
        <div class="table-container" id="analyticsSection" style="display: none;">
            @php
                // Get all programmed trainings for this user for analytics
                $allUserTrainings = \App\Models\Training::where('type', 'Program')
                    ->whereHas('participants', function ($query) use ($user) {
                        $query->where('training_participants.user_id', $user->id);
                    })
                    ->with(['competency', 'participants', 'evaluations' => function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    }])
                    ->get();

                // Group trainings by year (based on period_from/period_to), then by individual training
                $yearlyAnalytics = [];
                foreach ($allUserTrainings as $training) {
                    $competencyName = $training->competency->name ?? 'Unknown Competency';

                    // Use period_from and period_to to determine the year
                    $year = null;
                    if ($training->period_from && $training->period_to) {
                        // If period spans multiple years, use the range
                        if ($training->period_from != $training->period_to) {
                            $year = $training->period_from . '-' . $training->period_to;
                        } else {
                            $year = $training->period_from;
                        }
                    } elseif ($training->period_from) {
                        $year = $training->period_from;
                    } elseif ($training->period_to) {
                        $year = $training->period_to;
                    } else {
                        $year = 'No Period Set';
                    }

                    if (!isset($yearlyAnalytics[$year])) {
                        $yearlyAnalytics[$year] = [];
                    }

                    // Create unique training identifier using training title and competency
                    $trainingLabel = $training->title . ' (' . $competencyName . ')';

                    // Get the evaluation for this specific user and training
                    $evaluation = $training->evaluations->first();
                    $trainingRating = 0;

                    if ($evaluation) {
                        // Calculate average of available ratings for this specific training
                        $availableRatings = [];

                        if ($evaluation->participant_pre_rating !== null) {
                            $availableRatings[] = $evaluation->participant_pre_rating;
                        }
                        if ($evaluation->participant_post_rating !== null) {
                            $availableRatings[] = $evaluation->participant_post_rating;
                        }
                        if ($evaluation->supervisor_pre_rating !== null) {
                            $availableRatings[] = $evaluation->supervisor_pre_rating;
                        }
                        if ($evaluation->supervisor_post_rating !== null) {
                            $availableRatings[] = $evaluation->supervisor_post_rating;
                        }

                        // Calculate average rating for this training
                        if (count($availableRatings) > 0) {
                            $trainingRating = round(array_sum($availableRatings) / count($availableRatings), 2);
                        }
                    }

                    // Store each training separately
                    $yearlyAnalytics[$year][$trainingLabel] = [
                        'training' => $training,
                        'rating' => $trainingRating,
                        'competency' => $competencyName
                    ];
                }

                // Get the most recent 3 years (sort by year, handling year ranges)
                $sortedYears = array_keys($yearlyAnalytics);
                usort($sortedYears, function($a, $b) {
                    // Extract the first year from ranges like "2024-2025"
                    $yearA = is_numeric($a) ? (int)$a : (int)explode('-', $a)[0];
                    $yearB = is_numeric($b) ? (int)$b : (int)explode('-', $b)[0];
                    return $yearB - $yearA; // Descending order
                });
                $recentYears = array_slice($sortedYears, 0, 3);
            @endphp

            <h4 class="mb-4">Analytics - Training Effectiveness (3-Year Period)</h4>

            @if(count($yearlyAnalytics) > 0)
                @foreach($recentYears as $year)
                    @if(isset($yearlyAnalytics[$year]))
                        <div class="mb-5">
                            <!-- Year Header -->
                            <div class="analytics-year-container">
                                <div class="analytics-year-header">
                                    <h3 class="year-title">{{ $year }}</h3>
                                </div>

                                <!-- Single Chart for all trainings in this year -->
                                <div class="competency-chart-container">
                                    <div class="competency-chart-header">
                                        <h5>Training Effectiveness by Individual Training</h5>
                                    </div>
                                    <div class="chart-wrapper">
                                        <canvas id="chart_{{ \Illuminate\Support\Str::slug($year) }}" width="600" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    No analytics data available. This user has no programmed trainings.
                </div>
            @endif
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

            // Switch years fields to edit mode (show dates)
            const yearsDisplays = document.querySelectorAll('.years-display');
            const yearsEdits = document.querySelectorAll('.years-edit');
            yearsDisplays.forEach(display => display.style.display = 'none');
            yearsEdits.forEach(edit => edit.style.display = 'block');

            // Switch division field to edit mode (show dropdown)
            const divisionDisplay = document.querySelector('.division-display');
            const divisionEdit = document.querySelector('.division-edit');
            const divisionSelect = divisionEdit.querySelector('select');
            divisionDisplay.style.display = 'none';
            divisionEdit.style.display = 'block';
            divisionSelect.removeAttribute('readonly');
            divisionSelect.removeAttribute('disabled');

            editButton.style.display = 'none';
            saveCancelButtons.style.display = 'block';

            // Make Position Start Date editable but keep Government Start Date read-only
            const positionStartDate = document.querySelector('input[name="position_start_date"]');
            const governmentStartDate = document.querySelector('input[name="government_start_date"]');
            
            if (positionStartDate) {
                positionStartDate.removeAttribute('readonly');
                positionStartDate.addEventListener('change', calculateYearsInPosition);
                positionStartDate.addEventListener('input', calculateYearsInPosition);
            }
            
            // Keep Government Start Date read-only
            if (governmentStartDate) {
                governmentStartDate.setAttribute('readonly', true);
            }
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

            // Switch years fields back to display mode (show formatted years)
            const yearsDisplays = document.querySelectorAll('.years-display');
            const yearsEdits = document.querySelectorAll('.years-edit');
            yearsDisplays.forEach(display => display.style.display = 'block');
            yearsEdits.forEach(edit => edit.style.display = 'none');

            // Switch division field back to display mode (show text)
            const divisionDisplay = document.querySelector('.division-display');
            const divisionEdit = document.querySelector('.division-edit');
            const divisionSelect = divisionEdit.querySelector('select');
            divisionDisplay.style.display = 'block';
            divisionEdit.style.display = 'none';
            divisionSelect.setAttribute('readonly', true);
            divisionSelect.setAttribute('disabled', true);

            editButton.style.display = 'block';
            saveCancelButtons.style.display = 'none';

            // Restore read-only state for both date fields
            const positionStartDate = document.querySelector('input[name="position_start_date"]');
            const governmentStartDate = document.querySelector('input[name="government_start_date"]');
            
            if (positionStartDate) {
                positionStartDate.setAttribute('readonly', true);
            }
            
            if (governmentStartDate) {
                governmentStartDate.setAttribute('readonly', true);
            }
        });

        // Handle form submission
        saveButton.addEventListener('click', function() {
            form.submit();
        });

        // Add functions to calculate years when dates change
        function calculateYearsInGovernment() {
            const startDate = document.querySelector('input[name="government_start_date"]').value;
            const yearsDisplay = document.getElementById('years_display');
            const hiddenInput = document.querySelector('input[name="years_in_csc"]');

            if (startDate) {
                const start = new Date(startDate);
                const today = new Date();

                // Calculate the difference in years
                let years = today.getFullYear() - start.getFullYear();
                const monthDiff = today.getMonth() - start.getMonth();

                // Adjust if the current date hasn't reached the anniversary yet
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < start.getDate())) {
                    years--;
                }

                // Ensure years is not negative
                years = Math.max(0, years);

                yearsDisplay.textContent = years;
                hiddenInput.value = years;
            } else {
                yearsDisplay.textContent = '0';
                hiddenInput.value = '0';
            }
        }

        function calculateYearsInPosition() {
            const startDate = document.querySelector('input[name="position_start_date"]').value;
            const positionYearsDisplay = document.getElementById('position_years_display');
            const hiddenInput = document.querySelector('input[name="years_in_position"]');

            if (startDate) {
                const start = new Date(startDate);
                const today = new Date();

                // Calculate the difference in years
                let years = today.getFullYear() - start.getFullYear();
                const monthDiff = today.getMonth() - start.getMonth();

                // Adjust if the current date hasn't reached the anniversary yet
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < start.getDate())) {
                    years--;
                }

                // Ensure years is not negative
                years = Math.max(0, years);

                positionYearsDisplay.textContent = years;
                hiddenInput.value = years;
            } else {
                positionYearsDisplay.textContent = '0';
                hiddenInput.value = '0';
            }
        }

        // Add event listeners for date changes when in edit mode
        editButton.addEventListener('click', function() {
            // Add event listeners for date fields
            const governmentStartDate = document.querySelector('input[name="government_start_date"]');
            const positionStartDate = document.querySelector('input[name="position_start_date"]');

            if (governmentStartDate) {
                governmentStartDate.addEventListener('change', calculateYearsInGovernment);
                governmentStartDate.addEventListener('input', calculateYearsInGovernment);
            }

            if (positionStartDate) {
                positionStartDate.addEventListener('change', calculateYearsInPosition);
                positionStartDate.addEventListener('input', calculateYearsInPosition);
            }
        });

        // Calculate years on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateYearsInGovernment();
            calculateYearsInPosition();
        });

        // Handle tab switching
        const programmedTab = document.querySelector('a[href="{{ route('admin.participants.info', ['id' => $user->id]) }}"]');
        const unprogrammedTab = document.querySelector('a[href="{{ route('admin.participants.info.unprogrammed', ['id' => $user->id]) }}"]');
        const analyticsTab = document.getElementById('analyticsTab');
        const trainingTable = document.getElementById('trainingTable');
        const analyticsSection = document.getElementById('analyticsSection');

        // Handle analytics tab click
        analyticsTab.addEventListener('click', function(e) {
            e.preventDefault();

            // Update tab states
            programmedTab.classList.remove('active');
            unprogrammedTab.classList.remove('active');
            analyticsTab.classList.add('active');

            // Show analytics section and hide table
            trainingTable.style.display = 'none';
            analyticsSection.style.display = 'block';

            // Initialize charts if not already done
            if (!window.chartsInitialized) {
                initializeAnalyticsCharts();
                window.chartsInitialized = true;
            }
        });

        // Handle programmed tab click
        programmedTab.addEventListener('click', function(e) {
            analyticsTab.classList.remove('active');
            trainingTable.style.display = 'block';
            analyticsSection.style.display = 'none';
        });

        // Handle unprogrammed tab click (redirect)
        unprogrammedTab.addEventListener('click', function(e) {
            // Let the default behavior happen (redirect to unprogrammed page)
        });

        // Initialize analytics charts
        function initializeAnalyticsCharts() {
            @php
                $chartData = [];
                foreach ($recentYears as $year) {
                    if (isset($yearlyAnalytics[$year])) {
                        $chartId = \Illuminate\Support\Str::slug($year);

                        // Get training labels and their ratings for this year
                        $trainingLabels = [];
                        $trainingRatings = [];

                        foreach ($yearlyAnalytics[$year] as $trainingLabel => $data) {
                            $trainingLabels[] = $trainingLabel;
                            $trainingRatings[] = $data['rating'];
                        }

                        $chartData[$chartId] = [
                            'labels' => $trainingLabels,
                            'data' => $trainingRatings,
                            'year' => $year
                        ];
                    }
                }
            @endphp

            const chartData = @json($chartData);

            Object.keys(chartData).forEach(chartId => {
                const ctx = document.getElementById('chart_' + chartId);
                if (ctx) {
                    const data = chartData[chartId];
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Training Rating',
                                data: data.data,
                                borderColor: '#4a7c59',
                                backgroundColor: 'rgba(74, 124, 89, 0.1)',
                                borderWidth: 3,
                                fill: false,
                                tension: 0.4,
                                pointBackgroundColor: '#4a7c59',
                                pointBorderColor: '#4a7c59',
                                pointRadius: 6,
                                pointHoverRadius: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                    callbacks: {
                                        label: function(context) {
                                            const rating = context.parsed.y;
                                            if (rating > 0) {
                                                return 'Rating: ' + rating + '/4';
                                            }
                                            return 'No rating data available';
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    display: true,
                                    grid: {
                                        display: true,
                                        color: '#e0e0e0'
                                    },
                                    ticks: {
                                        color: '#666',
                                        maxRotation: 45,
                                        minRotation: 0
                                    }
                                },
                                y: {
                                    display: true,
                                    beginAtZero: true,
                                    max: 4,
                                    grid: {
                                        display: true,
                                        color: '#e0e0e0'
                                    },
                                    ticks: {
                                        color: '#666',
                                        stepSize: 1
                                    }
                                }
                            },
                            interaction: {
                                mode: 'nearest',
                                axis: 'x',
                                intersect: false
                            }
                        }
                    });
                }
            });
        }
    });

    // Profile picture upload function
    function uploadProfilePicture(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];

            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file.');
                input.value = ''; // Clear the input
                return;
            }

            // Validate file size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB.');
                input.value = ''; // Clear the input
                return;
            }

            // Show preview and confirm upload
            const reader = new FileReader();
            reader.onload = function(e) {
                const userAvatar = document.querySelector('.user-avatar');
                const originalContent = userAvatar.innerHTML;

                // Show preview
                userAvatar.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <div class="avatar-overlay" style="opacity: 1;">
                        <i class="fas fa-spinner fa-spin fa-2x text-white"></i>
                        <small style="color: white; font-size: 0.7rem; margin-top: 5px;">Uploading...</small>
                    </div>
                `;

                // Create FormData for upload
                const formData = new FormData();
                formData.append('profile_picture', file);
                formData.append('_token', '{{ csrf_token() }}');

                // Upload the file
                fetch('{{ route("admin.employee.upload-picture", $user->id) }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the avatar with the new image
                        const newImageHtml = `
                            <img src="${data.image_url}?t=${Date.now()}" alt="Profile Picture" id="profileImage">
                            <div class="avatar-overlay">
                                <i class="fas fa-camera"></i>
                                <small style="color: white; font-size: 0.7rem; margin-top: 5px;">Upload</small>
                            </div>
                        `;
                        userAvatar.innerHTML = newImageHtml;

                        // Show success message
                        alert('Profile picture updated successfully!');
                    } else {
                        // Restore original content on error
                        userAvatar.innerHTML = originalContent;
                        alert('Error uploading image: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Restore original content on error
                    userAvatar.innerHTML = originalContent;
                    alert('Error uploading image. Please try again.');
                });
            };
            reader.readAsDataURL(file);
        }
    }
    </script>
</body>
</html>
