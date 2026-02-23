<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Appointment Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<style>.container {
    max-width: 700px; /* Limit the maximum width of the form */
    margin: 0 auto;   /* Center the form horizontally */
    padding: 20px;    /* Add some padding for spacing */
}

.card {
    border-radius: 10px; /* Round the corners */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
}

.card-header {
    font-size: 1.5rem; /* Slightly larger text for the header */
}

.card-body {
    padding: 20px;
}

form .form-label {
    font-weight: bold; /* Make form labels bold */
}

form .form-control {
    border-radius: 5px; /* Rounded input fields */
}

button.btn-primary {
    width: 100%; /* Make the submit button span the full width */
    border-radius: 5px;
}
</style>
<body>
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">
                <img src="{{ asset('img/fk.png') }}" alt="FK Logo" class="logo-image">
                <a href="{{ route('student.mainpage') }}" class="logo-text">Supervisor Hunting</a>
            </div>

            <div class="nav-links">
                <a href="{{ route('student.mainpage') }}" class="nav-item {{ request()->routeIs('student.mainpage') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('student.topics') }}" class="nav-item {{ request()->routeIs('student.topics') ? 'active' : '' }}">
                    <i class="fas fa-search"></i>
                    <span>Browse Topics</span>
                </a>
                <a href="{{ route('student.applications') }}" class="nav-item {{ request()->routeIs('student.applications') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>My Applications</span>
                </a>
                <a href="{{ route('student.profile') }}" class="nav-item {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
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
                <h2>Appointment Request Form</h2>
            </div>
            <div class="card-body">
                <!-- Display Success Message -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Appointment Request Form -->
                <form action="{{ route('student.bookAppointment') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="lecturer_name" class="form-label">Lecturer Name</label>
                        <select class="form-control" id="lecturer_id" name="lecturer_id" required>
                            @foreach ($lecturers as $lecturer)
                                <option value="{{ $lecturer->lecturerID }}">{{ $lecturer->lecturerName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="student_id" value="{{ session('userId') }}">
                    <div class="mb-3">
                        <label for="topic" class="form-label">Topic</label>
                        <input type="text" class="form-control" id="topic" name="topic" required>
                    </div>

                    <div class="mb-3">
                        <label for="day" class="form-label">Day</label>
                        <select class="form-control" id="day" name="day" required>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <select class="form-control" id="time" name="time" required>
                            <option value="09:00-10:00">9:00 AM - 10:00 AM</option>
                            <option value="10:00-11:00">10:00 AM - 11:00 AM</option>
                            <option value="11:00-12:00">11:00 AM - 12:00 PM</option>
                            <option value="12:00-01:00">12:00 PM - 01:00 PM</option>
                            <option value="01:00-02:00">01:00 PM - 02:00 PM</option>
                            <option value="02:00-03:00">02:00 PM - 03:00 PM</option>
                            <option value="03:00-04:00">03:00 PM - 04:00 PM</option>
                            <option value="04:00-05:00">04:00 PM - 05:00 PM</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                         <input type="text" class="form-control" id="location" name="location" required>

                    </div>

                    <button type="submit" class="btn btn-primary">Submit Appointment Request</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
