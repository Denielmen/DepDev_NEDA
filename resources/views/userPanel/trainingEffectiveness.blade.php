<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DEPDEV Learning and Development System</title>
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
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/DEPDev_logo.png" alt="NEDA Logo">
                DEPDEV Learning and Development Database System Region VII
            </a>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <div class="user-menu" data-bs-toggle="dropdown" style="cursor:pointer;">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->last_name ?? 'User' }}
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
            <a href="{{ route('user.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('user.training.profile') }}"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="{{ route('user.tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking &
                History</a>
            <a href="{{ route('user.training.effectiveness') }}" class="active"><i
                    class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
            <a href="{{ route('user.training.resources') }}"><i class="bi bi-archive me-2"></i>Training Resources</a>
        </div>
        <!-- Main Content -->
        <div class="main-content">

            <div class="form-container">

                <div class="form-title">
                    Training Effectiveness
                </div>
                <div class="form-container">

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <div class="container">
                        <div class="scrollable-charts-row">
                            @foreach ($competencyCharts as $cid => $yearly)
                                @if (collect($yearly)->filter()->count() > 0)
                                    <div class="chart-col">
                                        <div class="card text-center p-2 w-100"
                                            style="min-width:320px; max-width:600px;">
                                            <h6 class="mb-2" style="font-size: 1.1rem;">
                                                {{ $competencyLabels[$cid] ?? 'Competency' }}
                                            </h6>
                                            <canvas id="competencyBar{{ $cid }}" width="500" height="350"
                                                style="margin:0 auto; display:block;"></canvas>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>


                    <!-- Trainings Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Training Title</th>
                                    <th>Status</th>
                                    <th>Pre-Evaluation Average</th>
                                    <th>Post-Evaluation Average</th>
                                    <th>Average</th>
                                    <th>Evaluation</th>
                                    <th>View Evaluations</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainings->sortByDesc('status') as $training)
                                    <tr>
                                        <td>{{ $training->title }}</td>
                                        <td>
                                            {{ $training->status === 'Pending' ? 'Not yet Implemented' : $training->status }}
                                        </td>
                                        <td>
                                            @php
                                                $pre_rating_display_value = 'Empty';
                                                if (
                                                    $training->participant_pre_rating &&
                                                    $training->supervisor_pre_rating
                                                ) {
                                                    $pre_rating_display_value = round(
                                                        ($training->participant_pre_rating +
                                                            $training->supervisor_pre_rating) /
                                                            2,
                                                        2,
                                                    );
                                                } elseif ($training->participant_pre_rating !== null) {
                                                    $pre_rating_display_value = $training->participant_pre_rating;
                                                } elseif ($training->supervisor_pre_rating !== null) {
                                                    $pre_rating_display_value = $training->supervisor_pre_rating;
                                                }
                                            @endphp
                                            {{ $pre_rating_display_value }}
                                        </td>
                                        <td>
                                            @php
                                                $post_rating_value = null;
                                                if (
                                                    $training->participant_post_rating &&
                                                    $training->supervisor_post_rating
                                                ) {
                                                    $post_rating_value = round(
                                                        ($training->participant_post_rating +
                                                            $training->supervisor_post_rating) /
                                                            2,
                                                        2,
                                                    );
                                                } elseif ($training->participant_post_rating) {
                                                    $post_rating_value = $training->participant_post_rating;
                                                } elseif ($training->supervisor_post_rating) {
                                                    $post_rating_value = $training->supervisor_post_rating;
                                                }
                                            @endphp
                                            @if ($post_rating_value !== null)
                                                {{ $post_rating_value }}
                                            @else
                                                Empty
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $average_rating = 'Empty';
                                                if (
                                                    $pre_rating_display_value !== 'Empty' &&
                                                    $post_rating_value !== null
                                                ) {
                                                    $average_rating = round(
                                                        ($pre_rating_display_value + $post_rating_value) / 2,
                                                        2,
                                                    );
                                                } elseif ($pre_rating_display_value !== 'Empty') {
                                                    $average_rating = $pre_rating_display_value;
                                                } elseif ($post_rating_value !== null) {
                                                    $average_rating = $post_rating_value;
                                                }
                                            @endphp
                                            {{ $average_rating }}
                                        </td>
                                        <td>
                                            @php
                                                $isParticipantPreEvaluated = $training->participant_pre_rating !== null;
                                                $isParticipantPostEvaluated =
                                                    $training->participant_post_rating !== null;
                                            @endphp

                                            @if ($training->status == 'Implemented')
                                                @php
                                                    $postButtonClass = $isParticipantPostEvaluated
                                                        ? 'disabled-button'
                                                        : '';
                                                    $postButtonAttributes = $isParticipantPostEvaluated
                                                        ? 'data-bs-toggle=tooltip data-bs-placement=top title="You have already completed your post-evaluation."'
                                                        : '';
                                                    $activePostButtonAttributes = $isParticipantPostEvaluated
                                                        ? ''
                                                        : 'data-bs-toggle=tooltip data-bs-placement=top title="You can only evaluate this training once." ';
                                                @endphp
                                                <span class="disabled-button-wrapper" {!! $postButtonAttributes !!}>
                                                    <a href="{{ route('user.evalParticipant', ['training_id' => $training->id, 'type' => 'participant_post']) }}"
                                                        class="btn btn-primary btn-sm {!! $postButtonClass !!}"
                                                        {{ $isParticipantPostEvaluated ? 'tabindex=-1 aria-disabled=true' : '' }}
                                                        {!! $activePostButtonAttributes !!}>
                                                        Post-Evaluation
                                                    </a>
                                                </span>
                                            @else
                                                @php
                                                    $preButtonClass = $isParticipantPreEvaluated
                                                        ? 'disabled-button'
                                                        : '';
                                                    $preButtonAttributes = $isParticipantPreEvaluated
                                                        ? 'data-bs-toggle=tooltip data-bs-placement=top title="You have already completed your pre-evaluation."'
                                                        : '';
                                                    $activePreButtonAttributes = $isParticipantPreEvaluated
                                                        ? ''
                                                        : 'data-bs-toggle=tooltip data-bs-placement=top title="You can only evaluate this training once." ';
                                                @endphp
                                                <span class="disabled-button-wrapper" {!! $preButtonAttributes !!}>
                                                    <a href="#"
                                                        class="btn btn-primary btn-sm {!! $preButtonClass !!}"
                                                        data-bs-toggle="modal" data-bs-target="#preEvaluationModal"
                                                        data-training-id="{{ $training->id }}"
                                                        data-evaluation-type="participant_pre"
                                                        {{ $isParticipantPreEvaluated ? 'tabindex=-1 aria-disabled=true' : '' }}
                                                        {!! $activePreButtonAttributes !!}>
                                                        Pre-Evaluation
                                                    </a>
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm view-evaluation-select"
                                                data-training-id="{{ $training->id }}">
                                                <option value="">Select Evaluation</option>
                                                <option value="participant_pre">Own Pre-Evaluation</option>
                                                <option value="participant_post">Own Post-Evaluation</option>
                                                <option value="supervisor_pre">Supervisor Pre-Evaluation</option>
                                                <option value="supervisor_post">Supervisor Post-Evaluation</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                        <form method="POST" id="preEvaluationForm">
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
                        preEvaluationForm.action = `/user/training/${trainingId}/rate`;
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


        <script>
            @foreach ($competencyCharts as $cid => $yearly)
                new Chart(document.getElementById('competencyBar{{ $cid }}'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode(array_keys($yearly)) !!},
                        datasets: [{
                                label: 'Pre',
                                data: {!! json_encode(array_column($yearly, 'pre')) !!},
                                backgroundColor: '#36b9cc'
                            },
                            {
                                label: 'Post',
                                data: {!! json_encode(array_column($yearly, 'post')) !!},
                                backgroundColor: '#4e73df'
                            }
                        ]
                    },
                    options: {
                        responsive: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            title: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 4
                            }
                        }
                    }
                });
            @endforeach
        </script>
</body>

</html>
