<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>lnd.dro7.depdev</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            padding-top: 60px;
            background-color: rgb(187, 219, 252);
        }
        .navbar {
            background-color: #fff;
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
        .user-icon, .user-menu {
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
            margin-top: 50px;
            padding-bottom: 20px;

        }
        .details-card {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        .details-title {
            color: #003366;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table tr {
            border-bottom: 1px solid #dee2e6;
        }
        .details-table td {
            padding: 12px 15px;
        }
        .details-table .label {
            width: 200px;
            font-weight: 500;
            color: #003366;
        }
        .content-container {
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
        }
        .back-button-container {
            margin-bottom: 20px;
        }
        .btn-back {
            background-color: #003366;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .btn-back:hover {
            background-color: #004080;
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
        .profile-picture {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #003366;
            box-shadow: 0 0 0 2px #fff;
            margin-right: 8px;
        }

        .user-menu {
            display: flex;
            align-items: center;
        }

        .user-menu .bi-person-circle {
            font-size: 32px;
            margin-right: 8px;
        }        
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.home') }}">
                <img src="/images/neda-logo.png" alt="NEDA Logo">
                DEPDEV Region VII Learning and Development Database System
            </a>
           <div class="d-flex align-items-center">
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown" style="cursor:pointer;">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="profile-picture">
                        @else
                            <i class="bi bi-person-circle"></i>
                        @endif
                        {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        <i class="bi bi-chevron-down ms-1"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                            <a href="{{ route('admin.participants.info', ['id' => Auth::user()->id]) }}" class="dropdown-item">
                                <i class="bi bi-person-lines-fill me-2"></i> Profile Info
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
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
            <a href="{{ route('admin.training-plan') }}" class="active"><i class="bi bi-calendar-check me-2"></i>Training Profile</a>
            <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>Employees Information</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Training Plan</a>
            <a href="{{ route('admin.search.index') }}"><i class="bi bi-search me-2"></i>Search</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-container">
                <div class="back-button-container">
                    <a href="{{ route('admin.training-plan.unprogrammed') }}" class="btn btn-back">
                        <i class="bi bi-arrow-left"></i>
                        Back
                    </a>
                </div>
                <div class="details-card">
                    <h2 class="details-title">Training Details</h2>
                    <table class="details-table">
                        <tr>
                            <td class="label">Title/Subject Area:</td>
                            <td>{{ $training->title ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Type:</td>
                            <td>{{ $training->core_competency ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Competency:</td>
                            <td>{{ $training->competency->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Uploaded/Added by:</td>
                            <td>
                                @php
                                    $uploader = 'N/A';
                                    if ($training->user_id) {
                                        $uploaderUser = \App\Models\User::find($training->user_id);
                                        if ($uploaderUser) {
                                            $uploader = $uploaderUser->last_name . ', ' . $uploaderUser->first_name . ' ' . ($uploaderUser->mid_init ?? '');
                                        }
                                    }
                                @endphp
                                {{ $uploader }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label">User Role:</td>
                            <td>
                                @php
                                    $userRole = 'N/A';
                                    $creatorId = $training->user_id ?? null;

                                    if ($creatorId) {
                                        $creatorParticipant = $training->participants->where('id', $creatorId)->first();
                                        if ($creatorParticipant && isset($creatorParticipant->pivot->participation_type_id)) {
                                            $participationType = $participationTypes->get($creatorParticipant->pivot->participation_type_id);
                                            $userRole = $participationType ? $participationType->name : 'N/A';
                                        }
                                    }
                                @endphp
                                {{ $userRole }}
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Year of Implementation:</td>
                            <td>{{ $training->implementation_date_from ? $training->implementation_date_from->format('m/d/Y') : '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Learning Service Provider:</td>
                            <td>{{ $training->provider ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Status:</td>
                            <td>{{ $training->status ?? '' }}</td>
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
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

