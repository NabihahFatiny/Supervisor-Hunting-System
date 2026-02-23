<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Requests</title>
    <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .table {
    width: 100%;
    margin-bottom: 1.5rem;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.table th {
    font-weight: 600;
    color: rgb(9, 9, 9);
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
                <a href="{{ route('lecturer.mainpage') }}" class="logo-text">Supervisor Hunting</a>
            </div>

            <div class="nav-links">
                <a href="{{ route('lecturer.mainpage') }}" class="nav-item {{ request()->routeIs('lecturer.mainpage') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('posts.topic') }}" class="nav-item {{ request()->routeIs('posts.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Topics</span>
                </a>
                <a href="{{ route('applications.index') }}" class="nav-item {{ request()->routeIs('applications.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Applications</span>
                </a>
                <a href="{{ route('lecturer.timeframe') }}" class="nav-item {{ request()->routeIs('lecturer.timeframe') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Timeframe</span>
                </a>
                <a href="{{ route('lecturer.schedule') }}" class="nav-item {{ request()->routeIs('lecturer.schedule') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Schedule</span>
                </a>
                <a href="{{ route('lecturer.change-password.view') }}" class="nav-item {{ request()->routeIs('lecturer.change-password.view') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Setting</span>
                </a>
                <a href="/SHS" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header text-center bg-primary text-white">
                <h2>Appointment Requests</h2>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($appointments->isEmpty())
                    <p>No appointments found.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Lecturer Name</th>
                                <th>Student Name</th>
                                <th>Topic</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->lecturer->lecturerName }}</td>
                                    <td>{{ $appointment->student->studName }}</td>
                                    <td>{{ $appointment->topic }}</td>
                                    <td>{{ $appointment->day }}</td>
                                    <td>{{ $appointment->time }}</td>
                                    <td>{{ $appointment->location }}</td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->status == 'pending' ? 'warning' : ($appointment->status == 'accepted' ? 'success' : 'danger') }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($appointment->status == 'pending')
                                            <div class="d-flex gap-2">
                                                <form action="{{ route('lecturer.updateAppointmentStatus', $appointment->appointment_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="accepted">
                                                    <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                                </form>

                                                <form action="{{ route('lecturer.updateAppointmentStatus', $appointment->appointment_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
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
