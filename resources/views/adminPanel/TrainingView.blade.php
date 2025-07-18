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
            top: 56px;
            left: 0;
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
            padding: 20px;
            background-color: rgb(187, 219, 252);
            margin-left: 270px;
            margin-top: 56px;
            min-height: calc(100vh - 56px);
        }
        .content-container {
            max-width: 1040px;
            width: 100%;
            margin: 0 auto;
        }
        .back-button-container {
            margin-bottom: 20px;
        }
        .details-card {
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
        .dropdown-menu {
            min-width: 200px;
            padding: 0.5rem 0;
            margin: 0.5rem 0 0;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item.text-danger:hover {
            background-color: #dc3545;
            color: white !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
     <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.home') }}">
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
                                <button type="submit" class="dropdown-item logout-btn">
                                    <i class="bi bi-box-arrow-right text-danger me-2"></i> Logout
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
            <a href="{{ route('admin.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('admin.training-plan') }}" class="active"><i class="bi bi-calendar-check me-2"></i>Training Program</a>
            <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>List of Employees</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Training Plan</a>
            <a href="{{ route('admin.search.index') }}"><i class="bi bi-search me-2"></i>Search</a>
        </div>
        <!-- Main Content -->
        <div class="main-content">
            <div class="content-container">
                <div class="back-button-container">
                    <a href="{{ route('admin.training-plan') }}" class="btn btn-back">
                        <i class="bi bi-arrow-left"></i>
                        Back
                    </a>
                </div>
                <div class="details-card">
                    <h2 class="details-title">Training Details</h2>
                    <table class="details-table">
                        <tr>
                            <td class="label">Title/Area:</td>
                            <td>{{ $training->title ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Competency:</td>
                            <td>{{ $training->competency->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Three-Year Period:</td>
                            <td> {{ $training->period_from ?? '' }} - {{ $training->period_to ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Year of Implementation:</td>
                            <td>{{ $training->implementation_date_from ? $training->implementation_date_from->format('m/d/Y') : '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Budget (per hour):</td>
                            <td>{{ $training->budget ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">No. of Hours:</td>
                            <td>{{ $training->no_of_hours ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Learning Service Provider:</td>
                            <td>{{ $training->provider ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Development Target:</td>
                            <td>{{ $training->dev_target ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Performance Goal this Support:</td>
                            <td>{{ $training->performance_goal ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Objective:</td>
                            <td>{{ $training->objective ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Participants:</td>
                            <td>
                                @php
                                    // Force a fresh reload of the participants relationship with pivot data
                                    $training->load(['participants' => function($query) {
                                        $query->withPivot('participation_type_id', 'year')
                                              ->orderBy('last_name')->orderBy('first_name');
                                    }]);
                                @endphp




                                @forelse ($training->participants as $participant)
                                    <div class="mb-1">
                                        {{ $participant->last_name }}, {{ $participant->first_name }} {{ $participant->mid_init ?? '' }}
                                        @if($participant->pivot && $participant->pivot->participation_type_id)
                                            <span class="badge bg-info">
                                                {{ $participationTypes[$participant->pivot->participation_type_id]->name ?? 'N/A' }}
                                            </span>
                                        @endif
                                        @if($participant->pivot && $participant->pivot->year)
                                            <span class="badge bg-secondary">
                                                CY-{{ $participant->pivot->year }}
                                            </span>
                                        @endif

                                    </div>
                                @empty
                                    <div class="text-muted">No participants found.</div>
                                @endforelse
                            </td>
                        </tr>
                    </table>
                    <div class="action-buttons">
                        <a href="{{ route('admin.training-plan.edit', ['training' => $training->id]) }}" class="btn btn-edit">
                            <i class="bi bi-pencil"></i>
                            Edit
                        </a>
                        <form action="{{ route('admin.training-plan.destroy', ['training' => $training->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this training? This action cannot be undone.')">
                                <i class="bi bi-trash"></i>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>










