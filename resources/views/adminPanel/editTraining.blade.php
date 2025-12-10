{{-- filepath: d:\tests\04-27\DepDev_NEDA\resources\views\adminPanel\editTraining.blade.php --}}
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
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background-color: rgb(187, 219, 252);
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
            background-color: rgb(187, 219, 252);
            min-height: calc(100vh - 56px);
            margin-left: 270px;
            width: calc(100% - 270px);
        }
        .training-header {
            background-color: #e7f1ff;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 5px;
            width: 55rem;
            margin-left:4rem;
        }
        .training-header h2 {
            font-size: 1.5rem;
            margin-bottom: 0;
            color: #003366;
        }
        .training-card {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
            padding: 1.5rem;
            max-width: 900px;
            margin: 0 auto;
        }
        .training-card h4, .mb-0 {
            font-weight: bold;
        }
        .participant-row {
            transition: background-color 0.2s;
        }
        .participant-row:hover {
            background-color: #f8f9fa;
        }
        .modal-body {
            max-height: 60vh;
            overflow-y: auto;
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
            <a href="{{ route('admin.training-plan') }}" class="active"><i class="bi bi-calendar-check me-2"></i>Training Profile</a>
            <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>Employees Information</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Training Plan</a>
            <a href="{{ route('admin.search.index') }}"><i class="bi bi-search me-2"></i>Search</a>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 main-content p-4" style="margin-top: 56px;">
            <div class="mb-4 training-header">
                <h2 class="mb-0">Edit Training</h2>
            </div>
            <div class="training-card">
                <h4 class="text-center mb-4">Training Information</h4>
                <form action="{{ route('admin.training-plan.update', $training) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" value="{{ $training->type }}">
                    <input type="hidden" name="id" value="{{ $training->id }}">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title/Subject Area:</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $training->title }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="core_competency" class="form-label">Type:</label>
                            <select class="form-control" id="core_competency" name="core_competency" required onchange="toggleCoreCompetencyInputEdit()">
                                <option value="">Select Core Competency...</option>
                                <option value="Foundational/Mandatory" {{ $training->core_competency === 'Foundational/Mandatory' ? 'selected' : '' }}>Foundational/Mandatory</option>
                                <option value="Competency Enhancement" {{ $training->core_competency === 'Competency Enhancement' ? 'selected' : '' }}>Competency Enhancement</option>
                                <option value="Leadership/Executive Development" {{ $training->core_competency === 'Leadership/Executive Development' ? 'selected' : '' }}>Leadership/Executive Development</option>
                                <option value="Gender and Development (GAD)-Related" {{ $training->core_competency === 'Gender and Development (GAD)-Related' ? 'selected' : '' }}>Gender and Development (GAD)-Related</option>
                                <option value="Others" {{ !in_array($training->core_competency, ['Foundational/Mandatory', 'Competency Enhancement', 'Leadership/Executive Development', 'Gender and Development (GAD)-Related', '']) ? 'selected' : '' }}>Others</option>
                            </select>
                            <input type="text" class="form-control mt-2"
                                id="core_competency_input_edit" name="core_competency_input"
                                placeholder="Enter core competency" value="{{ $training->core_competency && !in_array($training->core_competency, ['Foundational/Mandatory', 'Competency Enhancement', 'Leadership/Executive Development', 'Gender and Development (GAD)-Related', 'Others', '']) ? $training->core_competency : '' }}" style="display: none;">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="competency" class="form-label">Competency</label>
                            <select class="form-control @error('competency_id') is-invalid @enderror" id="competency" name="competency_id" required onchange="toggleCompetencyInputEdit()">
                                <option value="">Select Competency</option>
                                @foreach($competencies as $competency)
                                    <option value="{{ $competency->id }}" {{ $training->competency_id == $competency->id ? 'selected' : '' }}>
                                        {{ $competency->name }}
                                    </option>
                                @endforeach
                                <option value="others" {{ old('competency_id') == 'others' ? 'selected' : '' }}>Others</option>
                            </select>
                            <input type="text" class="form-control mt-2 @error('competency_input') is-invalid @enderror"
                                id="competency_input_edit" name="competency_input"
                                placeholder="Enter custom competency" value="{{ old('competency_input') }}" style="display: none;">
                            @error('competency_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('competency_input')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="col-md-6">
                            <label for="implementation_date_from" class="form-label">Year of Implementation:</label>
                            <input type="date" class="form-control" id="implementation_date_from" name="implementation_date_from" value="{{ $training->implementation_date_from ? $training->implementation_date_from->format('Y-m-d') : '' }}" required>
                        </div> --}}
                         <div class="col-md-6">
                            <label for="period_from" class="form-label">Three-Year Period:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="period_from" name="period_from" value="{{ $training->period_from }}" placeholder="From Year" min="2000" max="2100" required onchange="calculateThreeYearPeriod()">
                                <span class="input-group-text">to</span>
                                <input type="number" class="form-control" id="period_to" name="period_to" value="{{ $training->period_to }}" placeholder="To Year" min="2000" max="2100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="budget" class="form-label">Budget (per hour):</label>
                            <input type="number" class="form-control" id="budget" name="budget" value="{{ $training->budget }}">
                        </div>
                        <div class="col-md-6">
                            <label for="no_of_hours" class="form-label">No. of Hours:</label>
                            <input type="number" class="form-control" id="no_of_hours" name="no_of_hours" value="{{ $training->no_of_hours }}">
                        </div>
                    </div>
                    <div class="md-3">
                            <label for="provider" class="form-label">Learning Service Provider:</label>
                            <input type="text" class="form-control" id="provider" name="provider" value="{{ $training->provider }}">
                    </div>

                    <div class="mb-3">
                        <label for="dev_target" class="form-label">Development Target:</label>
                        <textarea class="form-control" id="dev_target" name="dev_target" rows="2">{{ $training->dev_target }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="performance_goal" class="form-label">Performance Goal this Supports:</label>
                        <textarea class="form-control" id="performance_goal" name="performance_goal" rows="2">{{ $training->performance_goal }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="objective" class="form-label">Objective:</label>
                        <textarea class="form-control" id="objective" name="objective" rows="2">{{ $training->objective }}</textarea>
                    </div>

                    <h5 class="mt-4">Participants ({{ $training->participants->count() }})</h5>
                    <div id="selectedParticipantsContainer" class="mb-3">
                        <div id="selectedParticipants">
                            @if($training->participants->count() > 0)
                                @foreach ($training->participants as $participant)
                                    <div class="d-flex justify-content-between align-items-center mb-1 p-2 border rounded" data-user-id="{{ $participant->id }}" data-year="{{ $participant->pivot->year ?? date('Y') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">{{ $participant->last_name }}, {{ $participant->first_name }} {{ $participant->mid_init }}</span>
                                            <span class="badge bg-info me-1">{{ $participationTypes->get($participant->pivot->participation_type_id)->name ?? 'N/A' }}</span>
                                            <span class="badge bg-success">CY-{{ $participant->pivot->year ?? date('Y') }}</span>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-danger remove-participant" data-user-id="{{ $participant->id }}" data-year="{{ $participant->pivot->year ?? date('Y') }}">
                                                <i class="bi bi-x"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="participants[]" value="{{ $participant->id }}">
                                    <input type="hidden" name="participation_types[{{ $participant->id }}_{{ $participant->pivot->year ?? date('Y') }}]" value="{{ $participant->pivot->participation_type_id }}">
                                    <input type="hidden" name="participant_years[{{ $participant->id }}_{{ $participant->pivot->year ?? date('Y') }}]" value="{{ $participant->pivot->year ?? date('Y') }}">
                                @endforeach
                            @else
                                <p class="text-muted">No participants added yet.</p>
                            @endif
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#participantModal">
                            <i class="bi bi-person-plus"></i> Add Participant
                        </button>
                        <button type="submit" class="btn btn-success me-2">
                            <i class="bi bi-save"></i> Save Changes
                        </button>
                        <a href="{{ route('admin.training-plan') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </form>

                @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Participant List Modal -->
    <div class="modal fade" id="participantModal" tabindex="-1" aria-labelledby="participantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="participantModalLabel">Add Participants</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" id="participantSearch" class="form-control" placeholder="Search participants...">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Division</th>
                                    <th>Participation Type</th>
                                    <th>Year</th>
                                    <th>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="selectAllParticipants">
                                            <label class="form-check-label" for="selectAllParticipants">
                                                Select All
                                            </label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="participantTableBody">
                                @foreach($users as $user)
                                <tr class="participant-row">
                                    <td>{{ $user->last_name }}, {{ $user->first_name }} {{ $user->mid_init }}</td>
                                    <td>{{ $user->position }}</td>
                                    <td>{{ $user->division }}</td>
                                    <td>
                                        <select class="form-select participation-type" data-user-id="{{ $user->id }}">
                                            @foreach($participationTypes as $type)
                                                <option value="{{ $type->id }}" {{ strtolower($type->name) == 'participant' ? 'selected' : '' }}>{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-select participant-year" data-user-id="{{ $user->id }}">
                                            @php
                                                $currentYear = date('Y');
                                                $periodFrom = $training->period_from;
                                                // Default to current year if it's within the training period, otherwise default to period_from
                                                $defaultYear = ($currentYear >= $periodFrom && $currentYear <= $periodFrom + 2) ? $currentYear : $periodFrom;
                                            @endphp
                                            <option value="{{ $periodFrom }}" {{ $defaultYear == $periodFrom ? 'selected' : '' }}>CY-{{ $periodFrom }}</option>
                                            <option value="{{ $periodFrom+1 }}" {{ $defaultYear == $periodFrom + 1 ? 'selected' : '' }}>CY-{{ $periodFrom+1 }}</option>
                                            <option value="{{ $periodFrom+2 }}" {{ $defaultYear == $periodFrom + 2 ? 'selected' : '' }}>CY-{{ $periodFrom+2 }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="form-check-input participant-checkbox" data-user-id="{{ $user->id }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Controls -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div id="participantPaginationInfo" class="text-muted">
                            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} participants
                        </div>
                        <nav aria-label="Participant pagination">
                            <ul class="pagination pagination-sm mb-0" id="participantPagination">
                                @if ($users->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="#" data-page="{{ $users->currentPage() - 1 }}">Previous</a></li>
                                @endif

                                @for ($i = 1; $i <= $users->lastPage(); $i++)
                                    @if ($i == $users->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="#" data-page="{{ $i }}">{{ $i }}</a></li>
                                    @endif
                                @endfor

                                @if ($users->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="#" data-page="{{ $users->currentPage() + 1 }}">Next</a></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                                @endif
                            </ul>
                        </nav>
                    </div>

                    <!-- Loading indicator -->
                    <div id="participantLoading" class="text-center py-3" style="display: none;">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="ms-2">Loading participants...</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="removeAllSelectionBtn">
                        <i class="bi bi-x-circle"></i> Remove All Selection
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addSelectedParticipantsBtn">Add Selected</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Calculate three-year period
        function calculateThreeYearPeriod() {
            const fromYearInput = document.getElementById('period_from');
            const toYearInput = document.getElementById('period_to');
            const fromYear = parseInt(fromYearInput.value);

            if (fromYear && !isNaN(fromYear)) {
                const toYear = fromYear + 2; // 3-year period: from year + 2 = to year
                toYearInput.value = toYear;
            }
        }

        // Function to check for duplicate participant-year combinations
        function checkDuplicateParticipantYear(userId, year) {
            const form = document.querySelector('form[action*="training-plan"]');

            // Check existing participants in the form (hidden inputs)
            // Look for user_year key format
            const userYearKey = `${userId}_${year}`;
            const existingYearInput = form.querySelector(`input[name="participant_years[${userYearKey}]"]`);

            if (existingYearInput) {
                return true; // Duplicate found
            }

            // Also check the displayed participants (in case they're already shown but not yet in hidden inputs)
            const selectedParticipantsDiv = document.getElementById('selectedParticipants');
            const participantDivs = selectedParticipantsDiv.querySelectorAll('.d-flex');

            for (let div of participantDivs) {
                const removeButton = div.querySelector('.remove-participant');
                if (removeButton && removeButton.dataset.userId === userId) {
                    const yearBadge = div.querySelector('.badge.bg-success');
                    if (yearBadge && yearBadge.textContent.includes(`CY-${year}`)) {
                        return true; // Duplicate found in displayed participants
                    }
                }
            }

            return false; // No duplicate found
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action*="training-plan"]');
            const selectedParticipantsDiv = document.getElementById('selectedParticipants');
            const addSelectedParticipantsBtn = document.getElementById('addSelectedParticipantsBtn');
            const selectAllCheckbox = document.getElementById('selectAllParticipants');
            const removeAllSelectionBtn = document.getElementById('removeAllSelectionBtn');

            // Global array to track all selected participants across pages
            let globalSelectedParticipants = new Set();

            // Initialize event listeners
            initializeParticipantEventListeners();

            // Handle Remove All Selection functionality
            removeAllSelectionBtn.addEventListener('click', function() {
                // Clear global selection
                globalSelectedParticipants.clear();

                // Uncheck all visible checkboxes
                document.querySelectorAll('.participant-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Update select all state
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            });

            // Handle search functionality
            const participantSearch = document.getElementById('participantSearch');
            let searchTimeout;

            participantSearch.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    loadParticipants(1, this.value);
                }, 300);
            });

            // Load participants when modal is shown
            document.getElementById('participantModal').addEventListener('shown.bs.modal', function() {
                loadParticipants(1, '');
            });

            // Handle pagination clicks
            document.addEventListener('click', function(e) {
                if (e.target.matches('#participantPagination a.page-link')) {
                    e.preventDefault();
                    const page = e.target.getAttribute('data-page');
                    const search = participantSearch.value;
                    loadParticipants(page, search);
                }
            });

            // Function to load participants via AJAX
            function loadParticipants(page = 1, search = '') {
                const loading = document.getElementById('participantLoading');
                const tableBody = document.getElementById('participantTableBody');
                const paginationInfo = document.getElementById('participantPaginationInfo');
                const pagination = document.getElementById('participantPagination');

                loading.style.display = 'block';
                tableBody.style.opacity = '0.5';

                fetch(`{{ route('admin.getParticipants') }}?page=${page}&search=${encodeURIComponent(search)}&training_id={{ $training->id }}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update table body
                        tableBody.innerHTML = '';
                        data.users.forEach(user => {
                            const row = createParticipantRow(user, data.participation_types);
                            tableBody.appendChild(row);
                        });

                        // Restore selection state for current page
                        document.querySelectorAll('.participant-checkbox').forEach(checkbox => {
                            const userId = checkbox.getAttribute('data-user-id');
                            checkbox.checked = globalSelectedParticipants.has(userId);
                        });

                        // Update pagination info
                        paginationInfo.textContent = `Showing ${data.pagination.from || 0} to ${data.pagination.to || 0} of ${data.pagination.total} participants`;

                        // Update pagination controls
                        updatePaginationControls(data.pagination);

                        // Re-initialize event listeners for new elements
                        initializeParticipantEventListeners();

                        loading.style.display = 'none';
                        tableBody.style.opacity = '1';
                    })
                    .catch(error => {
                        console.error('Error loading participants:', error);
                        loading.style.display = 'none';
                        tableBody.style.opacity = '1';
                        alert('Error loading participants. Please try again.');
                    });
            }

            // Function to create participant row
            function createParticipantRow(user, participationTypes) {
                const row = document.createElement('tr');
                row.className = 'participant-row';

                // Find the "Participant" type ID for default selection
                const participantType = participationTypes.find(type => type.name.toLowerCase() === 'participant');
                const defaultTypeId = participantType ? participantType.id : '';
                
                // Calculate default year
                const currentYear = new Date().getFullYear();
                const periodFrom = {{ $training->period_from }};
                const defaultYear = (currentYear >= periodFrom && currentYear <= periodFrom + 2) ? currentYear : periodFrom;

                let participationTypeOptions = '';
                participationTypes.forEach(type => {
                    const selected = type.id === defaultTypeId ? 'selected' : '';
                    participationTypeOptions += `<option value="${type.id}" ${selected}>${type.name}</option>`;
                });

                row.innerHTML = `
                    <td>${user.last_name}, ${user.first_name} ${user.mid_init || ''}</td>
                    <td>${user.position || ''}</td>
                    <td>${user.division || ''}</td>
                    <td>
                        <select class="form-select participation-type" data-user-id="${user.id}">
                            ${participationTypeOptions}
                        </select>
                    </td>
                    <td>
                        <select class="form-select participant-year" data-user-id="${user.id}">
                            <option value="${periodFrom}" ${defaultYear == periodFrom ? 'selected' : ''}>CY-${periodFrom}</option>
                            <option value="${periodFrom+1}" ${defaultYear == periodFrom + 1 ? 'selected' : ''}>CY-${periodFrom+1}</option>
                            <option value="${periodFrom+2}" ${defaultYear == periodFrom + 2 ? 'selected' : ''}>CY-${periodFrom+2}</option>
                        </select>
                    </td>
                    <td>
                        <input type="checkbox" class="form-check-input participant-checkbox" data-user-id="${user.id}">
                    </td>
                `;

                return row;
            }

            // Function to update pagination controls
            function updatePaginationControls(pagination) {
                const paginationContainer = document.getElementById('participantPagination');
                let paginationHTML = '';

                // Previous button
                if (pagination.current_page === 1) {
                    paginationHTML += '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
                } else {
                    paginationHTML += `<li class="page-item"><a class="page-link" href="#" data-page="${pagination.current_page - 1}">Previous</a></li>`;
                }

                // Page numbers
                for (let i = 1; i <= pagination.last_page; i++) {
                    if (i === pagination.current_page) {
                        paginationHTML += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                    } else {
                        paginationHTML += `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
                    }
                }

                // Next button
                if (pagination.current_page === pagination.last_page) {
                    paginationHTML += '<li class="page-item disabled"><span class="page-link">Next</span></li>';
                } else {
                    paginationHTML += `<li class="page-item"><a class="page-link" href="#" data-page="${pagination.current_page + 1}">Next</a></li>`;
                }

                paginationContainer.innerHTML = paginationHTML;
            }

            // Function to initialize event listeners for participant elements
            function initializeParticipantEventListeners() {
                const newSelectAllCheckbox = document.getElementById('selectAllParticipants');
                const newParticipantCheckboxes = document.querySelectorAll('.participant-checkbox');

                // Re-bind Select All functionality
                newSelectAllCheckbox.removeEventListener('change', handleSelectAll);
                newSelectAllCheckbox.addEventListener('change', handleSelectAll);

                // Re-bind individual checkbox functionality
                newParticipantCheckboxes.forEach(checkbox => {
                    checkbox.removeEventListener('change', handleIndividualCheckbox);
                    checkbox.addEventListener('change', handleIndividualCheckbox);
                });
            }

            // Event handler functions
            function handleSelectAll() {
                const isChecked = this.checked;

                if (isChecked) {
                    // Select ALL participants across all pages
                    selectAllParticipantsGlobally();
                } else {
                    // Deselect ALL participants
                    globalSelectedParticipants.clear();
                    document.querySelectorAll('.participant-checkbox').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    updateSelectAllState();
                }
            }

            function handleIndividualCheckbox() {
                const userId = this.getAttribute('data-user-id');

                if (this.checked) {
                    globalSelectedParticipants.add(userId);
                } else {
                    globalSelectedParticipants.delete(userId);
                }

                updateSelectAllState();
            }

            function selectAllParticipantsGlobally() {
                // Show loading
                const loading = document.getElementById('participantLoading');
                loading.style.display = 'block';

                // Fetch all participants (without pagination)
                const search = document.getElementById('participantSearch').value;
                fetch(`{{ route('admin.getParticipants') }}?all=true&search=${encodeURIComponent(search)}&training_id={{ $training->id }}`)
                    .then(response => response.json())
                    .then(data => {
                        // Add all participants to global selection
                        data.users.forEach(user => {
                            globalSelectedParticipants.add(user.id.toString());
                        });

                        // Update current page checkboxes
                        document.querySelectorAll('.participant-checkbox').forEach(checkbox => {
                            const userId = checkbox.getAttribute('data-user-id');
                            checkbox.checked = globalSelectedParticipants.has(userId);
                        });

                        updateSelectAllState();
                        loading.style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Error selecting all participants:', error);
                        loading.style.display = 'none';
                        alert('Error selecting all participants. Please try again.');
                    });
            }

            function updateSelectAllState() {
                const selectAllCheckbox = document.getElementById('selectAllParticipants');
                const currentPageCheckboxes = document.querySelectorAll('.participant-checkbox');
                const currentPageUserIds = Array.from(currentPageCheckboxes).map(cb => cb.getAttribute('data-user-id'));

                const currentPageSelectedCount = currentPageUserIds.filter(id => globalSelectedParticipants.has(id)).length;
                const totalCurrentPageCount = currentPageUserIds.length;

                if (currentPageSelectedCount === 0) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                } else if (currentPageSelectedCount === totalCurrentPageCount) {
                    // Check if ALL participants across all pages are selected
                    // For now, we'll show indeterminate if some are selected
                    selectAllCheckbox.checked = globalSelectedParticipants.size > totalCurrentPageCount;
                    selectAllCheckbox.indeterminate = !selectAllCheckbox.checked;
                } else {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = true;
                }
            }



            // Handle adding selected participants
            addSelectedParticipantsBtn.addEventListener('click', function() {
                // Use global selection instead of just visible checkboxes
                if (globalSelectedParticipants.size === 0) {
                    alert('Please select at least one participant.');
                    return;
                }

                // Get all selected participants data
                addSelectedParticipantsFromGlobal();

                const selected = [];
                let missingParticipationType = false;
                let missingParticipationYear = false;

                checkedCheckboxes.forEach((checkbox) => {
                    const userId = checkbox.dataset.userId;
                    const participantRow = checkbox.closest('.participant-row');
                    const participationTypeSelect = participantRow.querySelector('.participation-type');
                    const participationTypeId = participationTypeSelect.value;
                    const participantYearSelect = participantRow.querySelector('.participant-year');
                    const participantYear = participantYearSelect.value;
                    const participantName = participantRow.querySelector('td:first-child').textContent;
                    const participationTypeName = participationTypeSelect.options[participationTypeSelect.selectedIndex].text;

                    // Validate participation type and year are selected
                    if (!participationTypeId) {
                        missingParticipationType = true;
                        return;
                    }

                    if (!participantYear) {
                        missingParticipationYear = true;
                        return;
                    }

                    // Add to selected array
                    selected.push({
                        userId,
                        participationTypeId,
                        participantYear,
                        participantName,
                        participationTypeName
                    });
                });

                // Check for validation errors before proceeding
                if (missingParticipationType) {
                    alert('Please select participation Type');
                    return;
                }

                if (missingParticipationYear) {
                    alert('Please select a participation year');
                    return;
                }

                // Check for duplicates first and collect them
                const duplicates = [];
                const validParticipants = [];

                selected.forEach(participant => {
                    // Check if participant already exists with the same year
                    const existingParticipantWithSameYear = checkDuplicateParticipantYear(participant.userId, participant.participantYear);
                    if (existingParticipantWithSameYear) {
                        duplicates.push(`${participant.participantName} (CY-${participant.participantYear})`);
                        return;
                    }

                    // Allow adding the same user with different years
                    validParticipants.push(participant);
                });

                // Show duplicates alert if any
                if (duplicates.length > 0) {
                    alert(`The following participants are already added for the specified year(s):\n\n${duplicates.join('\n')}\n\nPlease select different years for these participants.`);
                }

                // Add valid participants to the form
                validParticipants.forEach(participant => {

                    // Create participant display
                    const participantDiv = document.createElement('div');
                    participantDiv.className = 'd-flex justify-content-between align-items-center mb-1 p-2 border rounded';
                    participantDiv.setAttribute('data-user-id', participant.userId);
                    participantDiv.setAttribute('data-year', participant.participantYear);
                    participantDiv.innerHTML = `
                        <div class="d-flex align-items-center">
                            <span class="me-2">${participant.participantName}</span>
                            <span class="badge bg-info me-1">${participant.participationTypeName}</span>
                            <span class="badge bg-success">CY-${participant.participantYear}</span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-danger remove-participant" data-user-id="${participant.userId}" data-year="${participant.participantYear}">
                                <i class="bi bi-x"></i> Remove
                            </button>
                        </div>
                    `;

                    // Create hidden inputs using user_year keys to allow multiple entries for same user
                    const userYearKey = `${participant.userId}_${participant.participantYear}`;

                    const participantInput = document.createElement('input');
                    participantInput.type = 'hidden';
                    participantInput.name = 'participants[]';
                    participantInput.value = participant.userId;

                    const participationTypeInput = document.createElement('input');
                    participationTypeInput.type = 'hidden';
                    participationTypeInput.name = `participation_types[${userYearKey}]`;
                    participationTypeInput.value = participant.participationTypeId;

                    const participantYearInput = document.createElement('input');
                    participantYearInput.type = 'hidden';
                    participantYearInput.name = `participant_years[${userYearKey}]`;
                    participantYearInput.value = participant.participantYear;

                    // Add to form
                    selectedParticipantsDiv.appendChild(participantDiv);
                    form.appendChild(participantInput);
                    form.appendChild(participationTypeInput);
                    form.appendChild(participantYearInput);
                });



                // Clear checkboxes and close modal
                document.querySelectorAll('.participant-checkbox:checked').forEach(checkbox => {
                    checkbox.checked = false;
                });
                bootstrap.Modal.getInstance(document.getElementById('participantModal')).hide();
            });

            function addSelectedParticipantsFromGlobal() {
                const loading = document.getElementById('participantLoading');
                loading.style.display = 'block';

                // Get all participants data to find the selected ones
                const search = document.getElementById('participantSearch').value;
                fetch(`{{ route('admin.getParticipants') }}?all=true&search=${encodeURIComponent(search)}&training_id={{ $training->id }}`)
                    .then(response => response.json())
                    .then(data => {
                        const selected = [];
                        let hasValidationError = false;

                        // Filter only selected participants
                        const selectedUsers = data.users.filter(user => globalSelectedParticipants.has(user.id.toString()));

                        const missingParticipationTypes = [];
                        const missingYears = [];

                        selectedUsers.forEach(user => {
                            const visibleParticipationSelect = document.querySelector(`select.participation-type[data-user-id="${user.id}"]`);
                            const visibleYearSelect = document.querySelector(`select.participant-year[data-user-id="${user.id}"]`);

                            let participationTypeId = '';
                            let participantYear = '';

                            if (visibleParticipationSelect) {
                                participationTypeId = visibleParticipationSelect.value;
                            } else {
                                // Use default participation type (Participant) when not visible
                                const participantType = data.participation_types.find(type => type.name.toLowerCase() === 'participant');
                                participationTypeId = participantType ? participantType.id : '';
                            }
                            
                            if (visibleYearSelect) {
                                participantYear = visibleYearSelect.value;
                            } else {
                                // Use default year when not visible
                                const currentYear = new Date().getFullYear();
                                const periodFrom = {{ $training->period_from }};
                                participantYear = (currentYear >= periodFrom && currentYear <= periodFrom + 2) ? currentYear : periodFrom;
                            }

                            // Check if participation type is missing
                            if (!participationTypeId) {
                                missingParticipationTypes.push(`${user.last_name}, ${user.first_name} ${user.mid_init || ''}`);
                                return; // Skip this user
                            }

                            // Check if year is missing
                            if (!participantYear) {
                                missingYears.push(`${user.last_name}, ${user.first_name} ${user.mid_init || ''}`);
                                return; // Skip this user
                            }

                            const participationType = data.participation_types.find(type => type.id == participationTypeId);

                            selected.push({
                                userId: user.id,
                                participationTypeId: participationTypeId,
                                participantYear: participantYear,
                                participantName: `${user.last_name}, ${user.first_name} ${user.mid_init || ''}`,
                                participationTypeName: participationType ? participationType.name : 'Unknown'
                            });
                        });

                        // Show error message if there are missing fields
                        if (missingParticipationTypes.length > 0) {
                            loading.style.display = 'none';
                            alert('Please select participation Type');
                            return;
                        }

                        if (missingYears.length > 0) {
                            loading.style.display = 'none';
                            alert('Please select a participation year');
                            return;
                        }

                        // Check for duplicates first and collect them
                        const duplicates = [];
                        const validParticipants = [];

                        selected.forEach(participant => {
                            // Check if participant already exists with the same year
                            const existingParticipantWithSameYear = checkDuplicateParticipantYear(participant.userId, participant.participantYear);
                            if (existingParticipantWithSameYear) {
                                duplicates.push(`${participant.participantName} (CY-${participant.participantYear})`);
                                return;
                            }

                            // Allow adding the same user with different years
                            validParticipants.push(participant);
                        });

                        // Show duplicates alert if any
                        if (duplicates.length > 0) {
                            alert(`The following participants are already added for the specified year(s):\n\n${duplicates.join('\n')}\n\nPlease select different years for these participants.`);
                        }

                        // Add valid participants to the form
                        validParticipants.forEach(participant => {

                            // Create participant display
                            const participantDiv = document.createElement('div');
                            participantDiv.className = 'd-flex justify-content-between align-items-center mb-1 p-2 border rounded';
                            participantDiv.setAttribute('data-user-id', participant.userId);
                            participantDiv.setAttribute('data-year', participant.participantYear);
                            participantDiv.innerHTML = `
                                <div class="d-flex align-items-center">
                                    <span class="me-2">${participant.participantName}</span>
                                    <span class="badge bg-info me-1">${participant.participationTypeName}</span>
                                    <span class="badge bg-success">CY-${participant.participantYear}</span>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-sm btn-danger remove-participant" data-user-id="${participant.userId}" data-year="${participant.participantYear}">
                                        <i class="bi bi-x"></i> Remove
                                    </button>
                                </div>
                            `;

                            // Create hidden inputs using user_year keys to allow multiple entries for same user
                            const userYearKey = `${participant.userId}_${participant.participantYear}`;

                            const participantInput = document.createElement('input');
                            participantInput.type = 'hidden';
                            participantInput.name = 'participants[]';
                            participantInput.value = participant.userId;

                            const participationTypeInput = document.createElement('input');
                            participationTypeInput.type = 'hidden';
                            participationTypeInput.name = `participation_types[${userYearKey}]`;
                            participationTypeInput.value = participant.participationTypeId;

                            const participantYearInput = document.createElement('input');
                            participantYearInput.type = 'hidden';
                            participantYearInput.name = `participant_years[${userYearKey}]`;
                            participantYearInput.value = participant.participantYear;

                            // Add to form
                            selectedParticipantsDiv.appendChild(participantDiv);
                            form.appendChild(participantInput);
                            form.appendChild(participationTypeInput);
                            form.appendChild(participantYearInput);
                        });

                        // Clear global selection and checkboxes
                        globalSelectedParticipants.clear();
                        document.querySelectorAll('.participant-checkbox').forEach(checkbox => {
                            checkbox.checked = false;
                        });
                        updateSelectAllState();

                        loading.style.display = 'none';
                        bootstrap.Modal.getInstance(document.getElementById('participantModal')).hide();
                    })
                    .catch(error => {
                        console.error('Error adding participants:', error);
                        loading.style.display = 'none';
                        alert('Error adding participants. Please try again.');
                    });
            }

            // Handle removing participants
            selectedParticipantsDiv.addEventListener('click', function(e) {
                if (e.target.closest('.remove-participant')) {
                    const button = e.target.closest('.remove-participant');
                    const userId = button.dataset.userId;
                    const year = button.dataset.year;
                    const participantDiv = button.closest('.d-flex');
                    const userYearKey = `${userId}_${year}`;

                    // Find and remove the corresponding hidden inputs using user_year key
                    const participantInput = form.querySelector(`input[name="participants[]"][value="${userId}"]`);
                    const participationTypeInput = form.querySelector(`input[name="participation_types[${userYearKey}]"]`);
                    const participantYearInput = form.querySelector(`input[name="participant_years[${userYearKey}]"]`);

                    // Remove the inputs if they exist
                    if (participantInput) participantInput.remove();
                    if (participationTypeInput) participationTypeInput.remove();
                    if (participantYearInput) participantYearInput.remove();

                    // Remove the participant's div from the display
                    button.closest('.d-flex').remove();
                }
            });

        });

        // Function to toggle core competency input field
        function toggleCoreCompetencyInputEdit() {
            const coreCompetencySelect = document.getElementById('core_competency');
            const coreCompetencyInput = document.getElementById('core_competency_input_edit');

            if (coreCompetencySelect && coreCompetencyInput) {
                if (coreCompetencySelect.value === 'Others') {
                    coreCompetencySelect.style.display = 'none';
                    coreCompetencyInput.style.display = 'block';
                    coreCompetencyInput.required = true;
                    coreCompetencyInput.focus();
                } else {
                    coreCompetencySelect.style.display = 'block';
                    coreCompetencyInput.style.display = 'none';
                    coreCompetencyInput.required = false;
                }
            }
        }

        // Function to toggle competency input field - moved outside DOMContentLoaded
        function toggleCompetencyInputEdit() {
            const competencySelect = document.getElementById('competency');
            const competencyInput = document.getElementById('competency_input_edit');

            if (competencySelect && competencyInput) {
                if (competencySelect.value === 'others') {
                    competencySelect.style.display = 'none';
                    competencyInput.style.display = 'block';
                    competencyInput.required = true;
                    competencyInput.focus();
                } else {
                    competencySelect.style.display = 'block';
                    competencyInput.style.display = 'none';
                    competencyInput.required = false;
                }
            }
        }

        // Call on page load to set initial state
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                toggleCoreCompetencyInputEdit();
                toggleCompetencyInputEdit();
            }, 100);
        });
    </script>
</body>
</html>



