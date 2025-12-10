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
    </style>
</head>
<body>
     <!-- Navbar -->
     <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/DEPDev_logo.png" alt="NEDA Logo">
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
                            <a href="{{ route('user.profile.info') }}" class="dropdown-item">
                                <i class="bi bi-person-lines-fill me-2"></i> Profile Info
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
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
        <a href="{{ route('user.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
        <a href="{{ route('user.training.profile') }}"><i class="bi bi-person-vcard me-2"></i>Individual Training Profile</a>
        <a href="{{ route('user.tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
        <a href="{{ route('user.training.effectiveness') }}"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
        <a href="{{ route('user.training.resources') }}"><i class="bi bi-archive me-2"></i>Training Resources</a>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="top-actions">
            <button class="btn btn-back" onclick="window.location.href='{{ route('user.home') }}'">
                <i class="bi bi-arrow-left"></i>
                Back
            </button>
        </div>

        <div class="row">
            <!-- User Info Card -->
            <div class="col-md-4">
                <div class="user-info-card text-center">
                    <div class="user-avatar" onclick="document.getElementById('profilePictureInput').click()" title="Click to upload profile picture">
                        @if($user->profile_picture && file_exists(public_path('storage/' . $user->profile_picture)))
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" id="profileImage">
                        @else
                            <i class="bi bi-person-circle" id="defaultIcon"></i>
                        @endif
                        <div class="avatar-overlay">
                            <i class="bi bi-camera"></i>
                            <small style="color: white; font-size: 0.7rem; margin-top: 5px;">Upload</small>
                        </div>
                    </div>
                    <input type="file" id="profilePictureInput" class="avatar-upload-input" accept="image/*" onchange="uploadProfilePicture(this)">
                    <div id="nameDisplay">
                        <h4>{{ $user->first_name }}{{ $user->mid_init ? ' ' . $user->mid_init . '.' : '' }} {{ $user->last_name }}</h4>
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
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <div id="saveCancelButtons" style="display: none;">
                            <button id="saveButton" class="btn btn-success me-2">
                                <i class="bi bi-check"></i> Save
                            </button>
                            <button id="cancelButton" class="btn btn-secondary">
                                <i class="bi bi-x"></i> Cancel
                            </button>
                        </div>
                    </div>
                    <form id="employeeForm" action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" readonly>
                            </div>
                            <div class="col-md-2 position-relative" style="padding-top: 1.5rem;">
                                <label class="form-label position-absolute" style="top: 0; left: 50%; transform: translateX(-50%);">MI</label>
                                <div class="d-flex justify-content-center align-items-end h-100">
                                    <input type="text" class="form-control text-center p-0" name="mid_init" value="{{ $user->mid_init ? substr($user->mid_init, 0, 1) : '' }}" readonly maxlength="1" style="text-transform: uppercase; width: 80px; font-size: 1rem; height: 37px; line-height: 37px; text-align: center;">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Employee ID</label>
                            <input type="text" class="form-control" name="user_id" value="{{ $user->user_id }}" readonly>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Salary Grade</label>
                                <select class="form-control" name="salary_grade" disabled>
    @for($i = 3; $i <= 28; $i++)
        <option value="{{ $i }}" {{ $user->salary_grade == $i ? 'selected' : '' }}>{{ $i }}</option>
    @endfor
