<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Training Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f7f8fa;
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
        .nav-link, .user-menu {
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
            margin-top: 50px;
            padding-bottom: 20px;

        }
        .details-card {
            max-width: 1040px;
            width: 100%;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 32px 32px 24px 32px;
            /* position: relative;
            padding-right: 180px; */
        }
        .details-title {
            color: #003366;
            font-weight: 700;
            text-align: center;
            margin-bottom: 32px;
        }
        .details-table {
            width: 100%;
        }
        .details-table td {
            padding: 10px 0;
            border-top: none;
            border-bottom: 1px solid #e9ecef;
            vertical-align: top;
        }
        .details-table td.label {
            color: #003366;
            font-weight: 500;
            width: 220px;
        }
        .details-table tr:last-child td {
            border-bottom: none;
        }

        .btn-back {
            background-color: #003366;
            color: #fff;
            border: none;
            padding: 8px 25px;
            border-radius: 4px;
            font-weight: 500;
            margin-bottom: 15px;
            text-decoration: none;
            margin-right: 900px;
            /* gap: 5px;
            transition: all 0.3s ease; */
        }
        .btn-back:hover {
            background-color: #004080;
            color: #fff;
            transform: translateY(-1px);
        }
        .eval-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        .btn-eval {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            min-width: 180px;
            justify-content: center;
        }
        .btn-pre-eval {
            background-color: #4a90e2;
            color: white;
        }
        .btn-pre-eval:hover {
            background-color: #357abd;
            color: white;
            transform: translateY(-2px);
        }
        .btn-post-eval {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
        }
        .btn-post-eval:hover {
            background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
            color: white;
            transform: translateY(-2px);
        }
        .btn-eval i {
            font-size: 1.2rem;
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
            <a href="{{ route('admin.participants') }}" class="active"><i class="bi bi-people me-2"></i>Employee's Profile</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
            <a href="{{ route('admin.search.index') }}"><i class="bi bi-search me-2"></i>Search</a>
        </div>
        <!-- Main Content -->
        <div class="main-content">
            <div class="top-actions">
                <button class="btn btn-back" onclick="window.location.href='{{ route('admin.participants.info', ['id' => $user->id]) }}'">
                    <i class="bi bi-arrow-left"></i>
                    Back
                </button>
            </div>
            <div class="details-card">
                <h2 class="details-title">Training Details</h2>
                <table class="details-table">
                    <tr>
                        <td class="label">Title/Area:</td>
                        <td>{{ $training->title ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Three-Year Period:</td>
                        <td>From: {{ $training->period_from ?? '' }} To: {{ $training->period_to ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Competency:</td>
                        <td>{{ $training->competency->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Year of Implementation:</td>
                        <td>{{ $training->implementation_date_from ? $training->implementation_date_from->format('m/d/Y') : '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Budget (per hour):</td>
                        <td>{{ $training->budget ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">No. of Hours:</td>
                        <td>{{ $training->no_of_hours ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Learning Service Provider:</td>
                        <td>{{ $training->provider ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Development Target:</td>
                        <td>{{ $training->dev_target ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Performance Goal this Support:</td>
                        <td>{{ $training->performance_goal ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Objective:</td>
                        <td>{{ $training->objective ?? '' }}</td>
                    </tr>
                    <tr id="pre_rating_row">
                        <td class="label">Participant Pre-Rating:</td>
                        <td id="participant_pre_rating_display">{{ $training->participant_pre_rating ?? 'N/A' }}</td>
                    </tr>
                    <tr id="post_rating_row">
                        <td class="label">Participant Post-Rating:</td>
                        <td id="participant_post_rating_display">{{ $training->participant_post_rating ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Supervisor Pre-Rating:</td>
                        <td id="supervisor_pre_rating_display">{{ $training->supervisor_pre_rating ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Supervisor Post-Rating:</td>
                        <td>{{ $training->supervisor_post_rating ?? 'N/A' }}</td>
                    </tr>
                </table>
                <div class="eval-buttons">
                    <button class="btn btn-eval btn-pre-eval" onclick="showPreEvalModal({{ $training->id }})">
                        <i class="bi bi-clipboard-check"></i>
                        Pre-Eval
                    </button>
                    <a href="{{ route('admin.training.post-evaluation', ['id' => $training->id]) }}" 
                       class="btn btn-eval btn-post-eval" 
                       {{ $training->supervisor_post_rating ? 'disabled' : '' }}>
                        <i class="bi bi-clipboard-data"></i>
                        Post-Eval
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
    <!-- Evaluation Modal -->
    <div class="modal fade" id="evaluationModal" tabindex="-1" aria-labelledby="evaluationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="evaluationModalLabel">Pre-Evaluation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-header fw-bold">D. Learner's Proficiency Level</div>
                        <div class="card-body p-0">
                            <div id="currentRatingMsg" class="mb-2 text-primary"></div>
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <td rowspan="2" style="vertical-align: middle; width:60%">
                                        In a scale 4-1 (4 being the highest), please tick the circle which best describes the proficiency level of your subordinate after participation in this course.
                                    </td>
                                    <th class="text-center">1</th>
                                    <th class="text-center">2</th>
                                    <th class="text-center">3</th>
                                    <th class="text-center">4</th>
                                </tr>
                                <tr id="rating_inputs">
                                    <td class="text-center"><input type="radio" name="proficiency_level" value="1" required></td>
                                    <td class="text-center"><input type="radio" name="proficiency_level" value="2"></td>
                                    <td class="text-center"><input type="radio" name="proficiency_level" value="3"></td>
                                    <td class="text-center"><input type="radio" name="proficiency_level" value="4"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" id="modalTrainingId" value="">
                    @csrf
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitEvaluationBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const evaluationModal = new bootstrap.Modal(document.getElementById('evaluationModal'));
            const submitEvaluationBtn = document.getElementById('submitEvaluationBtn');
            const preRatingDisplay = document.getElementById('participant_pre_rating_display');
            const ratingInputs = document.querySelectorAll('input[name="proficiency_level"]');

            window.showPreEvalModal = function(trainingId) {
                // Get the current supervisor pre-rating from the table
                const supervisorPreRatingDisplay = document.getElementById('supervisor_pre_rating_display');
                const currentRating = supervisorPreRatingDisplay ? supervisorPreRatingDisplay.textContent : 'N/A';
                document.getElementById('modalTrainingId').value = trainingId;

                // If there's a previous rating, show it and disable inputs
                if (currentRating && currentRating !== 'N/A') {
                    ratingInputs.forEach(input => {
                        input.disabled = true;
                        if (input.value === currentRating) {
                            input.checked = true;
                        }
                    });
                    submitEvaluationBtn.disabled = true;
                    submitEvaluationBtn.style.cursor = 'not-allowed';
                    // Optionally show a message indicating it's already rated
                    document.getElementById('currentRatingMsg').textContent = 'This training has already been pre-evaluated by the supervisor.';
                    document.getElementById('currentRatingMsg').style.display = 'block';
                } else {
                    // If no rating yet, enable inputs and submit button
                    ratingInputs.forEach(input => {
                        input.disabled = false;
                        input.checked = false;
                    });
                    submitEvaluationBtn.disabled = false;
                    submitEvaluationBtn.style.cursor = 'pointer';
                    document.getElementById('currentRatingMsg').style.display = 'none'; // Hide message
                }

                evaluationModal.show();
            };

            if (submitEvaluationBtn) {
                submitEvaluationBtn.addEventListener('click', function () {
                    const rating = document.querySelector('input[name="proficiency_level"]:checked');
                    const trainingId = document.getElementById('modalTrainingId').value;
                    const csrfToken = document.querySelector('input[name="_token"]').value;

                    if (!rating || !trainingId) {
                        alert('Please select a rating.');
                        return;
                    }

                    // Disable inputs and button immediately on submit attempt
                    ratingInputs.forEach(input => input.disabled = true);
                    submitEvaluationBtn.disabled = true;
                    submitEvaluationBtn.style.cursor = 'not-allowed';

                    fetch('{{ route('admin.training.rate', ':id') }}'.replace(':id', trainingId), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            type: 'Supervisor-Pre-Evaluation',
                            rating: rating.value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Pre-Evaluation submitted successfully!');
                            evaluationModal.hide();
                            // Update the display with the new rating
                            document.getElementById('supervisor_pre_rating_display').textContent = data.supervisor_pre_rating;

                            // Inputs and button are already disabled from the attempt, keep them that way

                        } else {
                            alert('Error submitting evaluation.' + (data.message ? ': ' + data.message : ''));
                            // Re-enable inputs and button on failure so user can try again
                            ratingInputs.forEach(input => input.disabled = false);
                            submitEvaluationBtn.disabled = false;
                            submitEvaluationBtn.style.cursor = 'pointer';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while submitting the evaluation.');
                        // Re-enable inputs and button on error so user can try again
                        ratingInputs.forEach(input => input.disabled = false);
                        submitEvaluationBtn.disabled = false;
                        submitEvaluationBtn.style.cursor = 'pointer';
                    });
                });
            }
        });
    </script>
</body>
</html> 