<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DEPDEV Learning and Development System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background-color: rgb(187, 219, 252);
            padding-top: 60px; /* Adjust this value based on your navbar height */
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
            margin-top: 30px;
            padding-bottom: 20px;
        }
        .content-header {
            background-color: #e7f1ff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .content-header h2 {
            color: #003366;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
        }
        .search-box {
            position: relative;
            width: 300px;
        }
        .search-box input {
            width: 100%;
            padding: 8px 15px;
            padding-right: 35px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        .search-box .search-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .btn-create {
            background-color: #003366;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .btn-create:hover {
            background-color: #004080;
            color: white;
        }
        .training-table {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .training-table th {
            background-color: #003366;
            color: white;
            font-weight: 500;
            padding: 12px 15px;
        }
        .training-table td {
            padding: 12px 15px;
            vertical-align: middle;
        }
        .training-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .btn-view {
            background-color: #4a90e2;
            color: white;
            padding: 5px 15px;
            border: none;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        .btn-view:hover {
            background-color: #357abd;
            color: white;
        }
        .dropdown-toggle::after {
            display: none;
        }
        .tab-buttons {
            display: inline-flex;
            gap: 5px;
        }
        .tab-button {
            background-color: transparent;
            border: none;
            padding: 8px 20px;
            font-weight: 500;
            color: #666;
            text-decoration: none;
            border-radius: 4px;
        }
        .tab-button:hover {
            text-decoration: none;
            color: #003366;
        }
        .tab-button.active {
            background-color: #003366;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.home') }}">
                <img src="/images/DEPDev_logo.png" alt="NEDA Logo">
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
            <div class="content-header">
                <h2>Training Program</h2>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="tab-buttons">
                    <a href="{{ route('admin.training-plan') }}" class="tab-button active">Programmed</a>
                    <a href="{{ route('admin.training-plan.unprogrammed') }}" class="tab-button">Unprogrammed</a>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('admin.training-plan.create') }}" class="btn btn-create">
                        <i class="bi bi-plus-circle"></i>
                        Create New
                    </a>
                    <a href="{{ route('admin.search.index') }}" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                        Advanced Search
                    </a>
                </div>
            </div>

            <div class="training-table mt-3">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Training Title</th>
                            <th>Competency</th>
                            <th>Period of Implementation</th>
                            <th>Training Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainings->sortByDesc('created_at') as $training)
                        <tr>
                            <td>{{ $training->title }}</td>
                            <td>{{ $training->competency->name }}</td>
                            <td>{{ $training->period_from ?? 'Not set' }} - {{ $training->period_to ?? 'Not set' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- <a href="{{ route('admin.training.view', $training->id) }}" class="btn btn-view"> -->
                                    <a href="{{ route('admin.training.view', $training->id) }}" class="btn btn-view">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                               <a class="dropdown-item" href="{{ route('admin.training-plan.edit', ['training' => $training->id]) }}">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                               </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.training-plan.destroy', $training->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this training?')">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addParticipantModal{{ $training->id }}">
                                                    <i class="bi bi-person-plus"></i> Add Participant
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Add Participant Modal -->
                        <div class="modal fade" id="addParticipantModal{{ $training->id }}" tabindex="-1" aria-labelledby="addParticipantModalLabel{{ $training->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addParticipantModalLabel{{ $training->id }}">Add Participant to {{ $training->title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.training-plan.add-participant', $training->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="participant{{ $training->id }}" class="form-label">Select Participant</label>
                                                <select class="form-select" id="participant{{ $training->id }}" name="user_id" required>
                                                    <option value="">Select a participant...</option>
                                                    @foreach(\App\Models\User::where('is_active', true)->get() as $user)
                                                        @if(!$training->participants->contains($user->id))
                                                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->position }})</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add Participant</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add search functionality
        document.querySelector('.search-box input').addEventListener('input', function(e) {
            // Add a small delay to prevent too many requests
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
    </script>
</body>
</html>