</select>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Division/Unit</label>
                                <select class="form-control" name="division" disabled>
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
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Position Start Date</label>
                                <input type="date" class="form-control" name="position_start_date" value="{{ $user->position_start_date ? \Carbon\Carbon::parse($user->position_start_date)->format('Y-m-d') : '' }}" readonly>
                                <small class="text-muted">
                                    @if($user->position_start_date)
                                        {{ $user->getFormattedYearsInPosition() }} in current position (since {{ \Carbon\Carbon::parse($user->position_start_date)->format('F j, Y') }})
                                    @else
                                        Position start date not set
                                    @endif
                                </small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Government Start Date</label>
                                <input type="date" class="form-control" name="government_start_date" value="{{ $user->government_start_date ? \Carbon\Carbon::parse($user->government_start_date)->format('Y-m-d') : '' }}" readonly>
                                <small class="text-muted">
                                    @if($user->government_start_date)
                                        {{ $user->getFormattedYearsInGovernment() }} in government service (since {{ \Carbon\Carbon::parse($user->government_start_date)->format('F j, Y') }})
                                    @else
                                        Government start date not set
                                    @endif
                                </small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Position</label>
                            <input type="text" class="form-control" name="position" value="{{ $user->position }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name of Immediate Supervisor (Last, First, MI)</label>
                            <input type="text" class="form-control" name="superior" value="{{ $user->superior }}" readonly>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function uploadProfilePicture(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    return;
                }
                
                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB.');
                    return;
                }
                
                const formData = new FormData();
                formData.append('profile_picture', file);
                formData.append('_token', '{{ csrf_token() }}');
                
                // Show loading state
                const avatar = document.querySelector('.user-avatar');
                const originalContent = avatar.innerHTML;
                avatar.innerHTML = '<i class="bi bi-hourglass-split" style="font-size: 2rem; color: #6c757d;"></i>';
                
                fetch('{{ route("user.profile.upload-picture") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the image
                        const profileImage = document.getElementById('profileImage');
                        const defaultIcon = document.getElementById('defaultIcon');
                        
                        if (profileImage) {
                            profileImage.src = data.image_url + '?t=' + new Date().getTime();
                        } else {
                            // Replace default icon with image
                            avatar.innerHTML = `
                                <img src="${data.image_url}?t=${new Date().getTime()}" alt="Profile Picture" id="profileImage" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                <div class="avatar-overlay">
                                    <i class="bi bi-camera"></i>
                                    <small style="color: white; font-size: 0.7rem; margin-top: 5px;">Upload</small>
                                </div>
                            `;
                        }
                        
                        // Update navbar image if exists
                        const navbarImage = document.querySelector('.profile-picture');
                        if (navbarImage) {
                            navbarImage.src = data.image_url + '?t=' + new Date().getTime();
                        }
                        
                        alert('Profile picture updated successfully!');
                    } else {
                        alert('Error: ' + data.message);
                        avatar.innerHTML = originalContent;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while uploading the image.');
                    avatar.innerHTML = originalContent;
                });
            }
        }

        // Edit functionality
        document.addEventListener('DOMContentLoaded', function() {
            const editButton = document.getElementById('editButton');
            const saveButton = document.getElementById('saveButton');
            const cancelButton = document.getElementById('cancelButton');
            const saveCancelButtons = document.getElementById('saveCancelButtons');
            const form = document.getElementById('employeeForm');
            
            // Store original values
            let originalValues = {};
            
            function storeOriginalValues() {
                const inputs = form.querySelectorAll('input, select');
                inputs.forEach(input => {
                    originalValues[input.name] = input.value;
                });
            }
            
            function restoreOriginalValues() {
                const inputs = form.querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (originalValues[input.name] !== undefined) {
                        input.value = originalValues[input.name];
                    }
                });
            }
            
            function toggleEditMode(isEditing) {
                const inputs = form.querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (input.name === 'first_name' || input.name === 'last_name' || input.name === 'user_id') {
                        // Keep these fields readonly
                        input.readOnly = true;
                        if (input.tagName === 'SELECT') {
                            input.disabled = true;
                        }
                    } else {
                        input.readOnly = !isEditing;
                        if (input.tagName === 'SELECT') {
                            input.disabled = !isEditing;
                        }
                    }
                });
                
                editButton.style.display = isEditing ? 'none' : 'block';
                saveCancelButtons.style.display = isEditing ? 'block' : 'none';
            }
            
            editButton.addEventListener('click', function() {
                storeOriginalValues();
                toggleEditMode(true);
            });
            
            cancelButton.addEventListener('click', function() {
                restoreOriginalValues();
                toggleEditMode(false);
            });
            
            saveButton.addEventListener('click', function() {
                // Show loading state
                saveButton.disabled = true;
                saveButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Saving...';
                
                // Submit the form
                const formData = new FormData(form);
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Profile updated successfully!');
                        toggleEditMode(false);
                        // Update the display name if it changed
                        const nameDisplay = document.querySelector('#nameDisplay h4');
                        if (nameDisplay) {
                            const middleInitial = data.user.mid_init ? ' ' + data.user.mid_init + '.' : '';
                            nameDisplay.textContent = data.user.first_name + middleInitial + ' ' + data.user.last_name;
                        }
                    } else {
                        alert('Error: ' + (data.message || 'Failed to update profile'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the profile.');
                })
                .finally(() => {
                    saveButton.disabled = false;
                    saveButton.innerHTML = '<i class="bi bi-check"></i> Save';
                });
            });
        });
    </script>
</body>
</html>
