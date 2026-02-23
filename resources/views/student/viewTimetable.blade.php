<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Timetable</title>
    <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .table {
    width: 100%;
    margin-bottom: 1.5rem;
    background-color: white;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.table th {
    background-color: #2e3033;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.5px;
}

.table th,
.table td {
    padding: 1rem;
    border: 1px solid #c3c3c3;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">
                <img src="{{ asset('img/fk.png') }}" alt="FK Logo" class="logo-image">
                <a href="/homepage" class="logo-text">Supervisor Hunting</a>
            </div>

            <div class="nav-links">
                <a href="{{ route('lecturer.mainpage') }}" class="nav-item">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('posts.topic') }}" class="nav-item">
                    <i class="fas fa-book"></i>
                    <span>Topics</span>
                </a>
                <a href="{{ route('applications.index') }}" class="nav-item ">
                    <i class="fas fa-users"></i>
                    <span>Applications</span>
                </a>
                <a href="{{ route('student.timeframe') }}" class="nav-item active">
                    <i class="fas fa-users"></i>
                    <span>Timeframe</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center text-primary">View Timetable</h1>
        @foreach ($schedules as $lecturerName => $lecturerSchedules)
        <div class="mt-5">
            <h3 class="text-secondary lecturer-name">{{ $lecturerName }}</h3>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    @if($lecturerSchedules->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">No schedule available</td>
                        </tr>
                    @else
                        @foreach ($lecturerSchedules as $schedule)
                        <tr>
                            <td>{{ $schedule->subject }}</td>
                            <td>{{ $schedule->day }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->start_time)->format('h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->end_time)->format('h:i A') }}</td>
                            <td>{{ $schedule->location }}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        @endforeach

    </div>
</body>
</html>
