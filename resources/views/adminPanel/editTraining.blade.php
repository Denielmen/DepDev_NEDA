{{-- filepath: d:\tests\04-27\DepDev_NEDA\resources\views\adminPanel\editTraining.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Training</title>
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
                            <label for="title" class="form-label">Title/Area:</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $training->title }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="core_competency" class="form-label">Classification:</label>
                            <select class="form-control" id="core_competency" name="core_competency" required>
                                <option value="">Select Core Competency...</option>
                                <option value="Foundational/Mandatory" {{ $training->core_competency === 'Foundational/Mandatory' ? 'selected' : '' }}>Foundational/Mandatory</option>
                                <option value="Competency Enhancement" {{ $training->core_competency === 'Competency Enhancement' ? 'selected' : '' }}>Competency Enhancement</option>
                                <option value="Leadership/Executive Development" {{ $training->core_competency === 'Leadership/Executive Development' ? 'selected' : '' }}>Leadership/Executive Development</option>
                                <option value="Gender and Development (GAD)-Related" {{ $training->core_competency === 'Gender and Development (GAD)-Related' ? 'selected' : '' }}>Gender and Development (GAD)-Related</option>
                                <option value="Others" {{ $training->core_competency === 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="competency" class="form-label">Competency</label>
                            <select class="form-control" id="competency" name="competency_id" required>
                                <option value="">Select Competency</option>
                                @foreach($competencies as $competency)
                                    <option value="{{ $competency->id }}" {{ $training->competency_id == $competency->id ? 'selected' : '' }}>
                                        {{ $competency->name }}
                                    </option>
                                @endforeach
                            </select>
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

                    <h5 class="mt-4">Participants</h5>
                    <div id="selectedParticipantsContainer" class="mb-3">
                        <div id="selectedParticipants">
                            @foreach ($training->participants as $participant)
                                <div class="d-flex justify-content-between align-items-center mb-1 p-2 border rounded">
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">{{ $participant->last_name }}, {{ $participant->first_name }} {{ $participant->mid_init }}</span>
                                        <span class="badge bg-info me-1">{{ $participationTypes->get($participant->pivot->participation_type_id)->name ?? 'N/A' }}</span>
                                        <span class="badge bg-success">CY-{{ $participant->pivot->year ?? '2025' }}</span>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-danger remove-participant" data-user-id="{{ $participant->id }}">
                                            <i class="bi bi-x"></i> Remove
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="participants[]" value="{{ $participant->id }}">
                                <input type="hidden" name="participation_types[{{ $participant->id }}]" value="{{ $participant->pivot->participation_type_id }}">
                                <input type="hidden" name="participant_years[{{ $participant->id }}]" value="{{ $participant->pivot->year ?? '2025' }}">
                            @endforeach
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
        <div class="modal-dialog modal-lg">
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
                                            <option value="">Select Type</option>
                                            @foreach($participationTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-select participant-year" data-user-id="{{ $user->id }}">
                                            <option value="">Select Year</option>
                                            <option value="2025">CY-2025</option>
                                            <option value="2026">CY-2026</option>
                                            <option value="2027">CY-2027</option>
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

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action*="training-plan"]');
            const selectedParticipantsDiv = document.getElementById('selectedParticipants');
            const addSelectedParticipantsBtn = document.getElementById('addSelectedParticipantsBtn');
            const selectAllCheckbox = document.getElementById('selectAllParticipants');
            const removeAllSelectionBtn = document.getElementById('removeAllSelectionBtn');
            const participantCheckboxes = document.querySelectorAll('.participant-checkbox');

            // Initialize event listeners
            initializeParticipantEventListeners();

            // Handle Remove All Selection functionality
            removeAllSelectionBtn.addEventListener('click', function() {
                document.querySelectorAll('.participant-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });
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

                fetch(`{{ route('admin.getParticipants') }}?page=${page}&search=${encodeURIComponent(search)}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update table body
                        tableBody.innerHTML = '';
                        data.users.forEach(user => {
                            const row = createParticipantRow(user, data.participation_types);
                            tableBody.appendChild(row);
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

                let participationTypeOptions = '<option value="">Select Type</option>';
                participationTypes.forEach(type => {
                    participationTypeOptions += `<option value="${type.id}">${type.name}</option>`;
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
                            <option value="">Select Year</option>
                            <option value="2025">CY-2025</option>
                            <option value="2026">CY-2026</option>
                            <option value="2027">CY-2027</option>
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
                document.querySelectorAll('.participant-checkbox').forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            }

            function handleIndividualCheckbox() {
                const checkedCount = document.querySelectorAll('.participant-checkbox:checked').length;
                const totalCount = document.querySelectorAll('.participant-checkbox').length;
                const selectAllCheckbox = document.getElementById('selectAllParticipants');

                selectAllCheckbox.checked = checkedCount === totalCount;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
            }



            // Handle adding selected participants
            addSelectedParticipantsBtn.addEventListener('click', function() {
                const checkedCheckboxes = document.querySelectorAll('.participant-checkbox:checked');

                const selected = [];
                let hasValidationError = false;

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
                        hasValidationError = true;
                        return;
                    }

                    if (!participantYear) {
                        hasValidationError = true;
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
                if (hasValidationError) {
                    alert('Please select both participation type and year for all selected participants.');
                    return;
                }

                // Add selected participants to the form
                selected.forEach(participant => {
                    // Check if participant already exists
                    const existingParticipant = form.querySelector(`input[name="participants[]"][value="${participant.userId}"]`);
                    if (existingParticipant) {
                        // Update participation type if participant already exists
                        form.querySelector(`input[name="participation_types[${participant.userId}]"]`).value = participant.participationTypeId;
                        return;
                    }

                    // Create participant display
                    const participantDiv = document.createElement('div');
                    participantDiv.className = 'd-flex justify-content-between align-items-center mb-1 p-2 border rounded';
                    participantDiv.innerHTML = `
                        <div class="d-flex align-items-center">
                            <span class="me-2">${participant.participantName}</span>
                            <span class="badge bg-info me-1">${participant.participationTypeName}</span>
                            <span class="badge bg-success">CY-${participant.participantYear}</span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-danger remove-participant" data-user-id="${participant.userId}">
                                <i class="bi bi-x"></i> Remove
                            </button>
                        </div>
                    `;

                    // Create hidden inputs
                    const participantInput = document.createElement('input');
                    participantInput.type = 'hidden';
                    participantInput.name = 'participants[]';
                    participantInput.value = participant.userId;

                    const participationTypeInput = document.createElement('input');
                    participationTypeInput.type = 'hidden';
                    participationTypeInput.name = `participation_types[${participant.userId}]`;
                    participationTypeInput.value = participant.participationTypeId;

                    const participantYearInput = document.createElement('input');
                    participantYearInput.type = 'hidden';
                    participantYearInput.name = `participant_years[${participant.userId}]`;
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

            // Handle removing participants
            selectedParticipantsDiv.addEventListener('click', function(e) {
                if (e.target.closest('.remove-participant')) {
                    const button = e.target.closest('.remove-participant');
                    const userId = button.dataset.userId;

                    // Remove the hidden inputs for this user
                    form.querySelectorAll(`input[name="participants[]"][value="${userId}"]`).forEach(input => input.remove());
                    form.querySelectorAll(`input[name="participation_types[${userId}]"]`).forEach(input => input.remove());
                    form.querySelectorAll(`input[name="participant_years[${userId}]"]`).forEach(input => input.remove());

                    // Remove the participant's div from the display
                    button.closest('.d-flex').remove();
                }
            });
        });
    </script>
</body>
</html>



