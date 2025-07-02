<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Training Programs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background-color: #f8f9fa;
            padding: 8px 12px;
            border-left: 4px solid #007bff;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 11px;
        }
        td {
            font-size: 10px;
        }
        .no-trainings {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>My Training Programs</h1>
        <p>Generated on: {{ date('F d, Y') }}</p>
        <p>Participant Name: {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
    </div>

    @if($groupedTrainings->isEmpty())
        <div class="no-trainings">
            No training programs found.
        </div>
    @else
        @foreach($groupedTrainings as $coreCompetency => $trainings)
            <div class="section">
                <div class="section-title">{{ $coreCompetency }}</div>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 30%;">Training Program</th>
                            <th style="width: 20%;">Competency</th>
                            <th style="width: 25%;">Period of Implementation</th>
                            <th style="width: 15%;">Provider</th>
                            <th style="width: 10%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainings as $training)
                            <tr>
                                <td>{{ $training->title }}</td>
                                <td>{{ $training->competency->name ?? 'N/A' }}</td>
                                <td>
                                    @if($training->implementation_date_from && $training->implementation_date_to)
                                        {{ $training->implementation_date_from->format('M d, Y') }} - {{ $training->implementation_date_to->format('M d, Y') }}
                                    @elseif($training->period_from && $training->period_to)
                                        {{ $training->period_from }} - {{ $training->period_to }}
                                    @else
                                        Not specified
                                    @endif
                                </td>
                                <td>{{ $training->provider ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        // Get current user's evaluation for this training
                                        $userEvaluation = $training->evaluations->where('user_id', Auth::id())->first();

                                        // Check if current user has completed pre-evaluation
                                        $hasPreEvaluation = $userEvaluation && $userEvaluation->participant_pre_rating !== null;

                                        // Check if current user has completed tracking (has implementation dates)
                                        $hasTracking = $training->implementation_date_from !== null;

                                        // Determine status for current user - same logic as trainingProfileProgram view
                                        if ($hasPreEvaluation && $hasTracking) {
                                            $userStatus = 'Implemented';
                                        } else {
                                            $userStatus = 'Not yet Implemented';
                                        }
                                    @endphp
                                    {{ $userStatus }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @endif

    <div class="footer">
        <p>This document was generated automatically from the Training Management System.</p>
    </div>
</body>
</html>
