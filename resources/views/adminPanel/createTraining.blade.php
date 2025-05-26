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

        .form-group {
            margin-bottom: 1rem;
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
            <a href="{{ route('admin.training-plan') }}" class="active"><i class="bi bi-calendar-check me-2"></i>Training Plan</a>
            <a href="{{ route('admin.participants') }}"><i class="bi bi-people me-2"></i>Employee's Profile</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 main-content p-4" style="margin-top: 56px;">
            <div class="mb-4 training-header">
                <h2 class="mb-0">Training Plan</h2>
            </div>
            <div class="training-card">
                <h4 class="text-center mb-4">Training Information</h4>
                <form method="POST" action="{{ route('admin.training-plan.store') }}" id="trainingForm">
                    @csrf

                    <div class="form-group row mb-3">
                        <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title/Area') }}</label>
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
                        <label for="competency" class="col-md-4 col-form-label text-md-right">{{ __('Competency') }}</label>
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
                        <label for="period_from" class="col-md-4 col-form-label text-md-right">{{ __('Three-Year Period From') }}</label>
                        <div class="col-md-6">
                            <input id="period_from" type="date" class="form-control @error('period_from') is-invalid @enderror" name="period_from" value="{{ old('period_from') }}" required onchange="setPeriodTo()">
                            @error('period_from')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="period_to" class="col-md-4 col-form-label text-md-right">{{ __('Three-Year Period To') }}</label>
                        <div class="col-md-6">
                            <input id="period_to" type="date" class="form-control @error('period_to') is-invalid @enderror" name="period_to" value="{{ old('period_to') }}" required>
                            @error('period_to')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="implementation_date" class="col-md-4 col-form-label text-md-right">{{ __('Implementation Date') }}</label>
                        <div class="col-md-6">
                            <input id="implementation_date" type="date" class="form-control @error('implementation_date') is-invalid @enderror" name="implementation_date" value="{{ old('implementation_date') }}" required>
                            @error('implementation_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="budget" class="col-md-4 col-form-label text-md-right">{{ __('Budget (per hour)') }}</label>
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
                        <label for="no_of_hours" class="col-md-4 col-form-label text-md-right">{{ __('Number of Hours') }}</label>
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
                        <label for="superior" class="col-md-4 col-form-label text-md-right">{{ __('Superior') }}</label>
                        <div class="col-md-6">
                            <select id="superior" name="superior" class="form-control @error('superior') is-invalid @enderror">
                                <option value="">Select Superior</option>
                                @foreach(App\Models\User::getSuperiors() as $superior)
                                    <option value="{{ $superior->full_name }}" {{ old('superior') == $superior->full_name ? 'selected' : '' }}>
                                        {{ $superior->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('superior')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="provider" class="col-md-4 col-form-label text-md-right">{{ __('Learning Service Provider') }}</label>
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
                        <label for="participants" class="col-md-4 col-form-label text-md-right">{{ __('Participants') }}</label>
                        <div class="col-md-6">
                            <div id="selectedParticipants" class="mb-2">
                                <!-- Selected participants will be displayed here -->
                            </div>
                            <select id="participants" class="form-control @error('participants') is-invalid @enderror" name="participants[]" multiple style="display: none;">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ in_array($user->id, old('participants', [])) ? 'selected' : '' }}>
                                    {{ $user->last_name }}, {{ $user->first_name }} {{ $user->mid_init }}.
                                    </option>
                                @endforeach
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

    <!-- Participant List Modal -->
    <div class="modal fade" id="participantModal" tabindex="-1" aria-labelledby="participantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="participantModalLabel">Add Participants</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Division</th>
                                    <th>Participation Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->last_name }}, {{ $user->first_name }} {{ $user->mid_init }}.</td>
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
                                        <button class="btn btn-sm btn-primary add-participant-btn" 
                                            data-user-id="{{ $user->id }}" 
                                            data-user-name="{{ $user->last_name }}, {{ $user->first_name }} {{ $user->mid_init }}.">
                                            Add
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="doneBtn">Done</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const participantsSelect = document.getElementById('participants');
            const selectedParticipantsDiv = document.getElementById('selectedParticipants');
            const addParticipantBtns = document.querySelectorAll('.add-participant-btn');
            const doneBtn = document.getElementById('doneBtn');
            const participantModal = document.getElementById('participantModal');
            const modal = bootstrap.Modal.getInstance(participantModal) || new bootstrap.Modal(participantModal);
            const form = document.getElementById('trainingForm');

            // Clear any pre-selected participants
            participantsSelect.innerHTML = '';
            selectedParticipantsDiv.innerHTML = '';

            // Function to update the selected participants display
            function updateSelectedParticipantsDisplay() {
                selectedParticipantsDiv.innerHTML = '';
                Array.from(participantsSelect.options).forEach(option => {
                    const participantDiv = document.createElement('div');
                    participantDiv.className = 'd-flex justify-content-between align-items-center mb-1 p-2 border rounded';
                    const participationTypeSelect = document.querySelector(`.participation-type[data-user-id="${option.value}"]`);
                    const participationType = participationTypeSelect.value;
                    const participationTypeName = participationTypeSelect.options[participationTypeSelect.selectedIndex].text;
                    
                    participantDiv.innerHTML = `
                        <div class="d-flex align-items-center">
                            <span class="me-2">${option.text}</span>
                            <span class="badge bg-info">${participationTypeName}</span>
                        </div>
                        <div>
                            <input type="hidden" name="participants[]" value="${option.value}">
                            <input type="hidden" name="participation_types[${option.value}]" value="${participationType}">
                            <button type="button" class="btn btn-sm btn-danger remove-participant" data-user-id="${option.value}">
                                <i class="bi bi-x"></i> Remove
                            </button>
                        </div>
                    `;
                    selectedParticipantsDiv.appendChild(participantDiv);
                });

                // Log the current state
                console.log('Selected participants:', Array.from(participantsSelect.options).map(opt => ({
                    id: opt.value,
                    name: opt.text
                })));
            }

            // Handle Add Participant button clicks
            addParticipantBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const userId = this.dataset.userId;
                    const participationTypeSelect = document.querySelector(`.participation-type[data-user-id="${userId}"]`);
                    const participationType = participationTypeSelect.value;
                    
                    if (!participationType) {
                        alert('Please select a participation type');
                        return;
                    }

                    // Add to select if not already selected
                    if (!Array.from(participantsSelect.options).some(opt => opt.value === userId)) {
                        const option = new Option(this.dataset.userName, userId);
                        participantsSelect.add(option);
                    }
                    
                    // Update button state
                    this.disabled = true;
                    this.textContent = 'Added';
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-success');
                    
                    // Update display
                    updateSelectedParticipantsDisplay();
                });
            });

            // Handle Remove Participant button clicks
            selectedParticipantsDiv.addEventListener('click', function(e) {
                if (e.target.closest('.remove-participant')) {
                    const button = e.target.closest('.remove-participant');
                    const userId = button.dataset.userId;
                    
                    // Remove from select
                    const option = Array.from(participantsSelect.options).find(opt => opt.value === userId);
                    if (option) {
                        option.remove();
                    }
                    
                    // Reset the Add button in modal
                    const addBtn = document.querySelector(`.add-participant-btn[data-user-id="${userId}"]`);
                    if (addBtn) {
                        addBtn.disabled = false;
                        addBtn.textContent = 'Add';
                        addBtn.classList.remove('btn-success');
                        addBtn.classList.add('btn-primary');
                    }
                    
                    // Update display
                    updateSelectedParticipantsDisplay();
                }
            });

            // Handle Done button click
            doneBtn.addEventListener('click', function() {
                updateSelectedParticipantsDisplay();
                modal.hide();
            });

            // Form validation and submission
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
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                // Check if participants are selected
                const selectedParticipants = form.querySelectorAll('input[name="participants[]"]');
                if (selectedParticipants.length === 0) {
                    alert('Please add at least one participant');
                    isValid = false;
                }

                // Log form data
                const formData = new FormData(form);
                console.log('Form data:', {
                    title: formData.get('title'),
                    competency_id: formData.get('competency_id'),
                    period_from: formData.get('period_from'),
                    period_to: formData.get('period_to'),
                    implementation_date: formData.get('implementation_date'),
                    participants: Array.from(formData.getAll('participants[]')),
                    participation_types: Object.fromEntries(
                        Array.from(formData.entries())
                            .filter(([key]) => key.startsWith('participation_types['))
                            .map(([key, value]) => [key.match(/\[(\d+)\]/)[1], value])
                    )
                });

                if (isValid) {
                    console.log('Form is valid, submitting...');
                    form.submit();
                } else {
                    console.log('Form validation failed');
                    if (firstInvalidField) {
                        firstInvalidField.focus();
                    }
                }
            });

            // Initialize display
            updateSelectedParticipantsDisplay();
        });

        function setPeriodTo() {
            const fromDate = document.getElementById('period_from').value;
            if (fromDate) {
                const date = new Date(fromDate);
                date.setFullYear(date.getFullYear() + 3);
                const toDate = date.toISOString().split('T')[0];
                document.getElementById('period_to').value = toDate;
            }
        }
    </script>
</body>
</html>
