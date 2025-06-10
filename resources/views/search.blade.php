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
            background-color: #f7f8fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .navbar {
            background-color: rgb(255, 255, 255);
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

        .nav-link,
        .user-icon,
        .user-menu {
            color: black !important;
            background-color: white !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        .sidebar a:hover,
        .sidebar a.active {
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

        .search-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 20px;
        }

        .search-header {
            border-bottom: 2px solid #003366;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 51, 102, 0.25);
        }

        .btn-primary {
            background-color: #003366;
            border-color: #003366;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: #003366;
        }

        .results-table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .results-table th {
            background-color: #003366;
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
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
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
            <a href="{{ route('admin.training-plan') }}"><i class="bi bi-calendar-check me-2"></i>Training Plan</a>
            <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>List of Participants</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
            <a href="{{ route('admin.search.index') }}" class="active"><i class="bi bi-search me-2"></i>Search</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="search-card">
                <div class="search-header">
                    <h4 class="mb-0"><i class="bi bi-search me-2"></i>Search and Export</h4>
                </div>
                <form action="{{ route('admin.search.results') }}" method="GET">
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
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="type[]" id="type_training"
                                        value="Training"
                                        {{ in_array('Training', request('type', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type_training">Training</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="type[]" id="type_user"
                                        value="User" {{ in_array('User', request('type', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type_user">User</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="type[]" id="type_material"
                                        value="Training Material"
                                        {{ in_array('Training Material', request('type', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type_material">Training Material</label>
                                </div>
                            </div>
                        </div>
                        <!-- Additional Filters -->
                        <div class="col-md-4 training-filter" style="display: none;">
                            <label for="year" class="form-label">Year of Implementation</label>
                            <input type="number" name="year" id="year" class="form-control" placeholder="YYYY"
                                min="2000" max="{{ date('Y') }}" value="{{ request('year') }}">
                        </div>
                        <div class="col-md-4 competency-filter" style="display: none;">
                            <label for="competencies" class="form-label">Competencies</label>
                            <select class="form-control" id="competencies" name="competencies[]" multiple>
                                @foreach ($competencies as $competency)
                                    <option value="{{ $competency->id }}"
                                        {{ in_array($competency->id, request('competencies', [])) ? 'selected' : '' }}>
                                        {{ $competency->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 user-filter" style="display: none;">
                            <label for="division" class="form-label">Division</label>
                            <select name="division" id="division" class="form-select">
                                <option value="">All Divisions</option>
                                @foreach ($divisions ?? [] as $division)
                                    <option value="{{ $division }}"
                                        {{ request('division') == $division ? 'selected' : '' }}>
                                        {{ $division }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 user-filter" style="display: none;">
                            <label for="position" class="form-label">Position</label>
                            <select name="position" id="position" class="form-select">
                                <option value="">All Positions</option>
                                @foreach ($positions ?? [] as $position)
                                    <option value="{{ $position }}"
                                        {{ request('position') == $position ? 'selected' : '' }}>
                                        {{ $position }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
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
                <!-- Results content here -->
                @if ($results->where('search_type', 'training')->isNotEmpty())
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-file-earmark-text me-2"></i>Training Found
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Training Title</th>
                                        <th>Participants</th>
                                        <th>Training Materials</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results->where('search_type', 'training') as $result)
                                        <tr>
                                            <td>{{ $result->title }}</td>
                                            <td>
                                                @if ($result->participants)
                                                    @foreach ($result->participants as $participant)
                                                    {{ $loop->iteration }}. {{ $participant['name'] }}<br>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @if ($result->relatedMaterials && $result->relatedMaterials->isNotEmpty())
                                                    @foreach ($result->relatedMaterials as $material)
                                                        @if ($material->file_path)
                                                        {{ $loop->iteration }}. <a href="{{ asset($material->file_path) }}" download>{{ $material->title }}</a><br>
                                                        @else
                                                            {{ $material->title }} (No file available)<br>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    No training materials available
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                <!-- Users Results -->
                @if ($results->where('search_type', 'user')->isNotEmpty())
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results->where('search_type', 'user') as $index => $result)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $result->last_name . ', ' . $result->first_name . ' ' . $result->mid_init . '.' ?? 'N/A' }}
                                            </td>
                                            <td>{{ $result->position ?? 'N/A' }}</td>
                                            <td>{{ $result->division ?? 'N/A' }}</td>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                <!-- Training Materials Results -->
                @if ($results->where('search_type', 'training_material')->isNotEmpty())
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-file-earmark-text me-2"></i>Training Materials Found
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Uploader</th>
                                        <th>Matched By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results->where('search_type', 'training_material') as $index => $result)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $result->title ?? 'N/A' }}</td>
                                            <td>
                                                @if ($result->user)
                                                    {{ $result->user->last_name . ', ' . $result->user->first_name . ' ' . $result->user->mid_init . '.' }}
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
                                                    if (
                                                        $result->user &&
                                                        (str_contains(
                                                            $result->user->first_name ?? '',
                                                            request('keyword'),
                                                        ) ||
                                                            str_contains(
                                                                $result->user->last_name ?? '',
                                                                request('keyword'),
                                                            ))
                                                    ) {
                                                        $matchedBy[] = 'Uploader Name';
                                                    }
                                                    if (
                                                        $result->competency &&
                                                        str_contains(
                                                            $result->competency->name ?? '',
                                                            request('keyword'),
                                                        )
                                                    ) {
                                                        $matchedBy[] = 'Competency';
                                                    }
                                                    if (
                                                        $result->training &&
                                                        str_contains($result->training->title ?? '', request('keyword'))
                                                    ) {
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
                @if ($results->isEmpty())
                    <div class="card text-center py-4">
                        <div class="card-body">
                            <i class="bi bi-search me-2"></i>No results found.
                        </div>
                    </div>
                @endif
            </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show/hide filters based on selected type
        document.querySelectorAll('input[name="type[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const selectedTypes = Array.from(document.querySelectorAll('input[name="type[]"]:checked'))
                    .map(cb => cb.value);
                // Hide all type-specific filters
                document.querySelectorAll('.training-filter, .user-filter, .material-filter').forEach(
                    el => {
                        el.style.display = 'none';
                    });
                // Show relevant filters based on selected types
                if (selectedTypes.includes('Training') || selectedTypes.includes('Training Material')) {
                    document.querySelectorAll('.training-filter, .material-filter').forEach(el => {
                        el.style.display = 'block';
                    });
                }
                if (selectedTypes.includes('User')) {
                    document.querySelectorAll('.user-filter').forEach(el => {
                        el.style.display = 'block';
                    });
                }
            });
        });
        // Trigger change event on page load to show correct filters
        document.querySelectorAll('input[name="type[]"]').forEach(checkbox => {
            if (checkbox.checked) {
                checkbox.dispatchEvent(new Event('change'));
            }
        });
        // Clear individual filters
        document.querySelectorAll('.filter-tag i').forEach(icon => {
            icon.addEventListener('click', function() {
                const filterName = this.parentElement.textContent.split(':')[0].trim().toLowerCase();
                const input = document.querySelector(`[name="${filterName}"]`);
                if (input) {
                    if (input.type === 'checkbox') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                    this.closest('form').submit();
                }
            });
        });
    </script>
</body>

</html>