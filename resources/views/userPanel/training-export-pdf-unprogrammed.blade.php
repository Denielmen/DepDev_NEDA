<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>lnd.dro7.depdev</title>
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
        <h1>My Completed Trainings</h1>
        <p>Generated on: {{ date('F d, Y') }}</p>
        <p>Participant Name: {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
    </div>

    @if($groupedTrainings->isEmpty())
        <div class="no-trainings">
            No completed trainings found.
        </div>
    @else
        @foreach($groupedTrainings as $coreCompetency => $trainings)
            <div class="section">
                <div class="section-title">{{ $coreCompetency }}</div>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 25%;">Training Title/Subject</th>
                            <th style="width: 15%;">Type</th>
                            <th style="width: 20%;">Inclusive Dates of Attendance</th>
                            <th style="width: 10%;">Number of Hours</th>
                            <th style="width: 20%;">Provider/Organizer</th>
                            <th style="width: 10%;">User Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainings as $training)
                            <tr>
                                <td>{{ $training->title }}</td>
                                <td>{{ $training->core_competency }}</td>
                                <td>
                                    @if($training->implementation_date_from && $training->implementation_date_to)
                                        {{ $training->implementation_date_from->format('M d, Y') }} - {{ $training->implementation_date_to->format('M d, Y') }}
                                    @elseif($training->implementation_date_from)
                                        {{ $training->implementation_date_from->format('M d, Y') }} - N/A
                                    @elseif($training->implementation_date_to)
                                        N/A - {{ $training->implementation_date_to->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $training->no_of_hours ?? 'N/A' }}</td>
                                <td>{{ $training->provider ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $currentUser = Auth::user();
                                        $userRole = 'Resource Speaker';
                                        if ($currentUser) {
                                            $participant = $training->participants->where('id', $currentUser->id)->first();
                                            if ($participant && isset($participant->pivot->participation_type_id)) {
                                                $participationType = \App\Models\ParticipationType::find($participant->pivot->participation_type_id);
                                                $userRole = $participationType ? $participationType->name : 'Resource Speaker';
                                            }
                                        }
                                    @endphp
                                    {{ $userRole }}
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
