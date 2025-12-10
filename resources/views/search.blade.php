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

        .custom-clear-btn {
            color: #003366 !important;
            border: 1px solid #003366 !important;
            background: transparent !important;
            transition: background 0.2s, color 0.2s, border 0.2s;
        }

        .custom-clear-btn .bi {
            color: #003366 !important;
            transition: color 0.2s;
        }

        .custom-clear-btn:hover, .custom-clear-btn:focus {
            color: #fff !important;
            background: #003366 !important;
            border-color: #003366 !important;
        }

        .custom-clear-btn:hover .bi, .custom-clear-btn:focus .bi {
            color: #fff !important;
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
            <a href="{{ route('admin.training-plan') }}"><i class="bi bi-calendar-check me-2"></i>Training Profile</a>
            <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>Employees Information</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Training Plan</a>
            <a href="{{ route('admin.search.index') }}" class="active"><i class="bi bi-search me-2"></i>Search</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="search-card">
                <div class="search-header">
                    <h4 class="mb-0"><i class="bi bi-search me-2"></i>Customize Reports</h4>
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
                        <!-- Material Type Filter (only for Training Material) -->
                        <div class="col-md-3">
                            <label for="material_type" class="form-label">Material Type</label>
                            <select class="form-select" id="material_type" name="material_type" onchange="this.form.submit()">
                                <option value="">All Types</option>
                                <option value="material" {{ request('material_type') == 'material' ? 'selected' : '' }}>Materials</option>
                                <option value="link" {{ request('material_type') == 'link' ? 'selected' : '' }}>Links</option>
                                <option value="certificate" {{ request('material_type') == 'certificate' ? 'selected' : '' }}>Certificates</option>
                            </select>
                        </div>
                        <!-- Additional Filters -->
                        <div class="col-md-4 training-filter" style="display: none;">
                            <label for="year" class="form-label">Year of Implementation</label>
                            <input type="number" name="year" id="year" class="form-control"
                                placeholder="YYYY" min="2000" value="{{ request('year') }}">
                        </div>
                        <!-- Status Filter (only for Training) -->
                        <div class="col-md-4 training-status-filter" style="display: none;">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Select Status</option>
                                <option value="Implemented"
                                    {{ request('status') == 'Implemented' ? 'selected' : '' }}>Implemented</option>
                                <option value="Not Yet Implemented"
                                    {{ request('status') == 'Not Yet Implemented' ? 'selected' : '' }}>Not Yet
                                    Implemented</option>
                            </select>
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
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-2"></i>Search
                            </button>
                            <button type="button" class="btn btn-outline-primary custom-clear-btn ms-2" id="clear-search">
                                <i class="bi bi-x-circle me-1"></i>Clear
                            </button>
                        </div>
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
                <!-- ...your previous code... -->
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
                                <th>Status</th>
                                <th>Last Modified</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($results->where('search_type', 'training') as $result)
                            <tr>
                                <td>{{ $result->title }}</td>
                                <td>
                                    @if ($result->participants)
                                    @foreach ($result->participants as $participant)
                                    {{ $loop->iteration }}. {{ $participant['name'] }}
                                    @if(isset($participant['year']))
                                        <small class="text-muted d-block">{{ $participant['year'] }}</small>
                                    @endif
                                    <br>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if ($result->relatedMaterials && $result->relatedMaterials->isNotEmpty())
                                    @foreach ($result->relatedMaterials as $material)
                                    @if ($material->file_path)
                                    {{ $loop->iteration }}.
                                    <a href="{{ asset($material->file_path) }}" download>
                                        {{ $material->title }}
                                    </a><br>
                                    @else
                                    {{ $material->title }} (No file available)<br>
                                    @endif
                                    @endforeach
                                    @else
                                    No training materials available
                                    @endif
                                </td>
                                <td>
                                    {{-- Prefer status from DB, fallback to logic --}}
                                    @php
                                    $status = $result->status ?? 'Not Implemented';
                                    // Optionally: Fallback logic if status is not provided
                                    if (!isset($result->status)) {
                                    $implemented = false;
                                    // Here, use your actual TTH relation, e.g. $result->trainingTrackingHistories
                                    if (
                                    (!empty($result->participants)) ||
                                    (isset($result->trainingTrackingHistories) && $result->trainingTrackingHistories->count() > 0)
                                    ) {
                                    $implemented = true;
                                    }
                                    $status = $implemented ? 'Implemented' : 'Not Implemented';
                                    }
                                    @endphp
                                    {{ $status }}
                                </td>
                                <td>
                                    @if ($result->updated_at && $result->updated_at != $result->created_at)
                                    {{ $result->updated_at->format('Y-m-d H:i') }}
                                    @else
                                    {{ $result->created_at ? $result->created_at->format('Y-m-d H:i') : 'N/A' }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                <!-- ...your subsequent code... -->
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
                <!-- Grouped Training Materials by Training -->
                @if ($results instanceof \Illuminate\Pagination\LengthAwarePaginator && $results->getCollection()->where('search_type', 'training_material_group')->isNotEmpty())
                    @php
                        $selectedType = request('material_type');
                        $showTabs = empty($selectedType);
                    @endphp
                    
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-collection me-2"></i>
                                @if($showTabs)
                                    All Types
                                @else
                                    {{ ucfirst($selectedType) }}
                                @endif
                            </div>
                        </div>
                        
                        @if($showTabs)
                        <!-- Tabs Navigation (only show when All Types is selected) -->
                        <ul class="nav nav-tabs" id="materialsTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="materials-tab" data-bs-toggle="tab" 
                                    data-bs-target="#materials" type="button" role="tab" aria-controls="materials" 
                                    aria-selected="true">
                                    <i class="bi bi-file-earmark-pdf me-1"></i> Materials
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="links-tab" data-bs-toggle="tab" 
                                    data-bs-target="#links" type="button" role="tab" 
                                    aria-controls="links" aria-selected="false">
                                    <i class="bi bi-link-45deg me-1"></i> Links
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="certificates-tab" data-bs-toggle="tab" 
                                    data-bs-target="#certificates" type="button" role="tab" 
                                    aria-controls="certificates" aria-selected="false">
                                    <i class="bi bi-award me-1"></i> Certificates
                                </button>
                            </li>
                        </ul>
                        @endif
                        
                        <div class="tab-content p-3" id="materialsTabContent">
                            @if($showTabs)
                                <!-- Materials Tab (shown when All Types is selected) -->
                                <div class="tab-pane fade show active" id="materials" role="tabpanel" aria-labelledby="materials-tab">
                                    @include('partials.materials_section', [
                                        'materials' => $results->getCollection()->flatMap->materials->where('type', 'material'),
                                        'type' => 'material',
                                        'accordionId' => 'materialsAccordion',
                                        'emptyMessage' => 'No materials found'
                                    ])
                                </div>
                                
                                <!-- Links Tab (shown when All Types is selected) -->
                                <div class="tab-pane fade" id="links" role="tabpanel" aria-labelledby="links-tab">
                                    @include('partials.materials_section', [
                                        'materials' => $results->getCollection()->flatMap->materials->where('type', 'link'),
                                        'type' => 'link',
                                        'accordionId' => 'linksAccordion',
                                        'emptyMessage' => 'No links found'
                                    ])
                                </div>
                                
                                <!-- Certificates Tab (shown when All Types is selected) -->
                                <div class="tab-pane fade" id="certificates" role="tabpanel" aria-labelledby="certificates-tab">
                                    @include('partials.materials_section', [
                                        'materials' => $results->getCollection()->flatMap->materials->where('type', 'certificate'),
                                        'type' => 'certificate',
                                        'accordionId' => 'certificatesAccordion',
                                        'emptyMessage' => 'No certificates found'
                                    ])
                                </div>
                            @else
                                <!-- Single Type View (when a specific material type is selected) -->
                                <div class="tab-pane fade show active">
                                    @include('partials.materials_section', [
                                        'materials' => $results->getCollection()->flatMap->materials->where('type', $selectedType),
                                        'type' => $selectedType,
                                        'accordionId' => 'materialsAccordion',
                                        'emptyMessage' => 'No ' . $selectedType . ' found'
                                    ])
                                </div>
                            @endif
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
                                        <th>Type</th>
                                        <th>Action</th>
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
                                                @if ($result->type === 'material')
                                                    Material
                                                @elseif ($result->type === 'link')
                                                    Link
                                                @elseif ($result->type === 'certificate')
                                                    Certificate
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($result->file_path)
                                                    <a href="{{ route('user.training_materials.download', $result->id) }}" class="btn btn-sm btn-info">Download</a>
                                                @elseif ($result->link)
                                                    <a href="{{ $result->link }}" target="_blank" class="btn btn-sm btn-primary">Open Link</a>
                                                @else
                                                    N/A
                                                @endif
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
                @if ($results instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="d-flex justify-content-center mt-3">
                        {{ $results->links('pagination::bootstrap-5') }}
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

        function toggleMaterialTypeFilter() {
            const materialCheckbox = document.getElementById('type_material');
            const materialTypeFilter = document.querySelector('.material-type-filter');
            const trainingStatusFilter = document.querySelector('.training-status-filter');
            const trainingCheckbox = document.getElementById('type_training');
            if (materialCheckbox && materialCheckbox.checked) {
                materialTypeFilter.style.display = '';
                trainingStatusFilter.style.display = 'none';
            } else if (trainingCheckbox && trainingCheckbox.checked) {
                materialTypeFilter.style.display = 'none';
                trainingStatusFilter.style.display = '';
            } else {
                materialTypeFilter.style.display = 'none';
                trainingStatusFilter.style.display = 'none';
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            toggleMaterialTypeFilter();
            document.getElementById('type_material').addEventListener('change', toggleMaterialTypeFilter);
            document.getElementById('type_training').addEventListener('change', toggleMaterialTypeFilter);
        });

        document.getElementById('clear-search').addEventListener('click', function () {
            const form = this.closest('form');
            // Reset all form fields
            form.reset();

            // For multi-selects, clear selection
            const multiselects = form.querySelectorAll('select[multiple]');
            multiselects.forEach(sel => {
                for (const option of sel.options) {
                    option.selected = false;
                }
            });

            // Uncheck all checkboxes
            form.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);

            // Submit form with no params (redirect to base search)
            window.location.href = '{{ route('admin.search.index') }}';
        });
    </script>
</body>

</html>
