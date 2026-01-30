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
        .training-info {
            margin: 20px 0;
        }
        .info-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
            min-width: 200px;
        }
        .info-value {
            color: #212529;
            margin-left: 10px;
        }
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        .btn-back {
            background-color: #003366;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
            line-height: 1.2;
            height: 40px;
            min-width: 80px;
            box-sizing: border-box;
        }
        .btn-back:hover {
            background-color: #5a6268;
            color: white;
        }
        .btn-edit {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
            line-height: 1.2;
            height: 40px;
            min-width: 80px;
            box-sizing: border-box;
        }
        .btn-edit:hover {
            background-color: #0056b3;
            color: white;
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
                </div>
            </div>
        </div>
    </nav>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="{{ route('user.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('user.training.profile') }}" class="active"><i class="bi bi-person-vcard me-2"></i>Individual Training Profile</a>
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
                
                <div class="training-info">
                    <div class="info-item">
                        <span class="info-label">Competency:</span>
                        <span class="info-value">{{ $training->competency->name ?? '' }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">User Role:</span>
                        <span class="info-value">
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
                        </span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">No. of Hours:</span>
                        <span class="info-value">{{ $training->no_of_hours ?? '' }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Date of Attendance:</span>
                        <span class="info-value">
                            @if($training->implementation_date_from && $training->implementation_date_to)
                                {{ $training->implementation_date_from->format('m/d/Y') }} - {{ $training->implementation_date_to->format('m/d/Y') }}
                            @elseif($training->implementation_date_from)
                                {{ $training->implementation_date_from->format('m/d/Y') }} - N/A
                            @elseif($training->implementation_date_to)
                                N/A - {{ $training->implementation_date_to->format('m/d/Y') }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Learning Service Provider:</span>
                        <span class="info-value">{{ $training->provider ?? '' }}</span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Status:</span>
                        <span class="info-value">{{ $training->status ?? '' }}</span>
                    </div>
                </div>
                
                <div class="action-buttons">
                    @if(Auth::check() && $training->participants()->where('users.id', Auth::id())->exists())
                    <a href="{{ route('user.training.profile.unprogram.edit', $training->id) }}" class="btn btn-edit">
                        <i class="bi bi-pencil-square"></i>
                        Edit
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>