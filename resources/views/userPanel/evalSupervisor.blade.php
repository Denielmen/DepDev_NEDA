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
      width: 70px;
      margin-bottom: 1.5rem;
    }

    .back-button {
      margin-bottom: 20px;
    }

    .btn-back-minimal {
      text-decoration: none;
      background-color: white;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 0.9rem;
      color: #003366;
      display: inline-flex;
      align-items: center;
      transition: background-color 0.2s ease;
    }

    .btn-back-minimal:hover {
      background-color: rgba(0, 32, 96, 0.05);
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
      font-weight: bold;
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
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <a class="navbar-brand" href="#">
        <img src="/images/neda-logo.png" alt="NEDA Logo">
        DEPDEV Learning and Development Database System Region VII
      </a>
      <div class="d-flex align-items-center">
        <i class="bi bi-bell-fill me-3"></i>
        <div class="dropdown">
          <div class="user-menu" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle"></i> User
            <i class="bi bi-chevron-down ms-1"></i>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Sidebar + Main Content -->
  <div class="d-flex">

    <!-- Sidebar -->
    <div class="sidebar">
      <a href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i>Home</a>
      <a href="{{ route('training.profile') }}"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
      <a href="{{ route('tracking') }}"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
      <a href="{{ route('training.effectivenesss') }}" class="active"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">

      <!-- Back Button -->
      <div class="back-button">
        <a href="{{ route('training.effectivenesss') }}" class="btn-back-minimal">
          <i class="bi bi-arrow-left me-2"></i> Back
        </a>
      </div>

      <div class="evaluation-container">
        <div class="evaluation-header">
          <img src="{{ asset('images/neda-logo.png') }}" alt="NEDA Logo" class="neda-logo">
          <h4>Republic of the Philippines</h4>
          <h5>NATIONAL ECONOMIC AND DEVELOPMENT AUTHORITY</h5>
          <h6>EVALUATION OF TRAINING EFFECTIVENESS</h6>
          <p>(For Supervisor)</p>
        </div>

        <form method="POST" action="{{ route('training.effectivenesss') }}" class="evaluation-form">
          @csrf
          <label for="courseTitle">Course Title:</label>
          <select id="courseTitle" name="courseTitle" required style="margin-bottom: 20px;">
            <option value="">Select Course</option>
            <option value="course1">Course 1</option>
            <option value="course2">Course 2</option>
          </select>

          <div class="instruction-container">
            <p><strong>Please tick the circle which describes your evaluation of the program. You have 4 choices to choose from:</strong> (4) Very Satisfied, (3) Satisfied, <br>(2) Dissatisfied, (1) Very Dissatisfied.</p>
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
              <td>How satisfied are you in the learner’s achievement of his/her learning goals/objectives as specified in his/her learner’s profile.</td>
              <td class="rating-cell"><input type="radio" name="goals" value="1" required></td>
              <td class="rating-cell"><input type="radio" name="goals" value="2"></td>
              <td class="rating-cell"><input type="radio" name="goals" value="3"></td>
              <td class="rating-cell"><input type="radio" name="goals" value="4"></td>
            </tr>
          </table>

          <div class="instruction-container">
            <p><strong>Please tick the circle which best describes your evaluation of the program. You have 5 choices to choose from: </strong>(4) Strongly agree, (3) Agree, <br>(2) Disagree, (1) Strongly Disagree, (Na) Not Applicable</p>
          </div>
          <table>
            <tr>
              <th style="width: 60%;">B. Participants’ Work Performance  (To be determined within one 
              performance rating period) </th>
              <th style="width: 4%; text-align: center;">1</th>
              <th style="width: 4%; text-align: center;">2</th>
              <th style="width: 4%; text-align: center;">3</th>
              <th style="width: 4%; text-align: center;">4</th>
              <th style="width: 4%; text-align: center;">NA</th>
            </tr>
            <tr>
              <td>1. The employee applied the learning’s gained from this course.</td>
              <td class="rating-cell"><input type="radio" name="learning1" value="1" required></td>
              <td class="rating-cell"><input type="radio" name="learning1" value="2"></td>
              <td class="rating-cell"><input type="radio" name="learning1" value="3"></td>
              <td class="rating-cell"><input type="radio" name="learning1" value="4"></td>
              <td class="rating-cell"><input type="radio" name="learning1" value="5"></td>
            </tr>
            <tr>
              <td>2. The employee’s quality of work improved. </td>
              <td class="rating-cell"><input type="radio" name="learning2" value="1" required></td>
              <td class="rating-cell"><input type="radio" name="learning2" value="2"></td>
              <td class="rating-cell"><input type="radio" name="learning2" value="3"></td>
              <td class="rating-cell"><input type="radio" name="learning2" value="4"></td>
              <td class="rating-cell"><input type="radio" name="learning1" value="5"></td>
            </tr>
            <tr>
              <td>3. The proficiency level of the employee on this course increased.</td>
              <td class="rating-cell"><input type="radio" name="learning3" value="1" required></td>
              <td class="rating-cell"><input type="radio" name="learning3" value="2"></td>
              <td class="rating-cell"><input type="radio" name="learning3" value="3"></td>
              <td class="rating-cell"><input type="radio" name="learning3" value="4"></td>
              <td class="rating-cell"><input type="radio" name="learning1" value="5"></td>
            </tr>
            <tr>
              <td>4. The employee’s overall work performance increase/improved.</td>
              <td class="rating-cell"><input type="radio" name="learning3" value="1" required></td>
              <td class="rating-cell"><input type="radio" name="learning3" value="2"></td>
              <td class="rating-cell"><input type="radio" name="learning3" value="3"></td>
              <td class="rating-cell"><input type="radio" name="learning3" value="4"></td>
              <td class="rating-cell"><input type="radio" name="learning1" value="5"></td>
            </tr>
          </table>

          <div class="form-group">
            <label for="workPerformanceChanges"><strong>To support your your training, please describe changes in work performance as a result of 
attendance to this training. if employee’s work performance did not change, please cite possible 
reasons and what support is needed in order for the employee’s to apply acquired knowledge and skills.</strong></label>
            <textarea name="workPerformanceChanges" rows="4" placeholder="Write down the changes from your performance..."></textarea>
          </div>

          <table>
            <tr>
              <th style="width: 60%;">C.  Learner’s Proficiency Level</th>
              <th style="width: 5%; text-align: center;">1</th>
              <th style="width: 5%; text-align: center;">2</th>
              <th style="width: 5%; text-align: center;">3</th>
              <th style="width: 5%; text-align: center;">4</th>
            </tr>
            <tr>
              <td>In a scale 1-4 (4 is being the highest ), please tick the circle which describes the proficiency level of your subordinate after participation in this course.</td>
              <td class="rating-cell"><input type="radio" name="performance1" value="1" required></td>
              <td class="rating-cell"><input type="radio" name="performance1" value="2"></td>
              <td class="rating-cell"><input type="radio" name="performance1" value="3"></td>
              <td class="rating-cell"><input type="radio" name="performance1" value="4"></td>
            </tr>

          </table>

      
          <p><strong>To support your your training, please describe changes in work performance as a result of
              attendance to this training. if employee’s work performance did not change, please cite possible
              reasons and what support is needed in order for the employee’s to apply acquired knowledge and skills.</strong></p>
          <textarea name="changes" rows="4" placeholder="Describe any changes..." required></textarea>



          <div class="section-title">D. Comments/Recommendation (if any, to increase the impact of the training.)</div>
          <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
            <strong>I will initiate the participation of other staffs to this course.</strong>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="initiateParticipation" id="yesParticipation" value="Yes">
              <label class="form-check-label" for="yesParticipation">Yes</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="initiateParticipation" id="noParticipation" value="No">
              <label class="form-check-label" for="noParticipation">No</label>
            </div>
          </div>

          <div class="section-title">E. Comments/Suggestion on the training  program.</div>
          <textarea name="trainingSuggestions" rows="4" placeholder="Input here your comments......"></textarea>

          <div class="submit-button">
            <button type="submit">Submit</button>
          </div>

        </form>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>