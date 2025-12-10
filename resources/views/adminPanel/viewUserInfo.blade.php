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

        .content-container {
            max-width: 1040px;
            width: 100%;
            margin: 0 auto;
        }
        .back-button-container {
            margin-bottom: 20px;
        }
        .btn-back {
            background-color: #003366;
            color: white;
            border: none;
            padding: 8px 25px;
            border-radius: 4px;
            font-weight: 500;
            margin-bottom: 15px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
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
        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
        }
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }
        .certificate-container {
            max-height: 600px;
            overflow-y: auto;
        }
        .certificate-item {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .certificate-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .certificate-preview {
            max-width: 100%;
            max-height: 400px;
            object-fit: contain;
        }
        .no-certificates {
            text-align: center;
            color: #6c757d;
            padding: 40px 20px;
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
            <a href="{{ route('admin.participants') }}" class="active"><i class="bi bi-people me-2"></i>Employees Information</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Training Plan</a>
            <a href="{{ route('admin.search.index') }}"><i class="bi bi-search me-2"></i>Search</a>
        </div>
        <!-- Main Content -->
        <div class="main-content">
            <div class="content-container">
                <div class="back-button-container">
                    <button class="btn btn-back" onclick="window.location.href='{{ route('admin.participants.info', ['id' => $user->id]) }}'">
                        <i class="bi bi-arrow-left"></i>
                        Back
                    </button>
                </div>
                <div class="details-card position-relative">
                    <button class="btn btn-outline-primary position-absolute top-0 end-0 m-3" data-bs-toggle="modal" data-bs-target="#certificateModal" title="View Certificate">
                        <i class="bi bi-eye"></i>
                    </button>
                    <h2 class="details-title">Training Details</h2>
                    <table class="details-table">
                        <tr>
                            <td class="label">Title/Subject Area:</td>
                            <td>{{ $training->title ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Type:</td>
                            <td>{{ $training->core_competency ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Three-Year Period:</td>
                            <td> {{ $training->period_from ?? '' }} - {{ $training->period_to ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Competency:</td>
                            <td>{{ $training->competency->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Period of Implementation:</td>
                            <td>
                                @if($training->implementation_date_from && $training->implementation_date_to)
                                    {{ $training->implementation_date_from->format('m/d/Y') }} - {{ $training->implementation_date_to->format('m/d/Y') }}
                                @elseif($training->implementation_date_from)
                                    {{ $training->implementation_date_from->format('m/d/Y') }}
                                @elseif($training->implementation_date_to)
                                    {{ $training->implementation_date_to->format('m/d/Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Budget:</td>
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
                            <td class="label">Learner's Proficiency Pre-Training Level:</td>
                            <td id="participant_pre_rating_display">{{ $evaluation->participant_pre_rating ?? 'N/A' }}</td>
                        </tr>
                        <tr id="post_rating_row">
                            <td class="label">Learner's Proficiency Post-Training Level:</td>
                            <td id="participant_post_rating_display">{{ $evaluation->participant_post_rating ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Learner's Proficiency Pre-Training Level:</td>
                            <td id="supervisor_pre_rating_display">{{ $evaluation->supervisor_pre_rating ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Learner's Proficiency Post-Training Level:</td>
                            <td>{{ $evaluation->supervisor_post_rating ?? 'N/A' }}</td>
                        </tr>
                    </table>
                    <div class="eval-buttons">
                        @if($evaluation->supervisor_post_rating)
                            <span class="btn btn-eval btn-post-eval disabled" style="pointer-events: none; opacity: 0.6;">
                                <i class="bi bi-clipboard-data"></i>
                                Post-Eval
                            </span>
                        @else
                            <a href="{{ route('admin.training.post-evaluation.user', ['id' => $training->id, 'user_id' => $user->id]) }}"
                               class="btn btn-eval btn-post-eval">
                                <i class="bi bi-clipboard-data"></i>
                                Post-Eval
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
    

    <!-- Certificate Modal -->
    <div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="certificateModalLabel">Training Certificates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="certificate-container">
                        @php
                            $certificates = \App\Models\TrainingMaterial::where('training_id', $training->id)
                                ->where('type', 'certificate')
                                ->get();

                            // Check if there are orphaned certificates that might belong to this training
                            $orphanedCertificates = \App\Models\TrainingMaterial::where('type', 'certificate')
                                ->where('user_id', $user->id)
                                ->whereNull('training_id')
                                ->get();
                        @endphp

                        @if($certificates->isEmpty())
                            <div class="no-certificates">
                                <i class="bi bi-file-earmark-x" style="font-size: 3rem; color: #dee2e6;"></i>
                                <h5 class="mt-3">No Certificates Found</h5>
                                <p>No certificates have been uploaded for this training yet.</p>

                                @if($orphanedCertificates->count() > 0)
                                    <div class="alert alert-warning mt-3">
                                        <h6><i class="bi bi-exclamation-triangle"></i> Found {{ $orphanedCertificates->count() }} unlinked certificate(s)</h6>
                                        <p class="mb-2">There are certificates that might belong to this training but are not properly linked.</p>
                                        <button type="button" class="btn btn-sm btn-warning" onclick="fixCertificates()">
                                            <i class="bi bi-tools"></i> Try to Fix Certificates
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @else
                            @foreach($certificates as $certificate)
                                <div class="certificate-item">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1">{{ $certificate->title }}</h6>
                                            <small class="text-muted">
                                                Uploaded: {{ $certificate->created_at->format('M d, Y') }}
                                            </small>
                                        </div>
                                        @if($certificate->file_path)
                                            <a href="{{ asset('storage/' . $certificate->file_path) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                        @endif
                                    </div>

                                    @if($certificate->file_path)
                                        @php
                                            $fileExtension = pathinfo($certificate->file_path, PATHINFO_EXTENSION);
                                        @endphp

                                        @if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png']))
                                            <div class="text-center">
                                                <img src="{{ asset('storage/' . $certificate->file_path) }}"
                                                     alt="Certificate"
                                                     class="certificate-preview img-fluid">
                                            </div>
                                        @elseif(strtolower($fileExtension) === 'pdf')
                                            <div class="text-center">
                                                <iframe src="{{ asset('storage/' . $certificate->file_path) }}"
                                                        width="100%"
                                                        height="400px"
                                                        style="border: 1px solid #ddd;">
                                                </iframe>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                <i class="bi bi-file-earmark"></i>
                                                Certificate file available for download ({{ strtoupper($fileExtension) }} format)
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // No Pre-Eval interactions; Post-Eval remains as a link
        });

        function fixCertificates() {
            if (confirm('This will try to automatically link unlinked certificates to their corresponding trainings. Continue?')) {
                fetch('{{ route("admin.fixCertificates") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    // Reload the page to see the updated certificates
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while fixing certificates.');
                });
            }
        }
    </script>
</body>
</html>



