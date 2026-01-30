<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lnd.dro7.depdev</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: rgb(187, 219, 252); font-family: Arial, sans-serif; }
        .navbar { background-color:#fff; box-shadow: 1px 3px 3px 0px #737373; }
        .navbar-brand { color:#003366 !important; font-size:1rem; font-weight:bold; display:flex; align-items:center; }
        .navbar-brand img { height:30px; margin-right:10px; }
        .user-menu { color:black !important; }
        .sidebar { background-color:#003366; min-height:calc(100vh - 56px); width:270px; padding-top:20px; position:fixed; top:56px; left:0; }
        .sidebar a { color:white; text-decoration:none; display:block; padding:12px 20px; font-size:0.9rem; }
        .sidebar a:hover, .sidebar a.active { background-color:#004080; font-weight:bold; }
        .main-content { margin-left:270px; margin-top:56px; padding:20px; }
        .content-header { background-color:#e7f1ff; padding:15px 20px; margin-bottom:20px; border-radius:5px; }
        .content-header h2 { color:#003366; font-size:1.5rem; margin:0; font-weight:bold; }
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
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('user.home') }}">
            <img src="/images/neda-logo.png" alt="NEDA Logo"> DEPDEV Region VII Learning and Development Database System
        </a>
        <div class="d-flex align-items-center">
            <div class="dropdown">
                <div class="user-menu" data-bs-toggle="dropdown" style="cursor:pointer;">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="profile-picture">
                    @else
                        <i class="bi bi-person-circle"></i>
                    @endif
                    <span>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                    <i class="bi bi-chevron-down ms-2"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<div class="sidebar">
    <a href="{{ route('user.home') }}" class="{{ request()->routeIs('user.home') ? 'active' : '' }}">
        <i class="bi bi-house-door me-2"></i> Home
    </a>
    <a href="{{ route('user.training.profile') }}" class="{{ request()->routeIs('user.training.profile*') ? 'active' : '' }}">
        <i class="bi bi-mortarboard me-2"></i> Training Profile
    </a>
    <a href="{{ route('user.tracking') }}" class="{{ request()->routeIs('user.tracking*') ? 'active' : '' }}">
        <i class="bi bi-calendar-check me-2"></i> Training Tracking and History
    </a>
    <a href="{{ route('user.training.effectiveness') }}" class="{{ request()->routeIs('user.training.effectiveness*') ? 'active' : '' }}">
        <i class="bi bi-graph-up me-2"></i> Training Effectiveness
    </a>
    <a href="{{ route('user.search') }}" class="{{ request()->routeIs('user.search*') ? 'active' : '' }}">
        <i class="bi bi-search me-2"></i> Search
    </a>
</div>

<div class="main-content">
    <div class="content-header">
        <h2><i class="bi bi-pencil-square me-2"></i>Edit Training Participation</h2>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $training->title }}</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.training.profile.program.update', $training->id) }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Training Title:</label>
                        <input type="text" class="form-control" value="{{ $training->title }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Training Type:</label>
                        <input type="text" class="form-control" value="{{ $training->type }}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 form-group">
                        <label class="form-label">Role:</label>
                        <select id="role" name="participation_type_id" class="form-control" required>
                            <option value="" disabled>Select Role</option>
                            @foreach ($participationTypes as $type)
                                <option value="{{ $type->id }}" {{ $training->participants->where('id', Auth::id())->first()?->pivot->participation_type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label">No. of Hours:</label>
                        <input type="number" step="any" min="0" name="no_of_hours" class="form-control" 
                               value="{{ $training->no_of_hours ?? '' }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 form-group">
                        <label class="form-label">Date of Attendance (From):</label>
                        <input type="date" name="implementation_date_from" class="form-control" 
                               value="{{ $training->implementation_date_from ? $training->implementation_date_from->format('Y-m-d') : '' }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label">Date of Attendance (To):</label>
                        <input type="date" name="implementation_date_to" class="form-control" 
                               value="{{ $training->implementation_date_to ? $training->implementation_date_to->format('Y-m-d') : '' }}">
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('user.training.profile.show', $training->id) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Update Training
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
