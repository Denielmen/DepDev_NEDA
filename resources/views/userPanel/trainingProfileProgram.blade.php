<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Training Profile - Program</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            margin-top: 56px;
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
            background-color: #f8f9fa;
            background-color: rgb(187, 219, 252);
            margin-top: 56px;
        }
        .content-header {
            background-color: #e7f1ff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .content-header h2 {
            color: #003366;
            font-size: 1.5rem;
            margin: 0;
            font-weight: bold;
        }
        .search-box {
            position: relative;
            width: 300px;
        }
        .search-box input {
            width: 100%;
            padding: 8px 15px;
            padding-right: 35px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            background-color: white;
        }
        .search-box .search-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .training-table {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .training-table th {
            background-color: #003366;
            color: white;
            font-weight: 500;
            padding: 12px 15px;
        }
        .training-table td {
            padding: 12px 15px;
            vertical-align: middle;
        }
        .training-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .btn-info {
            background-color: #003366;
            border-color: #003366;
            color: white;
        }
        .btn-info:hover {
            background-color: #004080;
            border-color: #004080;
            color: white;
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
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #fff; position: fixed; top: 0; left: 0; width: 100%; z-index: 1040;">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="/images/DEPDev_logo.png" alt="NEDA Logo" style="height: 30px; margin-right: 10px;">
                    <span style="color: #003366; font-size: 1rem; font-weight: bold;">
                        DEPDEV Learning and Development Database System Region VII
                    </span>
                </a>
            </div>
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
            <a href="{{ route('user.training.profile') }}" class="active"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="{{ route('user.tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
            <a href="{{ route('user.training.effectivenesss') }}"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
            <a href="{{ route('user.training.resources') }}"><i class="bi bi-archive me-2"></i>Training Resources</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-header">
                <h2>Training Profile</h2>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="tab-buttons">
                    <a href="{{ route('user.training.profile.program') }}" class="tab-button active">Programmed</a>
                    <a href="{{ route('user.training.profile.unprogrammed') }}" class="tab-button">Unprogrammed</a>
                </div>
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <i class="bi bi-search search-icon"></i>
                </div>
            </div>

            <div class="training-table">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="background-color: #003366; color: white; border-right: 2px solid white;">Training Title</th>
                            <th class="text-center" style="background-color: #003366; color: white; border-right: 2px solid white;">Competency</th>
                            <th class="text-center" style="background-color: #003366; color: white; border-right: 2px solid white;">Period of Implementation</th>
                            <th class="text-center" style="background-color: #003366; color: white; border-right: 2px solid white;">No. of Hours</th>
                            <th class="text-center" style="background-color: #003366; color: white; border-right: 2px solid white;">Provider</th>
                            <th class="text-center" style="background-color: #003366; color: white; border-right: 2px solid white;">Status</th>
                            <th class="text-center" style="background-color: #003366; color: white; border-right: 2px solid white;">User Role</th>
                            <th class="text-center" style="background-color: #003366; color: white;">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainings as $training)
                        @php
                            $preEvaluated = !is_null($training->participant_pre_rating);
                        @endphp
                        <tr data-training-id="{{ $training->id }}"
                            data-pre-rating="{{ $training->participant_pre_rating ?? '' }}"
                            data-post-rating="{{ $training->participant_post_rating ?? '' }}">
                            <td class="text-center">{{ $training->title }}</td>
                            <td class="text-center">{{ $training->competency->name }}</td>
                            <td class="text-center">
                                @if($training->status === 'Implemented' )
                                    {{ \Carbon\Carbon::parse($training->first()->implementation_date_to)->format('d/m/Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($training->period_from)->format('Y') }}
                                @endif
                            </td>
                            <td class="text-center">{{ $training->no_of_hours }}</td>
                            <td class="text-center">{{ $training->provider }}</td>
                            <td class="text-center">
                                {{ $training->status === 'Pending' ? 'Not yet Implemented' : $training->status }}
                            </td>
                            <td class="text-center">Participant</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('user.training.profile.show', $training->id) }}" class="btn btn-info btn-sm">View</a>
                                    <button class="btn btn-sm ms-1 open-eval-modal {{ $preEvaluated ? 'btn-success' : 'btn-warning' }}" data-training="{{ $training->id }}" data-type="Pre-Evaluation" data-evaluated="{{ $preEvaluated ? '1' : '0' }}">Pre-Evaluation</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
            @if($trainings->count())
                <div class="d-flex justify-content-end mt-3 mb-3">
                    <a href="{{ route('user.training.export', $trainings->first()->id) }}" class="btn btn-info">
                        <i class="bi bi-download me-2"></i>Export
                    </a>
                </div>  
            @endif
        </div>
    </div>

    <!-- Evaluation Modal -->
    <div class="modal fade" id="evaluationModal" tabindex="-1" aria-labelledby="evaluationModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="evaluationModalLabel">Evaluation</h5>
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
                      In a scale 1-4 (4 is being the highest ), please tick the circle which describes the proficiency level of your subordinate after participation in this course.
                    </td>
                    <th class="text-center">1</th>
                    <th class="text-center">2</th>
                    <th class="text-center">3</th>
                    <th class="text-center">4</th>
                  </tr>
                  <tr>
                    <td class="text-center"><input type="radio" name="proficiency_level" value="1"></td>
                    <td class="text-center"><input type="radio" name="proficiency_level" value="2"></td>
                    <td class="text-center"><input type="radio" name="proficiency_level" value="3"></td>
                    <td class="text-center"><input type="radio" name="proficiency_level" value="4"></td>
                  </tr>
                </table>
              </div>
            </div>
            <input type="hidden" id="modalTrainingId" value="">
            <input type="hidden" id="modalEvalType" value="">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedRating = null;
        document.querySelectorAll('.open-eval-modal').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var type = this.getAttribute('data-type');
                var trainingId = this.getAttribute('data-training');
                var evaluated = this.getAttribute('data-evaluated') === '1';
                document.getElementById('evaluationModalLabel').textContent = type;
                document.getElementById('modalTrainingId').value = trainingId;
                document.getElementById('modalEvalType').value = type;
                // Reset radio buttons
                document.querySelectorAll('input[name="proficiency_level"]').forEach(r => {
                    r.checked = false;
                    r.disabled = false;
                });
                selectedRating = null;
                // Show current rating if exists
                var row = document.querySelector(`tr[data-training-id='${trainingId}']`);
                var currentRating = '';
                if (type === 'Pre-Evaluation') {
                    currentRating = row.getAttribute('data-pre-rating');
                } else {
                    currentRating = row.getAttribute('data-post-rating');
                }
                var msgDiv = document.getElementById('currentRatingMsg');
                if (currentRating && currentRating !== 'null') {
                    msgDiv.textContent = `Your previous rating: ${currentRating}`;
                    // Pre-select radio
                    document.querySelectorAll('input[name="proficiency_level"]').forEach(r => {
                        if (r.value === currentRating) r.checked = true;
                    });
                    selectedRating = currentRating;
                } else {
                    msgDiv.textContent = '';++
                }
                // If already evaluated, make radios readonly and hide submit
                var submitBtn = document.querySelector('#evaluationModal .btn-primary');
                if (evaluated) {
                    document.querySelectorAll('input[name="proficiency_level"]').forEach(r => r.disabled = true);
                    submitBtn.style.display = 'none';
                } else {
                    document.querySelectorAll('input[name="proficiency_level"]').forEach(r => r.disabled = false);
                    submitBtn.style.display = '';
                }
                var modal = new bootstrap.Modal(document.getElementById('evaluationModal'));
                modal.show();
            });
        });
        document.querySelectorAll('input[name="proficiency_level"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                selectedRating = this.value;
            });
        });
        document.querySelector('#evaluationModal .btn-primary').addEventListener('click', function() {
            var trainingId = document.getElementById('modalTrainingId').value;
            var type = document.getElementById('modalEvalType').value;
            if (!selectedRating) {
                alert('Please select a proficiency level.');
                return;
            }
            fetch(`/training/${trainingId}/rate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    type: type,
                    rating: selectedRating
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the row's data attribute
                    var row = document.querySelector(`tr[data-training-id='${trainingId}']`);
                    if (type === 'Pre-Evaluation') {
                        row.setAttribute('data-pre-rating', data.pre_rating);
                    } else {
                        row.setAttribute('data-post-rating', data.post_rating);
                    }
                    // Update modal message
                    document.getElementById('currentRatingMsg').textContent = `Your previous rating: ${selectedRating}`;
                    // Close modal
                    bootstrap.Modal.getInstance(document.getElementById('evaluationModal')).hide();
                } else {
                    alert('Failed to save rating.');
                }
            })
            .catch(() => alert('Failed to save rating.'));
        });
    </script>
</body>
</html>