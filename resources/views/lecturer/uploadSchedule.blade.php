<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Schedule</title>
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
                <h2>Update Schedule</h2>
            </div>
            <div class="card-body">
                <!-- Lecturer Name -->
                <div class="mb-4">
                    <h4>Lecturer: <span class="text-primary"></span>{{ session('userName') }}</span></h4>
                </div>

                <!-- Timetable Form -->
                <form action="{{ route('lecturer.updateSchedule.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="lecturer_name" value="Nanta"> <!-- Static Lecturer Name -->

                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Subject</th>
                                <th>Day</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="scheduleTableBody">
    @foreach($schedules as $schedule)
    <tr>
        <td>
            <input type="text" name="subjects[]" class="form-control" value="{{ $schedule->subject }}" required>
            <input type="hidden" name="schedule_ids[]" value="{{ $schedule->schedule_id }}">
        </td>
        <td>
            <input type="text" name="days[]" class="form-control" value="{{ $schedule->day }}" required>
        </td>
        <td>
            <input type="time" name="start_times[]" class="form-control" value="{{ $schedule->start_time }}" required>
        </td>
        <td>
            <input type="time" name="end_times[]" class="form-control" value="{{ $schedule->end_time }}" required>
        </td>
        <td>
            <input type="text" name="locations[]" class="form-control" value="{{ $schedule->location }}" required>
        </td>
        <td>
            <button type="button" class="btn btn-danger removeRow">Remove</button>
        </td>
    </tr>
    @endforeach
</tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Add New Row Button -->
                        <button type="button" id="addRow" class="btn btn-secondary">Add Row</button>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Update Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
    <div class="alert alert-success mt-3" id="successAlert">
        {{ session('success') }}
    </div>
    @endif

    <!-- JavaScript for Adding/Removing Rows -->
    <script>

        document.getElementById('addRow').addEventListener('click', function () {
            const tableBody = document.getElementById('scheduleTableBody');
            const newRow = `
                <tr>
                    <td><input type="text" name="subjects[]" class="form-control" required></td>
                    <td><input type="text" name="days[]" class="form-control" required></td>
                    <td><input type="time" name="start_times[]" class="form-control" required></td>
                    <td><input type="time" name="end_times[]" class="form-control" required></td>
                    <td><input type="text" name="locations[]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
                </tr>`;
            tableBody.insertAdjacentHTML('beforeend', newRow);
        });

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('removeRow')) {
                e.target.closest('tr').remove();
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.transition = "opacity 0.5s ease";
                successAlert.style.opacity = 0;
                setTimeout(() => successAlert.remove(), 500); // Remove from DOM after fade out
            }, 5000); // 5 seconds delay
        }
    });
    </script>
</body>
</html>
