<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Training Effectiveness Evaluation - Participant</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: rgb(187, 219, 252);
      overflow-x: hidden;
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
      z-index: 999;/
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

    .evaluation-container {
      background: white;
      border-radius: 8px;
      padding: 2.5rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      max-width: 100%;
      margin-bottom: 20px;
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
            
        }
        .btn-back:hover {
            background-color: #004080;
            color: #fff;
            transform: translateY(-1px);
        }


    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }

    th,
    td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: left;
    }

    .text-left {
      text-align: left;
    }

    .rating-options {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
    }

    .form-group,
    .form-check {
      margin-top: 10px;
    }

    .form-check {
      display: flex;
      align-items: center;
    }

    .form-check input[type="radio"] {
      margin-right: 8px;
    }

    .rating-cell {
      text-align: center;
    }

    textarea,
    select,
    input[type="text"] {
      width: 100%;
      padding: 8px;
      font-size: 14px;
      margin-top: 5px;
      border: 1px solid #ddd;
      border-radius: 4px;
      resize: vertical;
    }

    .section-title {
      margin-top: 20px;
    }

    .submit-button {
      display: flex;
      justify-content: center;
      margin-top: 30px;
    }

    button[type="submit"] {
      background: #002060;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      font-size: 1rem;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background: #001540;
    }

    @media (max-width: 768px) {
      .d-flex {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        min-height: auto;
        padding: 10px;
      }

      .main-content {
        margin: 0;
        padding: 10px;
      }

      .evaluation-container {
        padding: 1rem;
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
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid d-flex justify-content-between align-items-center">
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

  <!-- Sidebar + Main Content -->
  <div class="d-flex">

    <!-- Sidebar -->
    <div class="sidebar">
            <a href="{{ route('admin.home') }}" ><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="{{ route('admin.training-plan') }}"><i class="bi bi-calendar-check me-2"></i>Training Plan</a>
            <a href="{{ route('admin.participants') }}" class="active"><i class="bi bi-people me-2"></i>Employee's Profile</a>
            <a href="{{ route('admin.reports') }}"><i class="bi bi-file-earmark-text me-2"></i>Reports</a>
            <a href="{{ route('admin.search.index') }}"><i class="bi bi-search me-2"></i>Search</a>
        </div>

    <!-- Main Content -->
    <div class="main-content">
      <!-- Back Button -->
      <div class="top-actions">
                <a href="{{ route('admin.viewUserInfo', ['id' => $training->id]) }}" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i>
                    Back
                </a>
            </div>

      <div class="evaluation-container">
        <div class="evaluation-header">
          <img src="{{ asset('images/DEPDev_logo_text_center.png') }}" alt="NEDA Logo" class="neda-logo">

          <h6>EVALUATION OF TRAINING EFFECTIVENESS</h6>
          <p>(For Supervisor/Manager of the Participant - Online)</p>
        </div>

        <form method="POST" action="{{ route('admin.training.post-evaluation.submit', ['id' => $training->id]) }}" class="evaluation-form">
          @csrf
          <input type="hidden" name="type" value="supervisor_post">

          @if($training->supervisor_post_evaluation)
          <div class="alert alert-info">
            <strong>Note:</strong> You have already submitted a post-evaluation for this training. You can view your previous submission below.
          </div>
          @endif

          <div class="instruction-container">
            <p><strong>Please tick the circle which best describes your evaluation of the program. You have 4 choices to choose from:</strong>
            <br> (4) Very Satisfied, (3) Satisfied, (2) Dissatisfied, (1) Very Dissatisfied.</p> 
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
              <td>How satisfied are you in the learner's achievement of his/her learning goals/objectives as specified in his/her learner's profile.</td>
              <td class="rating-cell"><input type="radio" name="goals" value="1" required {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['goals'] == 1 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="goals" value="2" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['goals'] == 2 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="goals" value="3" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['goals'] == 3 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="goals" value="4" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['goals'] == 4 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
            </tr>
          </table>

          <div class="instruction-container">
            <p><strong>Please tick the circle which best describes your evaluation of the program. You have 5 choices to choose from: </strong>(4) Strongly agree, (3) Agree, <br>(2) Disagree, (1) Strongly Disagree, (NA) Not Applicable</p>
          </div>
          <table>
            <tr>
              <th style="width: 60%;">B. Participants' Work Performance (to be determined within one
                performance rating period) </th>
              <th style="width: 4%; text-align: center;">1</th>
              <th style="width: 4%; text-align: center;">2</th>
              <th style="width: 4%; text-align: center;">3</th>
              <th style="width: 4%; text-align: center;">4</th>
              <th style="width: 4%; text-align: center;">NA</th>
            </tr>
            <tr>
              <td>1. The employee applied the learning/s gained from this course.</td>
              <td class="rating-cell"><input type="radio" name="learning1" value="1" required {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning1'] == 1 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning1" value="2" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning1'] == 2 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning1" value="3" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning1'] == 3 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning1" value="4" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning1'] == 4 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning1" value="5" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning1'] == 5 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
            </tr>
            <tr>
              <td>2. The employee's quality of work improved. </td>
              <td class="rating-cell"><input type="radio" name="learning2" value="1" required {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning2'] == 1 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning2" value="2" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning2'] == 2 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning2" value="3" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning2'] == 3 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning2" value="4" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning2'] == 4 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning2" value="5" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning2'] == 5 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
            </tr>
            <tr>
              <td>3. The proficiency level of the employee on this course increased.</td>
              <td class="rating-cell"><input type="radio" name="learning3" value="1" required {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning3'] == 1 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning3" value="2" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning3'] == 2 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning3" value="3" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning3'] == 3 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning3" value="4" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning3'] == 4 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning3" value="5" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning3'] == 5 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
            </tr>
            <tr>
              <td>4. The employee's overall work performance increased/improved.</td>
              <td class="rating-cell"><input type="radio" name="learning4" value="1" required {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning4'] == 1 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning4" value="2" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning4'] == 2 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning4" value="3" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning4'] == 3 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning4" value="4" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning4'] == 4 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="learning4" value="5" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['learning4'] == 5 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
            </tr>
          </table>

          <div class="form-group">
            <label for="workPerformanceChanges"><strong>To support your raating, please describe changes in work performance as a result of
                attendance to this training. If employee's work performance did not change, please cite possible
                reasons and what support is needed in order for the employees to apply acquired knowledge and skills.</strong></label>
            <textarea name="workPerformanceChanges" rows="4" placeholder="Write down the changes from your performance..." {{ $training->supervisor_post_evaluation ? 'readonly' : '' }}>{{ $training->supervisor_post_evaluation ? $training->supervisor_post_evaluation['workPerformanceChanges'] : '' }}</textarea>
          </div>

          <table>
            <tr>
              <th style="width: 60%;">C. Learner's Proficiency Level</th>
              <th style="width: 5%; text-align: center;">1</th>
              <th style="width: 5%; text-align: center;">2</th>
              <th style="width: 5%; text-align: center;">3</th>
              <th style="width: 5%; text-align: center;">4</th>
            </tr>
            <tr>
              <td>In a scale 4-1 (4 being the highest), please tick the circle which best describes the proficiency level of your subordinate after participation in this course.</td>
              <td class="rating-cell"><input type="radio" name="performance1" value="1" required {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['performance1'] == 1 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="performance1" value="2" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['performance1'] == 2 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="performance1" value="3" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['performance1'] == 3 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
              <td class="rating-cell"><input type="radio" name="performance1" value="4" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['performance1'] == 4 ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}></td>
            </tr>
          </table>

          <div class="section-title"><strong>D. Comments/Recommendation</strong> (if any, to increase the impact of the training.)</div>
          <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
            <strong>I will initiate the participation of other staffs to this course.</strong>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="initiateParticipation" id="yesParticipation" value="Yes" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['initiateParticipation'] == 'Yes' ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}>
              <label class="form-check-label" for="yesParticipation">Yes</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="initiateParticipation" id="noParticipation" value="No" {{ $training->supervisor_post_evaluation && $training->supervisor_post_evaluation['initiateParticipation'] == 'No' ? 'checked' : '' }} {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}>
              <label class="form-check-label" for="noParticipation">No</label>
            </div>
          </div>

          <div class="section-title"><strong>E. Comments/Suggestion on the training program.<strong></div>
          <textarea name="trainingSuggestions" rows="4" placeholder="Input here your comments......" {{ $training->supervisor_post_evaluation ? 'readonly' : '' }}>{{ $training->supervisor_post_evaluation ? $training->supervisor_post_evaluation['trainingSuggestions'] : '' }}</textarea>

          <div class="submit-button">
            <button type="submit" {{ $training->supervisor_post_evaluation ? 'disabled' : '' }}>Submit</button>
          </div>

        </form>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>