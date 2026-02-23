<!-- resources/views/student/viewStatus.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Status</title>
    <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
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
        <div class="card shadow">
            <div class="card-header text-center bg-primary text-white">
                <h2>Appointment Status</h2>
            </div>
            <div class="card-body">
                @if ($appointments->isEmpty())
                    <p>No appointments found or status not updated yet.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Lecturer Name</th>
                                <th>Topic</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Location</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->lecturer->lecturerName }}</td>
                                    <td>{{ $appointment->topic }}</td>
                                    <td>{{ $appointment->day }}</td>
                                    <td>{{ $appointment->time }}</td>
                                    <td>{{ $appointment->location }}</td>
                                    <td>{{ $appointment->status }}</td> <!-- Status updated by lecturer -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
