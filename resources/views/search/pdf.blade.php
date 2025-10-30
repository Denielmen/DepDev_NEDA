<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            color: #003366;
            border-bottom: 2px solid #003366;
            padding-bottom: 10px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            background-color: #003366;
            color: white;
            padding: 5px 10px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .no-results {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <h2>Search Results</h2>

    @if($results->isEmpty())
        <div class="no-results">
            No results found.
        </div>
    @else
        @if($results->where('search_type', 'training')->isNotEmpty())
            <div class="section">
                <div class="section-title">Training Found</div>
                <table>
                    <thead>
                        <tr>
                            <th>Training Title</th>
                            <th>Competency</th>
                            <th>Participants</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results->where('search_type', 'training') as $result)
                            <tr>
                                <td>{{ $result->title }}</td>
                                <td>{{ $result->competency->name ?? 'N/A' }}</td>
                                <td>
                                    @if($result->participants)
                                        @foreach($result->participants as $participant)
                                            {{ $loop->iteration }}. {{ $participant['name'] }}
                                            @if(isset($participant['period']))
                                                ({{ $participant['period'] }})
                                            @endif
                                            <br>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if($results->where('search_type', 'user')->isNotEmpty())
            <div class="section">
                <div class="section-title">Users Found</div>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Division</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results->where('search_type', 'user') as $result)
                            <tr>
                                <td>{{ $result->last_name . ', ' . $result->first_name . ' ' . $result->mid_init . '.' }}</td>
                                <td>{{ $result->position ?? 'N/A' }}</td>
                                <td>{{ $result->division ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if($results->where('search_type', 'training_material')->isNotEmpty())
            <div class="section">
                <div class="section-title">Training Materials Found</div>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Competency</th>
                            <th>Uploader</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results->where('search_type', 'training_material') as $result)
                            <tr>
                                <td>{{ $result->title ?? 'N/A' }}</td>
                                <td>{{ $result->competency->name ?? 'N/A' }}</td>
                                <td>
                                    @if($result->user)
                                        {{ $result->user->last_name . ', ' . $result->user->first_name . ' ' . $result->user->mid_init . '.' }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif
</body>
</html> 