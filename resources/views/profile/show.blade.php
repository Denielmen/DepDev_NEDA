<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - DEPDEV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #87CEEB 0%, #B0E0E6 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            color: #003366 !important;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .navbar-brand img {
            height: 30px;
            margin-right: 10px;
        }
        .user-menu {
            color: #003366;
            padding: 8px 15px;
            border-radius: 25px;
            transition: background-color 0.3s;
        }
        .user-menu:hover {
            background-color: rgba(0,51,102,0.1);
        }
        .profile-container {
            max-width: 800px;
            margin: 100px auto 50px;
            padding: 0 20px;
        }
        .profile-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .profile-header {
            background: linear-gradient(135deg, #003366 0%, #004080 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            margin: 0 auto 20px;
            object-fit: cover;
            background-color: #f8f9fa;
        }
        .profile-body {
            padding: 30px;
        }
        .info-group {
            margin-bottom: 25px;
        }
        .info-label {
            font-weight: 600;
            color: #003366;
            margin-bottom: 5px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-value {
            font-size: 1.1rem;
            color: #333;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .btn-edit {
            background: linear-gradient(135deg, #003366 0%, #004080 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            transition: transform 0.3s;
        }
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,51,102,0.3);
            color: white;
        }
        .btn-back {
            background: #6c757d;
            border: none;
            padding: 10px 25px;
            border-radius: 20px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn-back:hover {
            background: #5a6268;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/DEPDev_logo.png" alt="NEDA Logo">
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
                            @if(Auth::user()->role === 'Admin')
                                <a href="{{ route('admin.profile.edit') }}" class="dropdown-item">
                                    <i class="bi bi-person-gear text-primary me-2"></i> My Profile
                                </a>
                            @else
                                <a href="{{ route('profile.show') }}" class="dropdown-item">
                                    <i class="bi bi-person-gear text-primary me-2"></i> My Profile
                                </a>
                            @endif
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

    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                @if($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="profile-picture">
                @else
                    <div class="profile-picture d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-circle" style="font-size: 80px; color: #ccc;"></i>
                    </div>
                @endif
                <h2 class="mb-1">{{ $user->first_name }} {{ $user->mid_init ? $user->mid_init . '.' : '' }} {{ $user->last_name }}</h2>
                <p class="mb-0 opacity-75">{{ $user->position }}</p>
            </div>
            
            <div class="profile-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-group">
                            <div class="info-label">Employee ID</div>
                            <div class="info-value">{{ $user->user_id }}</div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">Position</div>
                            <div class="info-value">{{ $user->position }}</div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">Division</div>
                            <div class="info-value">{{ $user->division }}</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="info-group">
                            <div class="info-label">Salary Grade</div>
                            <div class="info-value">{{ $user->salary_grade }}</div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">Position Start Date</div>
                            <div class="info-value">{{ $user->position_start_date ? \Carbon\Carbon::parse($user->position_start_date)->format('F d, Y') : 'Not specified' }}</div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">Government Start Date</div>
                            <div class="info-value">{{ $user->government_start_date ? \Carbon\Carbon::parse($user->government_start_date)->format('F d, Y') : 'Not specified' }}</div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">Role</div>
                            <div class="info-value">{{ $user->role }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    @if(Auth::user()->role === 'Admin')
                        <a href="{{ route('admin.profile.edit') }}" class="btn btn-edit me-3">
                            <i class="bi bi-pencil-square me-2"></i>Edit Profile
                        </a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="btn btn-edit me-3">
                            <i class="bi bi-pencil-square me-2"></i>Edit Profile
                        </a>
                    @endif
                    @if(Auth::user()->role === 'Admin')
                        <a href="{{ route('admin.home') }}" class="btn-back">
                            <i class="bi bi-arrow-left me-2"></i>Go Back
                        </a>
                    @else
                        <a href="{{ route('user.home') }}" class="btn-back">
                            <i class="bi bi-arrow-left me-2"></i>Go Back
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
