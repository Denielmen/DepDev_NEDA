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

        }
        .navbar {
            background-color:rgb(255, 255, 255);
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
            top: 56px;  /* to fix the navbar */
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
            margin-bottom: 20px;
            border-radius: 5px;
            width: 100%;
        }
        .training-header h2 {
            font-size: 1.5rem;
            margin-bottom: 0;
            color: #003366 ;
            font-weight: bold;
        }
        .training-card {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
            padding: 1.5rem;
            max-width: 900px;
            margin: 0 auto;
        }
        .training-card h4 {
            font-weight: bold;
        }
        .date-range {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .date-range input[type="date"] {
            width: 150px;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .date-range span {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .dot{
            color: red;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        /* CSS to increase checkbox size in participant modal */
        #participantModal .form-check-input {
            width: 1.5em; /* Increase width */
            height: 1.5em; /* Increase height */
            margin-top: 0.25em; /* Adjust vertical alignment if needed */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/neda-logo.png" alt="NEDA Logo">
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
            <div class="container-fluid p-0">
                <div class="mb-4 training-header">
                    <h2 class="mb-0">Create Training</h2>
                </div>
            </div>
            <div class="training-card">
                <h4 class="text-center mb-4">Training Information</h4>
                <form method="POST" action="{{ route('admin.training-plan.store') }}" id="trainingForm">
                    @csrf

                    {{-- Core Competency Field --}}
                    <div class="form-group row mb-3">
                        <label for="core_competency" class="col-md-4 col-form-label text-md-right">{{ __('Classification ') }}<span class="dot">*</span></label>
                        <div class="col-md-6">
                            <select class="form-control @error('core_competency') is-invalid @enderror" id="core_competency" name="core_competency" required onchange="toggleCoreCompetencyInput()">
                                <option value="">--Select Classification--</option>
                                <option value="Foundational/Mandatory" {{ old('core_competency') == 'Foundational/Mandatory' ? 'selected' : '' }}>Foundational/Mandatory</option>
                                <option value="Competency Enhancement" {{ old('core_competency') == 'Competency Enhancement' ? 'selected' : '' }}>Competency Enhancement</option>
                                <option value="Leadership/Executive Development" {{ old('core_competency') == 'Leadership/Executive Development' ? 'selected' : '' }}>Leadership/Executive Development</option>
                                <option value="Gender and Development (GAD)-Related" {{ old('core_competency') == 'Gender and Development (GAD)-Related' ? 'selected' : '' }}>Gender and Development (GAD)-Related</option>
                                <option value="Others" {{ old('core_competency') == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            <input type="text" class="form-control mt-2 @error('core_competency') is-invalid @enderror"
                                id="core_competency_input" name="core_competency_input"
                                placeholder="Enter core competency" value="{{ old('core_competency_input') }}" style="display: none;">
                            @error('core_competency')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title/Area ') }}<span class="dot">*</span></label>
                        <div class="col-md-6">
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="competency" class="col-md-4 col-form-label text-md-right">{{ __('Competency ') }}<span class="dot">*</span></label>
                        <div class="col-md-6">
                            <select id="competency" class="form-control @error('competency_id') is-invalid @enderror" name="competency_id" required>
                                <option value="">Select Competency</option>
                                @foreach($competencies as $competency)
                                    <option value="{{ $competency->id }}" {{ old('competency_id') == $competency->id ? 'selected' : '' }}>
                                        {{ $competency->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('competency_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group row mb-3">
                        <label for="period_from" class="col-md-4 col-form-label text-md-right">{{ __('Three-Year Period From ') }}<span class="dot">*</span></label>
                        <div class="col-md-6">
                            <input id="period_from" type="number" min="2000" max="2100" class="form-control @error('period_from') is-invalid @enderror" name="period_from" value="{{ old('period_from') }}" required onchange="setPeriodTo()" placeholder="YYYY">
                            @error('period_from')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="period_to" class="col-md-4 col-form-label text-md-right">{{ __('Three-Year Period To ') }}<span class="dot">*</span></label>
                        <div class="col-md-6">
                            <input id="period_to" type="number" min="2000" max="2100" class="form-control @error('period_to') is-invalid @enderror" name="period_to" value="{{ old('period_to') }}" required placeholder="YYYY">
                            @error('period_to')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="budget" class="col-md-4 col-form-label text-md-right">{{ __('Budget ') }}<span class="dot">*</span></label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input id="budget" type="number" class="form-control @error('budget') is-invalid @enderror" name="budget" value="{{ old('budget') }}" step="0.01">
                            </div>
                            @error('budget')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="no_of_hours" class="col-md-4 col-form-label text-md-right">{{ __('Total Number of Hours ') }}<span class="dot">*</span></label>
                        <div class="col-md-6">
                            <input id="no_of_hours" type="number" class="form-control @error('no_of_hours') is-invalid @enderror" name="no_of_hours" value="{{ old('no_of_hours') }}">
                            @error('no_of_hours')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row mb-3">
                        <label for="provider" class="col-md-4 col-form-label text-md-right">{{ __('Learning Service Provider ') }}<span class="dot">*</span></label>
                        <div class="col-md-6">
                            <input id="provider" type="text" class="form-control @error('provider') is-invalid @enderror" name="provider" value="{{ old('provider') }}">
                            @error('provider')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="dev_target" class="col-md-4 col-form-label text-md-right">{{ __('Development Target') }}</label>
                        <div class="col-md-6">
                            <textarea id="dev_target" class="form-control @error('dev_target') is-invalid @enderror" name="dev_target" rows="2">{{ old('dev_target') }}</textarea>
                            @error('dev_target')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="performance_goal" class="col-md-4 col-form-label text-md-right">{{ __('Performance Goal this Supports') }}</label>
                        <div class="col-md-6">
                            <textarea id="performance_goal" class="form-control @error('performance_goal') is-invalid @enderror" name="performance_goal" rows="2">{{ old('performance_goal') }}</textarea>
                            @error('performance_goal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="objective" class="col-md-4 col-form-label text-md-right">{{ __('Objective') }}</label>
                        <div class="col-md-6">
                            <textarea id="objective" class="form-control @error('objective') is-invalid @enderror" name="objective" rows="2">{{ old('objective') }}</textarea>
                            @error('objective')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="type" value="Program">


                    <div class="form-group row mb-3">
                        <label for="participants" class="col-md-4 col-form-label text-md-right">{{ __('Participants ') }}<span class="dot">*</span></label>
                        <div class="col-md-6">
                            <div id="selectedParticipants" class="mb-2">
                                <!-- Selected participants will be displayed here -->
                            </div>
                            <select id="participants" class="form-control @error('participants') is-invalid @enderror" name="participants[]" multiple style="display: none;">
                                {{-- Options are added via JavaScript --}}
                            </select>
                             @error('participants')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('admin.training-plan') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#participantModal">Add Participant</button>
                        <button type="submit" class="btn btn-success ms-2">Create Training</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="participantSearch" placeholder="Search participants..." onkeyup="searchParticipants()">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Division</th>
                                    <th>Participation Type</th>
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
                    <button type="button" class="btn btn-primary" id="addSelectedParticipantsBtn">Add</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const participantsSelect = document.getElementById('participants');
            const selectedParticipantsDiv = document.getElementById('selectedParticipants');
            const participantModal = document.getElementById('participantModal');
            const modal = bootstrap.Modal.getInstance(participantModal) || new bootstrap.Modal(participantModal);
            const form = document.getElementById('trainingForm');
            const addSelectedParticipantsBtn = document.getElementById('addSelectedParticipantsBtn');
            const selectAllCheckbox = document.getElementById('selectAllParticipants');
            const removeAllSelectionBtn = document.getElementById('removeAllSelectionBtn');

            // Global array to track all selected participants across pages
            let globalSelectedParticipants = new Set();

            // Initialize event listeners
            initializeParticipantEventListeners();

            // Clear any pre-selected participants
            participantsSelect.innerHTML = '';
            selectedParticipantsDiv.innerHTML = '';

            // Initialize pagination and search functionality
            initializeParticipantEventListeners();

            // Handle search functionality
            const participantSearch = document.getElementById('participantSearch');
            let searchTimeout;

            if (participantSearch) {
                participantSearch.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        loadParticipants(1, this.value);
                    }, 300);
                });
            }

            // Handle pagination clicks
            document.addEventListener('click', function(e) {
                if (e.target.matches('#participantPagination a.page-link')) {
                    e.preventDefault();
                    const page = e.target.getAttribute('data-page');
                    const search = participantSearch ? participantSearch.value : '';
                    loadParticipants(page, search);
                }
            });

            // Function to load participants via AJAX
            function loadParticipants(page = 1, search = '') {
                const loading = document.getElementById('participantLoading');
                const tableBody = document.getElementById('participantTableBody');
                const paginationInfo = document.getElementById('participantPaginationInfo');
                const pagination = document.getElementById('participantPagination');

                if (!loading || !tableBody) return;

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

                        // Restore selection state for current page
                        document.querySelectorAll('.participant-checkbox').forEach(checkbox => {
                            const userId = checkbox.getAttribute('data-user-id');
                            checkbox.checked = globalSelectedParticipants.has(userId);
                        });

                        // Update pagination info
                        if (paginationInfo) {
                            paginationInfo.textContent = `Showing ${data.pagination.from || 0} to ${data.pagination.to || 0} of ${data.pagination.total} participants`;
                        }

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
                        <input type="checkbox" class="form-check-input participant-checkbox" data-user-id="${user.id}">
                    </td>
                `;

                return row;
            }

            // Function to update pagination controls
            function updatePaginationControls(pagination) {
                const paginationContainer = document.getElementById('participantPagination');
                if (!paginationContainer) return;

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
                const newRemoveAllSelectionBtn = document.getElementById('removeAllSelectionBtn');

                // Re-bind Select All functionality
                if (newSelectAllCheckbox) {
                    newSelectAllCheckbox.removeEventListener('change', handleSelectAll);
                    newSelectAllCheckbox.addEventListener('change', handleSelectAll);
                }

                // Re-bind individual checkbox functionality
                newParticipantCheckboxes.forEach(checkbox => {
                    checkbox.removeEventListener('change', handleIndividualCheckbox);
                    checkbox.addEventListener('change', handleIndividualCheckbox);
                });

                // Re-bind Remove All Selection functionality
                if (newRemoveAllSelectionBtn) {
                    newRemoveAllSelectionBtn.removeEventListener('click', handleRemoveAllSelection);
                    newRemoveAllSelectionBtn.addEventListener('click', handleRemoveAllSelection);
                }
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

            function handleRemoveAllSelection() {
                // Clear global selection
                globalSelectedParticipants.clear();

                // Uncheck all visible checkboxes
                document.querySelectorAll('.participant-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Update select all state
                const selectAllCheckbox = document.getElementById('selectAllParticipants');
                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                }
            }

            function selectAllParticipantsGlobally() {
                // Show loading
                const loading = document.getElementById('participantLoading');
                loading.style.display = 'block';

                // Fetch all participants (without pagination)
                const search = document.getElementById('participantSearch').value;
                fetch(`{{ route('admin.getParticipants') }}?all=true&search=${encodeURIComponent(search)}`)
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

                if (selectAllCheckbox) {
                    if (currentPageSelectedCount === 0) {
                        selectAllCheckbox.checked = false;
                        selectAllCheckbox.indeterminate = false;
                    } else if (currentPageSelectedCount === totalCurrentPageCount) {
                        selectAllCheckbox.checked = globalSelectedParticipants.size > totalCurrentPageCount;
                        selectAllCheckbox.indeterminate = !selectAllCheckbox.checked;
                    } else {
                        selectAllCheckbox.checked = false;
                        selectAllCheckbox.indeterminate = true;
                    }
                }
            }

            // Function to update the selected participants display and hidden inputs
            function updateSelectedParticipants() {
                // Check if we have global selections that need validation
                if (globalSelectedParticipants.size > 0) {
                    updateSelectedParticipantsFromGlobal();
                    return;
                }

                selectedParticipantsDiv.innerHTML = '';
                // Clear the old hidden inputs before adding new ones
                form.querySelectorAll('input[name="participants[]"], input[name^="participation_types["]').forEach(input => {
                    input.remove();
                });

                const selected = [];
                const missingParticipationTypes = [];

                // Get the period_from value to use as the year
                let periodFromYear = parseInt(document.getElementById('period_from').value);

                // If period_from is less than 2025, set it to 2025
                if (periodFromYear <=2025) {
                    periodFromYear = 2025;
                }

                document.querySelectorAll('.participant-checkbox:checked').forEach(checkbox => {
                    const userId = checkbox.dataset.userId;
                    const participantRow = checkbox.closest('.participant-row');
                    const participationTypeSelect = participantRow.querySelector('.participation-type');
                    const participationTypeId = participationTypeSelect.value;
                    const userName = participantRow.querySelector('td').textContent.trim();

                    // Check if participation type is missing
                    if (!participationTypeId || participationTypeId === '') {
                        missingParticipationTypes.push(userName);
                        return; // Skip this participant
                    }

                    const participationTypeName = participationTypeSelect.options[participationTypeSelect.selectedIndex].text;

                    selected.push({
                        id: userId,
                        name: userName,
                        participation_type_id: participationTypeId,
                        participation_type_name: participationTypeName
                    });

                    // Add hidden inputs to the main form
                    const participantInput = document.createElement('input');
                    participantInput.type = 'hidden';
                    participantInput.name = 'participants[]';
                    participantInput.value = userId;
                    form.appendChild(participantInput);

                    const participationTypeInput = document.createElement('input');
                    participationTypeInput.type = 'hidden';
                    participationTypeInput.name = `participation_types[${userId}]`;
                    participationTypeInput.value = participationTypeId;
                    form.appendChild(participationTypeInput);

                    // Add a hidden input for the year based on period_from (minimum 2025)
                    const yearInput = document.createElement('input');
                    yearInput.type = 'hidden';
                    yearInput.name = `participant_years[${userId}]`;
                    yearInput.value = periodFromYear;
                    form.appendChild(yearInput);
                });

                // Show error message if there are missing participation types
                if (missingParticipationTypes.length > 0) {
                    alert('Please select participation Type');
                    return; // Don't close modal
                }

                // Update the visual display
                selected.forEach(participant => {
                    const participantDiv = document.createElement('div');
                    participantDiv.className = 'd-flex justify-content-between align-items-center mb-1 p-2 border rounded';

                    participantDiv.innerHTML = `
                        <div class="d-flex align-items-center">
                            <span class="me-2">${participant.name}</span>
                            <span class="badge bg-info">${participant.participation_type_name}</span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-danger remove-participant" data-user-id="${participant.id}">
                                <i class="bi bi-x"></i> Remove
                            </button>
                        </div>
                    `;
                    selectedParticipantsDiv.appendChild(participantDiv);
                });

                // Log the current state
                console.log('Selected participants:', selected);

                // Close modal only if we successfully added participants
                if (selected.length > 0) {
                    modal.hide();
                }
            }

            // Function to handle global selection validation and processing
            function updateSelectedParticipantsFromGlobal() {
                const loading = document.getElementById('participantLoading');
                loading.style.display = 'block';

                // Get all participants data to validate selections
                const search = document.getElementById('participantSearch').value;
                fetch(`{{ route('admin.getParticipants') }}?all=true&search=${encodeURIComponent(search)}`)
                    .then(response => response.json())
                    .then(data => {
                        const selectedUsers = data.users.filter(user => globalSelectedParticipants.has(user.id.toString()));
                        const missingParticipationTypes = [];
                        const selected = [];

                        // Get the period_from value to use as the year
                        let periodFromYear = parseInt(document.getElementById('period_from').value);
                        if (periodFromYear <= 2025) {
                            periodFromYear = 2025;
                        }

                        selectedUsers.forEach(user => {
                            const visibleParticipationSelect = document.querySelector(`select.participation-type[data-user-id="${user.id}"]`);
                            let participationTypeId = '';

                            if (visibleParticipationSelect) {
                                participationTypeId = visibleParticipationSelect.value;
                            }

                            // Check if participation type is missing
                            if (!participationTypeId) {
                                missingParticipationTypes.push(`${user.last_name}, ${user.first_name} ${user.mid_init || ''}`);
                                return; // Skip this user
                            }

                            const participationType = data.participation_types.find(type => type.id == participationTypeId);

                            selected.push({
                                id: user.id,
                                name: `${user.last_name}, ${user.first_name} ${user.mid_init || ''}`,
                                participation_type_id: participationTypeId,
                                participation_type_name: participationType ? participationType.name : 'Unknown'
                            });
                        });

                        // Show error message if there are missing participation types
                        if (missingParticipationTypes.length > 0) {
                            loading.style.display = 'none';
                            alert('Please select Participation Type');
                            return;
                        }

                        // Clear old inputs
                        selectedParticipantsDiv.innerHTML = '';
                        form.querySelectorAll('input[name="participants[]"], input[name^="participation_types["]').forEach(input => {
                            input.remove();
                        });

                        // Add selected participants
                        selected.forEach(participant => {
                            // Add hidden inputs to the main form
                            const participantInput = document.createElement('input');
                            participantInput.type = 'hidden';
                            participantInput.name = 'participants[]';
                            participantInput.value = participant.id;
                            form.appendChild(participantInput);

                            const participationTypeInput = document.createElement('input');
                            participationTypeInput.type = 'hidden';
                            participationTypeInput.name = `participation_types[${participant.id}]`;
                            participationTypeInput.value = participant.participation_type_id;
                            form.appendChild(participationTypeInput);

                            const yearInput = document.createElement('input');
                            yearInput.type = 'hidden';
                            yearInput.name = `participant_years[${participant.id}]`;
                            yearInput.value = periodFromYear;
                            form.appendChild(yearInput);

                            // Add to visual display
                            const participantDiv = document.createElement('div');
                            participantDiv.className = 'd-flex justify-content-between align-items-center mb-1 p-2 border rounded';

                            participantDiv.innerHTML = `
                                <div class="d-flex align-items-center">
                                    <span class="me-2">${participant.name}</span>
                                    <span class="badge bg-info">${participant.participation_type_name}</span>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-sm btn-danger remove-participant" data-user-id="${participant.id}">
                                        <i class="bi bi-x"></i> Remove
                                    </button>
                                </div>
                            `;
                            selectedParticipantsDiv.appendChild(participantDiv);
                        });

                        // Clear global selection
                        globalSelectedParticipants.clear();
                        document.querySelectorAll('.participant-checkbox').forEach(checkbox => {
                            checkbox.checked = false;
                        });
                        updateSelectAllState();

                        loading.style.display = 'none';
                        modal.hide(); // Close the modal after successful addition
                    })
                    .catch(error => {
                        console.error('Error processing participants:', error);
                        loading.style.display = 'none';
                        alert('Error processing participants. Please try again.');
                    });
            }

             // Handle Add Selected Participants button click in modal footer
            addSelectedParticipantsBtn.addEventListener('click', function() {
                // Check if any participants are selected
                if (globalSelectedParticipants.size === 0 && document.querySelectorAll('.participant-checkbox:checked').length === 0) {
                    alert('Please select at least one participant.');
                    return;
                }

                updateSelectedParticipants();
                // Note: modal.hide() is now called inside updateSelectedParticipants functions only on success
            });

            // Handle Remove Participant button clicks from the displayed list outside the modal
            selectedParticipantsDiv.addEventListener('click', function(e) {
                if (e.target.closest('.remove-participant')) {
                    const button = e.target.closest('.remove-participant');
                    const userId = button.dataset.userId;

                    // Remove the hidden inputs for this user
                    form.querySelectorAll(`input[name="participants[]"][value="${userId}"]`).forEach(input => input.remove());
                    form.querySelectorAll(`input[name="participation_types[${userId}]"]`).forEach(input => input.remove());

                    // Uncheck the corresponding checkbox in the modal (if modal is open)
                    const checkboxInModal = document.querySelector(`.participant-checkbox[data-user-id="${userId}"]`);
                    if (checkboxInModal) {
                        checkboxInModal.checked = false;
                    }

                    // Remove the participant's div from the display
                    button.closest('.d-flex').remove();

                    // Update the console log (optional, for debugging)
                     console.log('Removed participant:', userId);
                     console.log('Current selected participants:', Array.from(form.querySelectorAll('input[name="participants[]"]')).map(input => input.value));
                } else if (e.target.classList.contains('remove-participant')) { // Handle click directly on the icon inside the button
                     const button = e.target;
                    const userId = button.dataset.userId;
                     // Remove the hidden inputs for this user
                    form.querySelectorAll(`input[name="participants[]"][value="${userId}"]`).forEach(input => input.remove());
                    form.querySelectorAll(`input[name="participation_types[${userId}]"]`).forEach(input => input.remove());

                    // Uncheck the corresponding checkbox in the modal (if modal is open)
                    const checkboxInModal = document.querySelector(`.participant-checkbox[data-user-id="${userId}"]`);
                    if (checkboxInModal) {
                        checkboxInModal.checked = false;
                    }

                    // Remove the participant's div from the display
                    button.closest('.d-flex').remove();

                     // Update the console log (optional, for debugging)
                     console.log('Removed participant:', userId);
                     console.log('Current selected participants:', Array.from(form.querySelectorAll('input[name="participants[]"]')).map(input => input.value));
                }
            });

            // Form validation and submission - Keep this, ensure it reads from the hidden inputs
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                console.log('Form submission started');

                // Validate required fields
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                let firstInvalidField = null;

                requiredFields.forEach(field => {
                    if (!field.value) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                        console.log('Invalid field:', field.name);
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                // Check if participants are selected by looking at the hidden inputs
                const selectedParticipants = form.querySelectorAll('input[name="participants[]"]');
                if (selectedParticipants.length === 0) {
                    alert('Please add at least one participant');
                    isValid = false;
                }

                // Log form data - Keep this, it now reads from the hidden inputs
                const formData = new FormData(form);
                console.log('Form data:', {
                    title: formData.get('title'),
                    competency_id: formData.get('competency_id'),
                    core_competency: formData.get('core_competency') === 'Others' ? formData.get('core_competency_input') : formData.get('core_competency'), // Get the correct core competency value
                    period_from: formData.get('period_from'),
                    period_to: formData.get('period_to'),
                    implementation_date_from: formData.get('implementation_date_from'),
                    implementation_date_to: formData.get('implementation_date_to'), // Added missing field
                    budget: formData.get('budget'),
                    no_of_hours: formData.get('no_of_hours'),
                    // superior: formData.get('superior'),
                    provider: formData.get('provider'),
                    dev_target: formData.get('dev_target'),
                    performance_goal: formData.get('performance_goal'),
                    objective: formData.get('objective'),
                    type: formData.get('type'),
                    participants: Array.from(formData.getAll('participants[]')),
                    participation_types: Object.fromEntries(
                        Array.from(formData.entries())
                            .filter(([key]) => key.startsWith('participation_types['))
                            .map(([key, value]) => [key.match(/\[(\d+)\]/)[1], value]) // Corrected regex escaping
                    )
                });

                if (isValid) {
                    console.log('Form is valid, submitting...');
                    // Submit the form
                    this.submit();
                } else {
                    console.log('Form validation failed');
                    if (firstInvalidField) {
                        firstInvalidField.focus();
                    }
                }
            });



             // Initial call to setup the display based on any old data (if page was reloaded with errors)
             // This part might need adjustment depending on how old input is handled after validation errors.
             // For now, let's assume fresh start or data is correctly in hidden inputs if validation failed.
             // We can add logic here later if needed to read from old input to pre-select checkboxes on modal open.

        });

        function setPeriodTo() {
            const fromYearInput = document.getElementById('period_from');
            const toYearInput = document.getElementById('period_to');
            const fromYear = parseInt(fromYearInput.value);

            if (fromYear) {
                // Add 3 years to the from year
                const toYear = fromYear + 3;
                toYearInput.value = toYear;
            }
        }

        function toggleCoreCompetencyInput() {
            const coreCompetencySelect = document.getElementById('core_competency');
            const coreCompetencyInput = document.getElementById('core_competency_input');

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
             // Ensure the correct value is sent in the form based on which element is visible/used
             // This might require updating a hidden field or handling in the form submission logic.
             // The form submission logic already handles this by checking the select value.
        }

        // Call on page load to set initial state
        document.addEventListener('DOMContentLoaded', function() {
            toggleCoreCompetencyInput();
        });

        function searchParticipants() {
            const input = document.getElementById('participantSearch');
            const filter = input.value.toUpperCase();
            const rows = document.getElementsByClassName('participant-row');

            for (let i = 0; i < rows.length; i++) {
                const nameCell = rows[i].getElementsByTagName('td')[0];
                const positionCell = rows[i].getElementsByTagName('td')[1];
                const divisionCell = rows[i].getElementsByTagName('td')[2];

                if (nameCell && positionCell && divisionCell) {
                    const nameText = nameCell.textContent || nameCell.innerText;
                    const positionText = positionCell.textContent || positionCell.innerText;
                    const divisionText = divisionCell.textContent || divisionCell.innerText;

                    if (nameText.toUpperCase().indexOf(filter) > -1 ||
                        positionText.toUpperCase().indexOf(filter) > -1 ||
                        divisionText.toUpperCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }
    </script>

</body>
</html>













