<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>lnd.dro7.depdev</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1040;
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
        }

        .sidebar {
            background-color: #003366;
            min-height: calc(100vh - 56px);
            width: 270px;
            padding-top: 20px;
            position: fixed;
            top: 56px;
            left: 0;
            height: calc(100vh - 56px);
            z-index: 1030;
            overflow-y: auto;
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

        .back-button {
            text-decoration: none;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
            border-radius: 10px;
            color: #003366;
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: rgb(187, 219, 252);
            margin-left: 270px;
            margin-top: 56px;
            min-height: calc(100vh - 56px);
        }

        .form-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding-bottom: 50px;
        }

        .form-title {
            background-color: #e6f3ff;
            padding: 15px;
            margin: -20px -20px 20px -20px;
            border-radius: 8px 8px 0 0;
            color: #003366;
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 50px;
        }

        .roles {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            padding: 75px;
            border-radius: 10px;
            background-color: #f8f9fa;
            border: 1px solid black;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;

        }

        .choicebox {
            display: flex;
            justify-content: center;
            align-items: stretch;
            gap: 20px;
            flex-wrap: wrap;
            width: 100%;
        }

        .choice {
            padding: 20px;
            border-radius: 30px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: calc(50% - 20px);
            max-width: 300px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: auto;
            transition: box-shadow 0.3s ease;
            cursor: pointer;
        }

        .choice:hover {
            box-shadow: -10px 8px 3px 0px #aaa;
        }


        .choice i {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .choice div {
            background-color: #79a7f5;
            padding: 15px;
            border-radius: 20px;
            text-align: left;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .choice h5 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .choice p {
            margin: 0;
            font-size: 14px;
            word-wrap: break-word;
            flex-grow: 1;
            display: flex;
            align-items: flex-start;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item.text-danger:hover {
            background-color: #dc3545;
            color: white !important;
            cursor: pointer;
        }

        .scrollable-charts-row {
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 10px;
        }

        .scrollable-charts-row .chart-col {
            display: inline-block;
            vertical-align: top;
            width: 600px;
            /* Adjust width as needed */
            max-width: 90vw;
            margin-right: 16px;
        }

        @media (max-width: 700px) {
            .scrollable-charts-row .chart-col {
                width: 95vw;
                min-width: 320px;
            }
        }

        /* Fix pagination styling */
        .pagination {
            margin: 0;
        }

        .pagination .page-link {
            padding: 0.375rem 0.75rem;
            margin: 0 0.125rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
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
        .table td:nth-child(1) {
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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
            <a href="{{ route('user.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('user.training.profile') }}"><i class="bi bi-person-vcard me-2"></i>Individual Training Profile</a>
            <a href="{{ route('user.tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking &
                History</a>
            <a href="{{ route('user.training.effectiveness') }}" class="active"><i
                    class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
            <a href="{{ route('user.training.resources') }}"><i class="bi bi-archive me-2"></i>Training Resources</a>
        </div>
        <!-- Main Content -->
        <div class="main-content">

            <div class="form-container">

                <h2 class="resources-title">Training Effectiveness</h2>
                
                <!-- <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="tab-buttons">
                        <a href="{{ route('user.training.effectiveness') }}" class="tab-button active">Programmed Trainings</a>
                        <a href="{{ route('user.training.effectiveness.unprogrammed') }}" class="tab-button">Completed Trainings</a>
                    </div>
                </div> -->

                <div class="form-container">
                    <!-- Trainings Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th class="text-center align-middle">Training Programmed/Title/Subject Area</th>
                                    <th class="text-center">Learner's Pre-Training Proficiency Level</th>
                                    <th class="text-center">
                                        <div>Learner's Post-Training Proficiency Level</div>
                                        <div class="d-flex">
                                            <div class="text-center flex-grow-1 border-end">User</div>
                                            <div class="text-center flex-grow-1">Supervisor</div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainings->sortByDesc('status') as $training)
                                    @php
                                        $evaluation = $training->evaluations->where('user_id', Auth::id())->first();
                                        $isParticipantPreEvaluated = $evaluation && $evaluation->participant_pre_rating !== null;
                                        $isParticipantPostEvaluated = $evaluation && $evaluation->participant_post_rating !== null;
                                        $hasTracking = $training->implementation_date_from !== null;
                                        $isImplementedForUser = $isParticipantPreEvaluated && $hasTracking;
                                        
                                        $preButtonClass = $isParticipantPreEvaluated ? 'disabled-button' : '';
                                        $postButtonClass = $isParticipantPostEvaluated ? 'disabled-button' : '';
                                        $preButtonAttributes = $isParticipantPreEvaluated ? 'data-bs-toggle=tooltip data-bs-placement=top title="You have already completed your pre-evaluation."' : '';
                                        $activePreButtonAttributes = $isParticipantPreEvaluated ? '' : 'data-bs-toggle=tooltip data-bs-placement=top title="You can only evaluate this training once."';
                                        $postButtonAttributes = $isParticipantPostEvaluated ? 'data-bs-toggle=tooltip data-bs-placement=top title="You have already completed your post-evaluation."' : '';
                                        $activePostButtonAttributes = $isParticipantPostEvaluated ? '' : 'data-bs-toggle=tooltip data-bs-placement=top title="You can only evaluate this training once."';
                                    @endphp
                                    <tr>
                                        <td class="align-middle text-center">{{ $training->title }}</td>
                                        <td class="text-center">
                                            @if($isParticipantPreEvaluated)
                                                {{ $evaluation->participant_pre_rating }}
                                            @else
                                                <a href="#" class="btn btn-success btn-sm {!! $preButtonClass !!}"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#preEvaluationModal" 
                                                    data-training-id="{{ $training->id }}" 
                                                    data-evaluation-type="participant_pre"
                                                    {!! $activePreButtonAttributes !!}> 
                                                    Evaluate
                                                </a>
                                            @endif
                                        </td>
                                        <td class="p-0">
                                            <div class="d-flex w-100">
                                                <div class="text-center flex-grow-1 p-1 border-end d-flex align-items-center justify-content-center" style="min-height: 40px; width: 50%;">
                                                    @if($isParticipantPostEvaluated)
                                                        {{ $evaluation->participant_post_rating }}
                                                    @elseif($isParticipantPreEvaluated)
                                                        <a href="{{ route('user.evalParticipant', ['training_id' => $training->id, 'type' => 'participant_post']) }}" 
                                                           class="btn btn-danger btn-sm {!! $postButtonClass !!}"
                                                           {!! $activePostButtonAttributes !!}>
                                                            Evaluate
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="text-center flex-grow-1 p-1 d-flex align-items-center justify-content-center" style="min-height: 40px; width: 50%;">
                                                    @php
                                                        $isSupervisorPostEvaluated = $evaluation && $evaluation->supervisor_post_rating !== null;
                                                    @endphp
                                                    @if($isSupervisorPostEvaluated)
                                                        {{ $evaluation->supervisor_post_rating }}
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-end mt-3">
                        <nav aria-label="Training pagination">
                            <ul class="pagination pagination-sm">
                                {{-- Previous Page Link --}}
                                @if ($trainings->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $trainings->previousPageUrl() }}">Previous</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($trainings->getUrlRange(1, $trainings->lastPage()) as $page => $url)
                                    @if ($page == $trainings->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($trainings->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $trainings->nextPageUrl() }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->

        </div>

        <!-- Pre-Evaluation Modal -->
        <div class="modal fade" id="preEvaluationModal" tabindex="-1" aria-labelledby="preEvaluationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="preEvaluationModalLabel">Pre-Evaluation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Message area for "No data" -->
                        <div id="preEvaluationNoDataMessage" class="alert alert-info text-center"
                            style="display: none;">
                            No pre-evaluation data found for this training.
                        </div>
                        <form method="POST" id="preEvaluationForm" action="#">
                            @csrf
                            <input type="hidden" name="training_id" id="modalTrainingId">
                            <input type="hidden" name="type" id="modalEvaluationType">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="5">D. Learner's Proficiency Level</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width: 70%;">In a scale 1-4 (4 is being the highest), please
                                                tick
                                                the circle which describes the proficiency level of your subordinate
                                                after participation in this course.</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><input class="form-check-input" type="radio"
                                                    name="proficiency_level" id="proficiency1" value="1"></td>
                                            <td><input class="form-check-input" type="radio"
                                                    name="proficiency_level" id="proficiency2" value="2"></td>
                                            <td><input class="form-check-input" type="radio"
                                                    name="proficiency_level" id="proficiency3" value="3"></td>
                                            <td><input class="form-check-input" type="radio"
                                                    name="proficiency_level" id="proficiency4" value="4"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="preEvaluationForm" class="btn btn-primary"
                            id="submitPreEvaluation">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const preEvaluationModal = document.getElementById('preEvaluationModal');
                const preEvaluationForm = document.getElementById('preEvaluationForm');
                const submitPreEvaluationButton = document.getElementById('submitPreEvaluation');
                const modalProficiencyRadios = preEvaluationForm.querySelectorAll('input[name="proficiency_level"]');
                const preEvaluationNoDataMessage = document.getElementById('preEvaluationNoDataMessage');

                // Initialize tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                })
                console.log(`Initialized ${tooltipList.length} Bootstrap tooltips.`);

                preEvaluationModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const trainingId = button.getAttribute('data-training-id');
                    const type = button.getAttribute(
                        'data-evaluation-type'); // 'participant_pre' for submission
                    const isViewMode = button.classList.contains(
                        'view-evaluation-option'); // Check if from view dropdown

                    document.getElementById('modalTrainingId').value = trainingId;
                    document.getElementById('modalEvaluationType').value = type;

                    if (isViewMode) {
                        // View mode: disable inputs and fetch data
                        submitPreEvaluationButton.style.display = 'none';
                        modalProficiencyRadios.forEach(radio => radio.disabled = true);
                        preEvaluationForm.action = '#'; // No submission in view mode
                        fetchPreEvaluationData(trainingId, type);
                    } else {
                        // Submission mode: enable inputs
                        submitPreEvaluationButton.style.display = 'block';
                        modalProficiencyRadios.forEach(radio => radio.disabled = false);
                        preEvaluationForm.action = `/user/training/${trainingId}/submit-pre-evaluation`;
                        preEvaluationNoDataMessage.style.display = 'none';
                        preEvaluationForm.style.display = 'block';
                    }
                    console.log('Form action set to:', preEvaluationForm.action); // Debugging line
                });

                // Function to fetch and display pre-evaluation data
                async function fetchPreEvaluationData(trainingId, type) {
                    try {
                        const response = await fetch(`/user/evaluation/view/${trainingId}/${type}`, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        });
                        const data = await response.json();

                        if (data.success && data.rating !== null) {
                            const rating = data.rating;
                            modalProficiencyRadios.forEach(radio => {
                                radio.checked = (parseInt(radio.value) === rating);
                            });
                            preEvaluationNoDataMessage.style.display = 'none';
                            preEvaluationForm.style.display = 'block';
                        } else {
                            // No data found
                            preEvaluationNoDataMessage.style.display = 'block';
                            preEvaluationForm.style.display = 'none'; // Hide the form if no data
                        }
                    } catch (error) {
                        console.error('Error fetching pre-evaluation data:', error);
                        preEvaluationNoDataMessage.textContent = 'Error loading evaluation data.';
                        preEvaluationNoDataMessage.style.display = 'block';
                        preEvaluationForm.style.display = 'none';
                    }
                }

                // Event listener for the "View Evaluations" dropdown
                document.querySelectorAll('.view-evaluation-select').forEach(selectElement => {
                    selectElement.addEventListener('change', function() {
                        const trainingId = this.getAttribute('data-training-id');
                        const selectedType = this.value;

                        if (selectedType === 'participant_pre' || selectedType === 'supervisor_pre') {
                            // For pre-evaluations, open the modal in view mode
                            const tempButton = document.createElement('button');
                            tempButton.setAttribute('data-bs-toggle', 'modal');
                            tempButton.setAttribute('data-bs-target', '#preEvaluationModal');
                            tempButton.setAttribute('data-training-id', trainingId);
                            tempButton.setAttribute('data-evaluation-type', selectedType);
                            tempButton.classList.add('view-evaluation-option'); // Mark as view mode
                            // Programmatically click the temporary button to trigger modal show event
                            document.body.appendChild(
                                tempButton); // Needs to be in DOM to trigger modal
                            tempButton.click();
                            document.body.removeChild(tempButton); // Clean up
                        } else if (selectedType === 'participant_post' || selectedType ===
                            'supervisor_post') {
                            // For post-evaluations, redirect to a new view-only page
                            if (selectedType) {
                                window.location.href =
                                    `{{ url('user/evaluation/view') }}/${trainingId}/${selectedType}`;
                            }
                        }
                        this.value = ''; // Reset dropdown
                    });
                });

                submitPreEvaluationButton.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent default form submission

                    const formData = new FormData(preEvaluationForm);
                    const trainingId = formData.get('training_id');
                    const type = formData.get('type');
                    const rating = formData.get('proficiency_level');

                    if (!rating) {
                        alert('Please select a proficiency level.');
                        return;
                    }

                    fetch(preEvaluationForm.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                training_id: trainingId,
                                type: type,
                                rating: rating
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message); // Show success message
                                bootstrap.Modal.getInstance(preEvaluationModal).hide(); // Close modal

                                // Update the table row dynamically
                                const row = document.querySelector(`tr[data-training-id="${trainingId}"]`);
                                if (row) {
                                    // Assuming the order of columns is consistent
                                    // Training Title, Status, Pre-Evaluation Rating, Post-Evaluation Rating, Average, Evaluation, View Evaluations
                                    const preRatingCell = row.children[
                                        2]; // Index 2 for Pre-Evaluation Rating
                                    const postRatingCell = row.children[
                                        3]; // Index 3 for Post-Evaluation Rating
                                    const averageCell = row.children[4]; // Index 4 for Average

                                    if (type === 'participant_pre') {
                                        preRatingCell.textContent = data.pre_rating !== null ? data
                                            .pre_rating : 'Empty';
                                    } else if (type === 'participant_post') {
                                        postRatingCell.textContent = data.post_rating !== null ? data
                                            .post_rating : 'Empty';
                                    }

                                    // Recalculate and update Average if both are available
                                    const currentPre = parseFloat(preRatingCell.textContent) || 0;
                                    const currentPost = parseFloat(postRatingCell.textContent) || 0;

                                    if (preRatingCell.textContent !== 'Empty' && postRatingCell
                                        .textContent !== 'Empty') {
                                        averageCell.textContent = ((currentPre + currentPost) / 2).toFixed(
                                            2);
                                    } else if (preRatingCell.textContent !== 'Empty') {
                                        averageCell.textContent = currentPre.toFixed(2);
                                    } else if (postRatingCell.textContent !== 'Empty') {
                                        averageCell.textContent = currentPost.toFixed(2);
                                    } else {
                                        averageCell.textContent = 'Empty';
                                    }
                                }
                            } else {
                                alert('Error: ' + data.message + (data.errors ? '\n' + JSON.stringify(data
                                    .errors, null, 2) : ''));
                            }
                        })
                        .catch(error => {
                            console.error('Error during pre-evaluation submission:', error);
                            alert('An unexpected error occurred. Please try again.');
                        });
                });
            });
        </script>
</body>

</html>
