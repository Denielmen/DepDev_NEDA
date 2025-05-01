<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Training Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #fff;
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
        .main-content {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 32px 32px 24px 32px;
        }
        .main-content h2 {
            color: #003366;
            font-weight: 600;
            margin-bottom: 24px;
            text-align: center;
        }
        .list-group-item {
            border: none;
            border-bottom: 1px solid #e9ecef;
            font-size: 1rem;
            padding: 12px 0;
        }
        .list-group-item:last-child {
            border-bottom: none;
        }
        .label {
            color: #003366;
            font-weight: 500;
            min-width: 180px;
            display: inline-block;
        }
        .btn-back {
            background-color: #003366;
            color: #fff;
            border: none;
            margin-top: 20px;
            padding: 8px 32px;
            border-radius: 4px;
            font-weight: 500;
            text-decoration: none;
        }
        .btn-back:hover {
            background-color: #004080;
            color: #fff;
            text-decoration: none;
        }
        .btn-back:active, .btn-back:focus, .btn-back:visited {
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/neda-logo.png" alt="NEDA Logo">
                DEPDEV Learning and Development Database System Region VII
            </a>
        </div>
    </nav>
    <div class="main-content">
        <h2>Training Details</h2>
        <ul class="list-group mb-3">
            <li class="list-group-item"><span class="label">Title/Area:</span> {{ $training->title ?? '' }}</li>
            <li class="list-group-item"><span class="label">Three-Year Period:</span>
                From: {{ $training->period_from ?? '' }} To: {{ $training->period_to ?? '' }}
            </li>
            <li class="list-group-item"><span class="label">Competency:</span> {{ $training->competency ?? '' }}</li>
            <li class="list-group-item"><span class="label">Year of Implementation:</span> {{ $training->implementation_date ? $training->implementation_date->format('m/d/Y') : '' }}</li>
            <li class="list-group-item"><span class="label">Budget (per hour):</span> {{ $training->budget ?? '' }}</li>
            <li class="list-group-item"><span class="label">No. of Hours:</span> {{ $training->hours ?? '' }}</li>
            <li class="list-group-item"><span class="label">Superior:</span> {{ $training->superior ?? '' }}</li>
            <li class="list-group-item"><span class="label">Learning Service Provider:</span> {{ $training->provider ?? '' }}</li>
            <li class="list-group-item"><span class="label">Development Target:</span> {{ $training->development_target ?? '' }}</li>
            <li class="list-group-item"><span class="label">Performance Goal this Support:</span> {{ $training->performance_goal ?? '' }}</li>
            <li class="list-group-item"><span class="label">Objective:</span> {{ $training->objective ?? '' }}</li>
            {{-- Loop for any extra fields --}}
            @foreach($extraFields ?? [] as $label => $value)
                <li class="list-group-item"><span class="label">{{ $label }}:</span> {{ $value }}</li>
            @endforeach
        </ul>
        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('training.profile.program') }}" class="btn btn-back">Back</a>
            <a href="{{ route('training.effectivenesss') }}" class="btn btn-back">Pre-Evaluation</a>
        </div>
    </div>
</body>
</html> 