<!DOCTYPE html>
<html>
<head>
    <title>Training Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .category-header {
            background-color: #d3d3d3;
            font-weight: bold;
        }
        .export-date {
            text-align: right;
            font-size: 12px;
            color: #666;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Training Report</h2>

    <div class="export-date">
        <strong>Date:</strong> {{ \Carbon\Carbon::now()->format('F j, Y \a\t g:i A') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Training Program</th>
                <th>Competency</th>
                <th>CY 2025 Participants</th>
                <th>CY 2026 Participants</th>
                <th>CY 2027 Participants</th>
                <th>Provider</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trainings as $coreCompetency => $categoryTrainings)
                <tr>
                    <td colspan="6" class="category-header">{{ $coreCompetency }}</td>
                </tr>
                @foreach($categoryTrainings as $training)
                    <tr>
                        <td>{{ $training->title }}</td>
                        <td>{{ $training->competency->name }}</td>
                        <td>
                            @foreach($training->participants_2025 ?? [] as $participant)
                                {{ $loop->iteration }}. {{ $participant->last_name }}, {{ $participant->first_name }} {{ $participant->mid_init }}.<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($training->participants_2026 ?? [] as $participant)
                                {{ $loop->iteration }}. {{ $participant->last_name }}, {{ $participant->first_name }} {{ $participant->mid_init }}.<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($training->participants_2027 ?? [] as $participant)
                                {{ $loop->iteration }}. {{ $participant->last_name }}, {{ $participant->first_name }} {{ $participant->mid_init }}.<br>
                            @endforeach
                        </td>
                        <td>{{ $training->provider }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html> 