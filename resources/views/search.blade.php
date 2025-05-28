<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #003366;
            --primary-hover: #004080;
            --secondary-color: #f8f9fa;
        }
        
        body {
            background-color: var(--secondary-color);
        }

        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .sidebar {
            background-color: var(--primary-color);
            min-height: calc(100vh - 56px);
            width: 270px;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: var(--primary-hover);
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        .search-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 20px;
        }

        .search-header {
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 51, 102, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .results-table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .results-table th {
            background-color: var(--primary-color);
            color: white;
        }

        .dropdown-menu {
            max-height: 200px;
            overflow-y: auto;
        }

        .filter-tag {
            background-color: #e9ecef;
            border-radius: 15px;
            padding: 5px 10px;
            margin-right: 5px;
            margin-bottom: 5px;
            display: inline-block;
        }

        .filter-tag i {
            cursor: pointer;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/neda-logo.png" alt="NEDA Logo" height="30">
                DEPDEV Learning and Development System
            </a>
            <div class="d-flex align-items-center">
                <i class="bi bi-bell-fill me-3"></i>
                <div class="dropdown">
                    <div class="dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> Admin
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

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="{{ route('admin.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('admin.training-plan') }}"><i class="bi bi-calendar-check me-2"></i>Training Plan</a>
            <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>List of Participants</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
            <a href="{{ route('search.index') }}" class="active"><i class="bi bi-search me-2"></i>Search</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="search-card">
                <div class="search-header">
                    <h4 class="mb-0"><i class="bi bi-search me-2"></i>Search and Export</h4>
                </div>
                
                <form action="{{ route('search.results') }}" method="GET">
                    <div class="row g-3">
                        <!-- Keyword Filter -->
                        <div class="col-md-6">
                            <label for="keyword" class="form-label">Search Item/s</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" name="keyword" id="keyword" class="form-control" 
                                       placeholder="Search" value="{{ request('keyword') }}">
                            </div>
                        </div>

                        <!-- Type Filter -->
                        <div class="col-md-4">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" id="type" class="form-select">
                                <option value="">Select Type</option>
                                <option value="training" {{ request('type') == 'training' ? 'selected' : '' }}>Training</option>
                                <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="training_material" {{ request('type') == 'training_material' ? 'selected' : '' }}>Training Material</option>
                            </select>
                        </div>

                        <!-- Year of Implementation Filter -->
                        <div class="col-md-4">
                            <label for="year" class="form-label">Year of Implementation</label>
                            <input type="number" name="year" id="year" class="form-control" 
                                   placeholder="YYYY" min="1900" max="{{ date('Y') }}" value="{{ request('year') }}">
                        </div>

                        <!-- Date Range Filter -->
                        <div class="col-md-6">
                            <label for="date_range" class="form-label">Date Range</label>
                            <div class="input-group">
                                <input type="date" name="date_from" class="form-control" 
                                       placeholder="From" value="{{ request('date_from') }}">
                                <span class="input-group-text">to</span>
                                <input type="date" name="date_to" class="form-control" 
                                       placeholder="To" value="{{ request('date_to') }}">
                            </div>
                        </div>

                        <!-- Status Filter (for Trainings) -->
                        <div class="col-md-4 training-filter" style="display: none;">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="Not Yet Implemented" {{ request('status') == 'Not Yet Implemented' ? 'selected' : '' }}>Not Yet Implemented</option>
                                <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <!-- Division Filter (for Users) -->
                        <div class="col-md-4 user-filter" style="display: none;">
                            <label for="division" class="form-label">Division</label>
                            <select name="division" id="division" class="form-select">
                                <option value="">All Divisions</option>
                                @foreach($divisions ?? [] as $division)
                                    <option value="{{ $division }}" {{ request('division') == $division ? 'selected' : '' }}>
                                        {{ $division }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- File Type Filter (for Training Materials) -->
                        <div class="col-md-4 material-filter" style="display: none;">
                            <label for="file_type" class="form-label">File Type</label>
                            <select name="file_type" id="file_type" class="form-select">
                                <option value="">All Types</option>
                                <option value="pdf" {{ request('file_type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                                <option value="doc" {{ request('file_type') == 'doc' ? 'selected' : '' }}>Word</option>
                                <option value="xls" {{ request('file_type') == 'xls' ? 'selected' : '' }}>Excel</option>
                                <option value="ppt" {{ request('file_type') == 'ppt' ? 'selected' : '' }}>PowerPoint</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <!-- Competencies Filter -->
                        <div class="col-md-6">
                            <label for="competencies" class="form-label">Competencies</label>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="competenciesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Select Competencies
                                </button>
                                <ul class="dropdown-menu px-3" aria-labelledby="competenciesDropdown">
                                    @php
                                    $availableCompetencies = [
                                        'competency_1' => 'Competency 1',
                                        'competency_2' => 'Competency 2',
                                        'competency_3' => 'Competency 3',
                                        'competency_4' => 'Competency 4',
                                    ];
                                    $selectedCompetencies = request('competencies', []);
                                    @endphp

                                    @foreach ($availableCompetencies as $value => $label)
                                        <li>
                                            <div class="form-check px-3 mb-2">
                                                <input class="form-check-input" type="checkbox" name="competencies[]" 
                                                       value="{{ $value }}" id="{{ $value }}" 
                                                       {{ in_array($value, $selectedCompetencies) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $value }}">{{ $label }}</label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Budget Range Filter (for Trainings) -->
                        <div class="col-md-6 training-filter" style="display: none;">
                            <label for="budget_range" class="form-label">Budget Range</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" name="budget_min" class="form-control" 
                                       placeholder="Min" value="{{ request('budget_min') }}">
                                <span class="input-group-text">to</span>
                                <input type="number" name="budget_max" class="form-control" 
                                       placeholder="Max" value="{{ request('budget_max') }}">
                            </div>
                        </div>

                        <!-- Salary Grade Filter (for Users) -->
                        <div class="col-md-4 user-filter" style="display: none;">
                            <label for="salary_grade" class="form-label">Salary Grade</label>
                            <select name="salary_grade" id="salary_grade" class="form-select">
                                <option value="">All Grades</option>
                                @for($i = 1; $i <= 33; $i++)
                                    <option value="{{ $i }}" {{ request('salary_grade') == $i ? 'selected' : '' }}>
                                        SG {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Active Filters -->
                    @if(request()->hasAny(['keyword', 'type', 'year', 'competencies']))
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="mt-2">
                                    <small class="text-muted">Active Filters:</small>
                                    @if(request('keyword'))
                                        <span class="filter-tag">
                                            Keyword: {{ request('keyword') }}
                                            <i class="bi bi-x-circle"></i>
                                        </span>
                                    @endif
                                    @if(request('type'))
                                        <span class="filter-tag">
                                            Type: {{ ucfirst(request('type')) }}
                                            <i class="bi bi-x-circle"></i>
                                        </span>
                                    @endif
                                    @if(request('year'))
                                        <span class="filter-tag">
                                            Year: {{ request('year') }}
                                            <i class="bi bi-x-circle"></i>
                                        </span>
                                    @endif
                                    @if(request('competencies'))
                                        @foreach(request('competencies') as $competency)
                                            <span class="filter-tag">
                                                Competency: {{ $availableCompetencies[$competency] ?? $competency }}
                                                <i class="bi bi-x-circle"></i>
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-2"></i>Search
                        </button>
                        <div>
                            <a href="{{ route('search.export', array_merge(['format' => 'pdf'], request()->query())) }}" 
                               class="btn btn-danger me-2">
                                <i class="bi bi-file-earmark-pdf me-2"></i>Export PDF
                            </a>
                            <a href="{{ route('search.export', array_merge(['format' => 'excel'], request()->query())) }}" 
                               class="btn btn-success">
                                <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div class="results-table">
                <!-- Users Results -->
                @if($results->where('search_type', 'user')->isNotEmpty())
                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <i class="bi bi-people me-2"></i>Users Found
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Division</th>
                                        <th>Matched By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results->where('search_type', 'user') as $index => $result)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $result->last_name.', '.$result->first_name.' '.$result->mid_init.'.' ?? 'N/A' }}</td>
                                            <td>{{ $result->position ?? 'N/A' }}</td>
                                            <td>{{ $result->division ?? 'N/A' }}</td>
                                            <td>
                                                @php
                                                    $matchedBy = [];
                                                    if (str_contains($result->first_name ?? '', request('keyword'))) {
                                                        $matchedBy[] = 'First Name';
                                                    }
                                                    if (str_contains($result->last_name ?? '', request('keyword'))) {
                                                        $matchedBy[] = 'Last Name';
                                                    }
                                                    if (str_contains($result->superior ?? '', request('keyword'))) {
                                                        $matchedBy[] = 'Superior';
                                                    }
                                                    if (str_contains($result->position ?? '', request('keyword'))) {
                                                        $matchedBy[] = 'Position';
                                                    }
                                                @endphp
                                                {{ implode(', ', $matchedBy) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- Trainings Results -->
                @if($results->where('search_type', 'training')->isNotEmpty())
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-calendar-check me-2"></i>Trainings Found
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Matched By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results->where('search_type', 'training') as $index => $result)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $result->title ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($result->implementation_date)->format('Y-m-d') ?? 'N/A' }}</td>
                                            <td>{{ $result->status ?? 'N/A' }}</td>
                                            <td>
                                                @php
                                                    $matchedBy = [];
                                                    if (str_contains($result->title ?? '', request('keyword'))) {
                                                        $matchedBy[] = 'Title';
                                                    }
                                                    $participants = $result->participants->filter(function($participant) {
                                                        return str_contains($participant->first_name ?? '', request('keyword')) ||
                                                               str_contains($participant->last_name ?? '', request('keyword')) ||
                                                               str_contains($participant->participation_type ?? '', request('keyword'));
                                                    });
                                                    if ($participants->isNotEmpty()) {
                                                        $matchedBy[] = 'Participant (' . $participants->count() . ' matches)';
                                                    }
                                                    if ($result->competency && str_contains($result->competency->name ?? '', request('keyword'))) {
                                                        $matchedBy[] = 'Competency';
                                                    }
                                                @endphp
                                                {{ implode(', ', $matchedBy) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- Training Materials Results -->
                @if($results->where('search_type', 'training_material')->isNotEmpty())
                    <div class="card mb-3">
                        <div class="card-header bg-success text-white">
                            <i class="bi bi-file-earmark-text me-2"></i>Training Materials Found
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>File Name</th>
                                        <th>Uploader</th>
                                        <th>Matched By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results->where('search_type', 'training_material') as $index => $result)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $result->title ?? 'N/A' }}</td>
                                            <td>{{ $result->file_name ?? 'N/A' }}</td>
                                            <td>
                                                @if($result->user)
                                                    {{ $result->user->last_name.', '.$result->user->first_name.' '.$result->user->mid_init.'.' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $matchedBy = [];
                                                    if (str_contains($result->title ?? '', request('keyword'))) {
                                                        $matchedBy[] = 'Title';
                                                    }
                                                    if (str_contains($result->file_name ?? '', request('keyword'))) {
                                                        $matchedBy[] = 'File Name';
                                                    }
                                                    if ($result->user && 
                                                        (str_contains($result->user->first_name ?? '', request('keyword')) ||
                                                         str_contains($result->user->last_name ?? '', request('keyword')))) {
                                                        $matchedBy[] = 'Uploader Name';
                                                    }
                                                    if ($result->competency && str_contains($result->competency->name ?? '', request('keyword'))) {
                                                        $matchedBy[] = 'Competency';
                                                    }
                                                    if ($result->training && str_contains($result->training->title ?? '', request('keyword'))) {
                                                        $matchedBy[] = 'Training Title';
                                                    }
                                                @endphp
                                                {{ implode(', ', $matchedBy) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- No Results Message -->
                @if($results->isEmpty())
                    <div class="card text-center py-4">
                        <div class="card-body">
                            <i class="bi bi-search me-2"></i>No results found.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show/hide filters based on selected type
        document.getElementById('type').addEventListener('change', function() {
            const type = this.value;
            
            // Hide all type-specific filters
            document.querySelectorAll('.training-filter, .user-filter, .material-filter').forEach(el => {
                el.style.display = 'none';
            });
            
            // Show relevant filters
            if (type === 'training') {
                document.querySelectorAll('.training-filter').forEach(el => {
                    el.style.display = 'block';
                });
            } else if (type === 'user') {
                document.querySelectorAll('.user-filter').forEach(el => {
                    el.style.display = 'block';
                });
            } else if (type === 'training_material') {
                document.querySelectorAll('.material-filter').forEach(el => {
                    el.style.display = 'block';
                });
            }
        });

        // Trigger change event on page load to show correct filters
        document.getElementById('type').dispatchEvent(new Event('change'));

        // Clear individual filters
        document.querySelectorAll('.filter-tag i').forEach(icon => {
            icon.addEventListener('click', function() {
                const filterName = this.parentElement.textContent.split(':')[0].trim().toLowerCase();
                const input = document.querySelector(`[name="${filterName}"]`);
                if (input) {
                    input.value = '';
                    this.closest('form').submit();
                }
            });
        });
    </script>
</body>
</html>
