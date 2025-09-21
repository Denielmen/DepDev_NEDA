<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>lnd.dro7.depdev</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
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

        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 270px;
            height: calc(100vh - 56px);
            overflow-y: auto;
            background-color: #003366;
            padding-top: 20px;
            z-index: 999;
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
            margin-left: 290px;
            margin-top: 76px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: #f9f9f9;
            text-align: center;
            font-weight: bold;
            text-align: left;
        }


        .rating-cell {
            text-align: center;
        }

        select,
        textarea {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            margin-top: 5px;
        }

        textarea {
            height: 80px;
            resize: vertical;
        }

        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 20px auto 0;
        }

        button:hover {
            background: #0056b3;
        }


        .back-button {
            text-decoration: none;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
            border-radius: 8px;
            color: #003366;
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .btn-back-minimal {
            display: inline-flex;
            align-items: center;
            font-size: 0.95rem;
            color: #002060;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }

        .btn-back-minimal:hover {
            background-color: rgba(0, 32, 96, 0.05);
        }

        .evaluation-container {
            max-width: 100%;
            padding: 2.5rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .evaluation-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .evaluation-header h4,
        .evaluation-header h5,
        .evaluation-header h6,
        .evaluation-header p {
            color: #002060;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .neda-logo {
            width: 80%;
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto 1.5rem auto;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .form-actions {
            text-align: center;
            margin-top: 3rem;
        }

        .btn-primary {
            background: #002060;
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: #001540;
        }

        .instruction-container {
            margin-top: 30px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .evaluation-container {
                padding: 1rem;
                margin: 1rem;
            }
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
                            <li><hr class="dropdown-divider"></li>
                        </li>
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
        <div class="sidebar" style="top: 56px;">
            <a href="{{ route('user.home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('user.training.profile') }}"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
            <a href="{{ route('user.tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
            <a href="{{ route('user.training.effectiveness') }}" class="active"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
            <a href="{{ route('user.training.resources') }}"><i class="bi bi-archive me-2"></i>Training Resources</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="back-button">
                <a href="{{ route('user.training.effectiveness') }}" class="btn-back-minimal">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back
                </a>
            </div>

            <div class="evaluation-container">
                <div class="evaluation-header">
                    <img src="{{ asset('images/DEPDev_logo_text_center.png') }}" alt="NEDA Logo" class="neda-logo">

                    <h6>EVALUATION OF TRAINING EFFECTIVENESS</h6>
                    <p>(For Participant)</p>
                </div>

                @if($evaluation && $evaluation->participant_post_evaluation)
                <div class="alert alert-info">
                    <strong>Note:</strong> You have already submitted a post-evaluation for this training. You can view your previous submission below.
                </div>
                @endif

                <form method="POST" action="{{ route('user.training.submit.participant.evaluation', ['id' => $training->id]) }}" class="evaluation-form">
                    @csrf
                    <input type="hidden" name="training_id" value="{{ $training->id }}">
                    <input type="hidden" name="type" value="participant_post">

                    <div class="instruction-container">
                        <p><strong>Please tick the circle which best describes your evaluation of the program. You have 4 choices to choose from:</strong> (4) Very Satisfied; (3) Satisfied; <br>(2) Dissatisfied; (1) Very Dissatisfied.</p>
                    </div>

                    <table>
                        <tr>
                            <th style="width: 60%;">A. Learning Goals/Objectives</th>
                            <th style="width: 5%; text-align: center;">1</th>
                            <th style="width: 5%; text-align: center;">2</th>
                            <th style="width: 5%; text-align: center;">3</th>
                            <th style="width: 5%; text-align: center;">4</th>
                        </tr>
                        <tr>
                            <td>How satisfied are you in the achievement of your learning goals/objectives as specified in your learner's profile.</td>
                            <td class="rating-cell"><input type="radio" name="goals" value="1" required {{ $evaluation && $evaluation->participant_post_evaluation && $evaluation->participant_post_evaluation['goals'] == 1 ? 'checked' : '' }} {{ $evaluation && $evaluation->participant_post_evaluation ? 'disabled' : '' }}></td>
                            <td class="rating-cell"><input type="radio" name="goals" value="2" {{ $evaluation && $evaluation->participant_post_evaluation && $evaluation->participant_post_evaluation['goals'] == 2 ? 'checked' : '' }} {{ $evaluation && $evaluation->participant_post_evaluation ? 'disabled' : '' }}></td>
                            <td class="rating-cell"><input type="radio" name="goals" value="3" {{ $evaluation && $evaluation->participant_post_evaluation && $evaluation->participant_post_evaluation['goals'] == 3 ? 'checked' : '' }} {{ $evaluation && $evaluation->participant_post_evaluation ? 'disabled' : '' }}></td>
                            <td class="rating-cell"><input type="radio" name="goals" value="4" {{ $evaluation && $evaluation->participant_post_evaluation && $evaluation->participant_post_evaluation['goals'] == 4 ? 'checked' : '' }} {{ $evaluation && $evaluation->participant_post_evaluation ? 'disabled' : '' }}></td>
                        </tr>
                    </table>

                    <div class="instruction-container">
                        <p><strong>Please tick the circle which best describes your evaluation of the program. You have 5 choices to choose from:</strong> (4) Strongly agree, (3) Agree, <br>(2) Disagree, (1) Strongly Disagree, (Na) Not Applicable</p>
                    </div>

                    <table>
                        <tr>
                            <th style="width: 60%;">B. Application of Learning</th>
                            <th style="width: 5%; text-align: center;">1</th>
                            <th style="width: 5%; text-align: center;">2</th>
                            <th style="width: 5%; text-align: center;">3</th>
                            <th style="width: 5%; text-align: center;">4</th>
                            <th style="width: 5%; text-align: center;">NA</th>
                        </tr>
                        <tr>
                            <td>1. I applied the learning/s gained from this course to my work.</td>
                            <td class="rating-cell"><input type="radio" name="learning1" value="1" required></td>
                            <td class="rating-cell"><input type="radio" name="learning1" value="2"></td>
                            <td class="rating-cell"><input type="radio" name="learning1" value="3"></td>
                            <td class="rating-cell"><input type="radio" name="learning1" value="4"></td>
                            <td class="rating-cell"><input type="radio" name="learning1" value="NA"></td>
                        </tr>
                        <tr>
                            <td>2. The learning/s gained provided me with additional knowledge and skills to perform my role and tasks assigned.</td>
                            <td class="rating-cell"><input type="radio" name="learning2" value="1"></td>
                            <td class="rating-cell"><input type="radio" name="learning2" value="2"></td>
                            <td class="rating-cell"><input type="radio" name="learning2" value="3"></td>
                            <td class="rating-cell"><input type="radio" name="learning2" value="4"></td>
                            <td class="rating-cell"><input type="radio" name="learning2" value="NA"></td>
                        </tr>
                        <tr>
                            <td>3. The learning/s gained contributed to making better quality and more efficient work.</td>
                            <td class="rating-cell"><input type="radio" name="learning3" value="1"></td>
                            <td class="rating-cell"><input type="radio" name="learning3" value="2"></td>
                            <td class="rating-cell"><input type="radio" name="learning3" value="3"></td>
                            <td class="rating-cell"><input type="radio" name="learning3" value="4"></td>
                            <td class="rating-cell"><input type="radio" name="learning3" value="NA"></td>
                        </tr>
                        <tr>
                            <td>4. The learning/s gained allowed me to develop more specific competencies related to my field.</td>
                            <td class="rating-cell"><input type="radio" name="learning4" value="1"></td>
                            <td class="rating-cell"><input type="radio" name="learning4" value="2"></td>
                            <td class="rating-cell"><input type="radio" name="learning4" value="3"></td>
                            <td class="rating-cell"><input type="radio" name="learning4" value="4"></td>
                            <td class="rating-cell"><input type="radio" name="learning4" value="NA"></td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <th style="width: 60%;">C. Work Performance (to be determined within one performance period)</th>
                            <th style="width: 4%; text-align: center;">1</th>
                            <th style="width: 4%; text-align: center;">2</th>
                            <th style="width: 4%; text-align: center;">3</th>
                            <th style="width: 4%; text-align: center;">4</th>
                            <th style="width: 4%; text-align: center;">NA</th>
                        </tr>
                        <tr>
                            <td>1. The quality of my work improved as a result participation in this course.</td>
                            <td class="rating-cell"><input type="radio" name="performance1" value="1" required></td>
                            <td class="rating-cell"><input type="radio" name="performance1" value="2"></td>
                            <td class="rating-cell"><input type="radio" name="performance1" value="3"></td>
                            <td class="rating-cell"><input type="radio" name="performance1" value="4"></td>
                            <td class="rating-cell"><input type="radio" name="performance1" value="NA"></td>
                        </tr>
                        <tr>
                            <td>2. My competency level increased as a result of participation in this course.</td>
                            <td class="rating-cell"><input type="radio" name="performance2" value="1" required></td>
                            <td class="rating-cell"><input type="radio" name="performance2" value="2"></td>
                            <td class="rating-cell"><input type="radio" name="performance2" value="3"></td>
                            <td class="rating-cell"><input type="radio" name="performance2" value="4"></td>
                            <td class="rating-cell"><input type="radio" name="performance1" value="NA"></td>
                        </tr>
                        <tr>
                            <td>3. My overall performance increased/improved as a result of participation in this course.</td>
                            <td class="rating-cell"><input type="radio" name="performance3" value="1" required></td>
                            <td class="rating-cell"><input type="radio" name="performance3" value="2"></td>
                            <td class="rating-cell"><input type="radio" name="performance3" value="3"></td>
                            <td class="rating-cell"><input type="radio" name="performance3" value="4"></td>
                            <td class="rating-cell"><input type="radio" name="performance1" value="NA"></td>
                        </tr>
                    </table>

                    <p><strong>To support your rating on application of learing and work performance, give specific instance and evidence on
                            how learning/s gained was applied at work and hhow work performance was improved. If the learning/s gained cannot
                            be applied to actual work, kindly specify the reasons.
                        </strong></p>
                    <textarea name="changes" placeholder="Describe any changes..." required></textarea>

                    <table>
                        <tr>
                            <th style="width: 60%;">D. Learner's Proficiency Level</th>
                            <th style="width: 5%; text-align: center;">1</th>
                            <th style="width: 5%; text-align: center;">2</th>
                            <th style="width: 5%; text-align: center;">3</th>
                            <th style="width: 5%; text-align: center;">4</th>
                        </tr>
                        <tr>
                            <td>In a scale 4-1 (4 being the highest ), please tick the circle which best describes your proficiency after your participation in this course.</td>
                            <td class="rating-cell"><input type="radio" name="proficiency" value="1" required></td>
                            <td class="rating-cell"><input type="radio" name="proficiency" value="2"></td>
                            <td class="rating-cell"><input type="radio" name="proficiency" value="3"></td>
                            <td class="rating-cell"><input type="radio" name="proficiency" value="4"></td>
                        </tr>
                    </table>

                    <p><strong>E. Comments/recommendation</strong> (If any, to increase the impact of the training.)</p>
                    <textarea name="comments" placeholder="Your comments or suggestions..." required></textarea>

                    <div class="form-group">
                        <label for="workPerformanceChanges">Please describe any changes in your work performance/output as a result of the training:</label>
                        <textarea id="workPerformanceChanges" name="workPerformanceChanges" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Do you intend to initiate participation in similar training programs in the future?</label><br>
                        <input type="radio" id="initiateYes" name="initiateParticipation" value="Yes" required>
                        <label for="initiateYes">Yes</label><br>
                        <input type="radio" id="initiateNo" name="initiateParticipation" value="No">
                        <label for="initiateNo">No</label>
                    </div>

                    <div class="form-group">
                        <label for="trainingSuggestions">Any suggestions for future training programs:</label>
                        <textarea id="trainingSuggestions" name="trainingSuggestions" required></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary" {{ $evaluation && $evaluation->participant_post_evaluation ? 'disabled' : '' }}>
                            {{ $evaluation && $evaluation->participant_post_evaluation ? 'Already Submitted' : 'Submit Evaluation' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const evaluationForm = document.querySelector('.evaluation-form');

            evaluationForm.addEventListener('submit', async function(event) {
                event.preventDefault(); // Prevent default form submission

                const formData = new FormData(evaluationForm);
                const trainingId = formData.get('training_id');
                const formAction = `{{ route('user.training.submit.participant.evaluation', ['id' => 'TRAINING_ID_PLACEHOLDER']) }}`.replace('TRAINING_ID_PLACEHOLDER', trainingId);

                try {
                    const response = await fetch(formAction, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert(result.message);
                        // Optionally, redirect or update UI
                        window.location.href = '{{ route('user.training.effectiveness') }}'; // Redirect back to training effectiveness page
                    } else {
                        alert('Error: ' + result.message + (result.errors ? '\n' + JSON.stringify(result.errors, null, 2) : ''));
                    }
                } catch (error) {
                    console.error('Error during form submission:', error);
                    alert('An unexpected error occurred. Please try again.');
                }
            });
        });
    </script>
</body>

</html>
