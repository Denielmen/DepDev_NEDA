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
      background-color: #ffffff;
      padding: 0.5rem 1rem;
      box-shadow: 1px 3px 3px 0px #737373;
      z-index: 1000;
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
      background-color: #003366;
      min-height: calc(100vh - 56px);
      width: 270px;
      padding-top: 20px;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 12px 20px;
      font-size: 0.9rem;
    }

    .sidebar a:hover {
      background-color: #004080;
    }

    .main-content {
      flex-grow: 1;
      padding: 20px;
      margin-left: 0;
      margin-right: 0;
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

    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
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

    textarea, select, input[type="text"] {
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
    <a href="#"><i class="bi bi-house-door me-2"></i>Home</a>
    <a href="#"><i class="bi bi-person-vcard me-2"></i>Training Profile</a>
    <a href="#"><i class="bi bi-clock-history me-2"></i>Training Tracking & History</a>
    <a href="#"><i class="bi bi-graph-up me-2"></i>Training Effectiveness</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">

    <!-- Back Button -->
    <div class="back-button">
      <a href="{{ route('effectivenessParticipant') }}" class="btn-back-minimal">
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

      <form method="POST" action="{{ route('effectivenessSupervisor') }}" class="evaluation-form">
        @csrf

        <div class="section-title">A. Learning Goals/Objectives</div>
        <table>
          <tr>
            <td class="text-left">How satisfied are you in the learner’s achievement of his/her learning goals/objectives as specified in his/her learner’s profile.</td>
            <th>Ratings</th>
          </tr>
          <tr>
            <td></td>
            <td>
              <div class="rating-options">
                <label>1</label><input type="radio" name="learningGoals" value="1">
                <label>2</label><input type="radio" name="learningGoals" value="2">
                <label>3</label><input type="radio" name="learningGoals" value="3">
                <label>4</label><input type="radio" name="learningGoals" value="4">
              </div>
            </td>
          </tr>
        </table>

        <div><strong>Please tick the circle which best describes your evaluation of the program.</strong></div>

        <div class="section-title">B. Participants’ Work Performance</div>
        <table>
          <tr>
            <td class="text-left"></td>
            <th>Ratings</th>
          </tr>
          <tr>
            <td class="text-left">1. The employee applied the learnings gained from this course.</td>
            <td>
              <div class="rating-options">
                <label>1</label><input type="radio" name="performance1" value="1">
                <label>2</label><input type="radio" name="performance1" value="2">
                <label>3</label><input type="radio" name="performance1" value="3">
                <label>4</label><input type="radio" name="performance1" value="4">
                <label>Na</label><input type="radio" name="performance1" value="Na">
              </div>
            </td>
          </tr>
          <tr>
            <td class="text-left">2. The employee’s quality of work improved.</td>
            <td>
              <div class="rating-options">
                <label>1</label><input type="radio" name="performance2" value="1">
                <label>2</label><input type="radio" name="performance2" value="2">
                <label>3</label><input type="radio" name="performance2" value="3">
                <label>4</label><input type="radio" name="performance2" value="4">
                <label>Na</label><input type="radio" name="performance2" value="Na">
              </div>
            </td>
          </tr>
          <tr>
            <td class="text-left">3. The proficiency level of the employee on this course increased.</td>
            <td>
              <div class="rating-options">
                <label>1</label><input type="radio" name="performance3" value="1">
                <label>2</label><input type="radio" name="performance3" value="2">
                <label>3</label><input type="radio" name="performance3" value="3">
                <label>4</label><input type="radio" name="performance3" value="4">
                <label>Na</label><input type="radio" name="performance3" value="Na">
              </div>
            </td>
          </tr>
          <tr>
            <td class="text-left">4. The employee’s overall work performance improved.</td>
            <td>
              <div class="rating-options">
                <label>1</label><input type="radio" name="performance4" value="1">
                <label>2</label><input type="radio" name="performance4" value="2">
                <label>3</label><input type="radio" name="performance4" value="3">
                <label>4</label><input type="radio" name="performance4" value="4">
                <label>Na</label><input type="radio" name="performance4" value="Na">
              </div>
            </td>
          </tr>
        </table>

        <div class="form-group">
          <label for="workPerformanceChanges"><strong>Describe changes in work performance:</strong></label>
          <textarea name="workPerformanceChanges" rows="5"></textarea>
        </div>

        <div class="section-title">C. Learner’s Proficiency Level</div>
        <table>
          <tr>
            <td class="text-left">Proficiency level of subordinate after this course:</td>
            <th>Ratings</th>
          </tr>
          <tr>
            <td></td>
            <td>
              <div class="rating-options">
                <label>1</label><input type="radio" name="proficiencyLevel" value="1">
                <label>2</label><input type="radio" name="proficiencyLevel" value="2">
                <label>3</label><input type="radio" name="proficiencyLevel" value="3">
                <label>4</label><input type="radio" name="proficiencyLevel" value="4">
              </div>
            </td>
          </tr>
        </table>

        <div class="section-title">D. Comments/Recommendation</div>
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
          <strong>I will initiate the participation of other staff to this course.</strong>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="initiateParticipation" id="yesParticipation" value="Yes">
            <label class="form-check-label" for="yesParticipation">Yes</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="initiateParticipation" id="noParticipation" value="No">
            <label class="form-check-label" for="noParticipation">No</label>
          </div>
        </div>

        <div class="section-title">E. Comments/Suggestions on the Training Program</div>
        <textarea name="trainingSuggestions" rows="4"></textarea>

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
