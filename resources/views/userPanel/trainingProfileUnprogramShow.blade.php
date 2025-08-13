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
            background-color: rgb(187, 219, 252);
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
            
            margin-left: 270px;
            margin-top: 50px;
            padding-bottom: 20px;

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
        .top-actions {
            margin-bottom: 20px;
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
                        <i class="bi bi-person-circle"></i>
                        {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        <i class="bi bi-chevron-down ms-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="{{ route('user.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('user.training.profile') }}" class="active"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="{{ route('user.tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
            <a href="{{ route('user.training.effectiveness') }}"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
            <a href="{{ route('user.training.resources') }}"><i class="bi bi-archive me-2"></i>Training Resources</a>
        </div>
        <!-- Main Content -->
        <div class="main-content">
            <div class="top-actions">
                <a href="{{ route('user.training.profile.unprogrammed') }}" class="btn btn-back">
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
                        <td class="label">User Role:</td>
                        <td>
                            @php
                                $currentUser = Auth::user();
                                $userRole = 'N/A';
                                if ($currentUser) {
                                    $participant = $training->participants->where('id', $currentUser->id)->first();
                                    if ($participant && isset($participant->pivot->participation_type_id)) {
                                        $participationType = App\Models\ParticipationType::find($participant->pivot->participation_type_id);
                                        $userRole = $participationType->name ?? 'N/A';
                                    }
                                }
                            @endphp
                            {{ $userRole }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label">No. of Hours:</td>
                        <td>{{ $training->no_of_hours ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Date of Attendance:</td>
                        <td>
                            @if($training->implementation_date_from && $training->implementation_date_to)
                                {{ $training->implementation_date_from->format('m/d/Y') }} - {{ $training->implementation_date_to->format('m/d/Y') }}
                            @elseif($training->implementation_date_from)
                                {{ $training->implementation_date_from->format('m/d/Y') }} - N/A
                            @elseif($training->implementation_date_to)
                                N/A - {{ $training->implementation_date_to->format('m/d/Y') }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Learning Service Provider:</td>
                        <td>{{ $training->provider ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Status:</td>
                        <td>{{ $training->status ?? '' }}</td>
                    </tr>
                </table>
                @if(Auth::id() === ($training->user_id ?? null))
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('user.training.profile.unprogram.edit', $training->id) }}" class="btn btn-primary" style="background-color:#0d6efd;border:none;">
                        <i class="bi bi-pencil-square"></i>
                        Edit
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html> 