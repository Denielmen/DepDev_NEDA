<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - DEPDEV</title>
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
        .profile-body {
            padding: 30px;
        }
        .form-label {
            font-weight: 600;
            color: #003366;
            margin-bottom: 8px;
        }
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #003366;
            box-shadow: 0 0 0 0.2rem rgba(0,51,102,0.25);
        }
        .btn-save {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            transition: transform 0.3s;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40,167,69,0.3);
            color: white;
        }
        .btn-cancel {
            background: #6c757d;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn-cancel:hover {
            background: #5a6268;
            color: white;
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
        .profile-picture-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #003366;
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
        @if(session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                Profile updated successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="profile-card">
            <div class="profile-header">
                <h2><i class="bi bi-pencil-square me-2"></i>Edit Profile</h2>
                <p class="mb-0 opacity-75">Update your personal information</p>
            </div>
            
            <div class="profile-body">
                <form method="POST" action="@if(Auth::user()->role === 'Admin'){{ route('admin.profile.update') }}@else{{ route('profile.update') }}@endif" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                       id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="mid_init" class="form-label">Middle Initial</label>
                                <input type="text" class="form-control @error('mid_init') is-invalid @enderror" 
                                       id="mid_init" name="mid_init" value="{{ old('mid_init', $user->mid_init) }}" maxlength="1">
                                @error('mid_init')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                       id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="position" class="form-label">Position</label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                       id="position" name="position" value="{{ old('position', $user->position) }}">
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="division" class="form-label">Division</label>
                                <input type="text" class="form-control @error('division') is-invalid @enderror" 
                                       id="division" name="division" value="{{ old('division', $user->division) }}">
                                @error('division')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="salary_grade" class="form-label">Salary Grade</label>
                                <input type="text" class="form-control @error('salary_grade') is-invalid @enderror" 
                                       id="salary_grade" name="salary_grade" value="{{ old('salary_grade', $user->salary_grade) }}">
                                @error('salary_grade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="position_start_date" class="form-label">Position Start Date</label>
                                <input type="date" class="form-control @error('position_start_date') is-invalid @enderror" 
                                       id="position_start_date" name="position_start_date" 
                                       value="{{ old('position_start_date', $user->position_start_date) }}">
                                @error('position_start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="government_start_date" class="form-label">Government Start Date</label>
                                <input type="date" class="form-control @error('government_start_date') is-invalid @enderror" 
                                       id="government_start_date" name="government_start_date" 
                                       value="{{ old('government_start_date', $user->government_start_date) }}">
                                @error('government_start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <div class="d-flex align-items-center">
                            @if($user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Current Profile Picture" class="profile-picture-preview me-3">
                            @else
                                <div class="profile-picture-preview me-3 d-flex align-items-center justify-content-center bg-light">
                                    <i class="bi bi-person-circle" style="font-size: 50px; color: #ccc;"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <input type="file" class="form-control @error('profile_picture') is-invalid @enderror" 
                                       id="profile_picture" name="profile_picture" accept="image/*">
                                <small class="text-muted">Choose a new profile picture (JPG, PNG, GIF - Max 2MB)</small>
                                @error('profile_picture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-save me-3">
                            <i class="bi bi-check-circle me-2"></i>Save Changes
                        </button>
                        @if(Auth::user()->role === 'Admin')
                            <a href="{{ route('admin.profile.show') }}" class="btn-cancel">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        @else
                            <a href="{{ route('profile.show') }}" class="btn-cancel">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
