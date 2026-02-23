<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Set Timeframe - Supervisor Hunting</title>
    <link rel="stylesheet" href="{{ asset('css/styleMain.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">
                <img src="{{ asset('img/fk.png') }}" alt="FK Logo" class="logo-image">
                <a href="{{ route('coordinator.mainpage') }}" class="logo-text">Supervisor Hunting</a>
            </div>

            <div class="nav-links">
                <a href="{{ route('coordinator.mainpage') }}" class="nav-item {{ request()->routeIs('coordinator.mainpage') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('coordinator.register_user') }}" class="nav-item {{ request()->routeIs('coordinator.register_user') ? 'active' : '' }}">
                    <i class="fas fa-user-plus"></i>
                    <span>Register User</span>
                </a>
                <a href="{{ route('coordinator.bulk-registrationForm') }}" class="nav-item {{ request()->routeIs('coordinator.bulk-registrationForm') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Bulk Register User</span>
                </a>
                <a href="{{ route('coordinator.timeframe') }}" class="nav-item {{ request()->routeIs('coordinator.timeframe') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Timeframe & Quota</span>
                </a>
                <a href="/SHS" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </nav>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Current Timeframe Display -->
                @php
                    $currentTimeframe = \App\Models\Timeframe::latest()->first();
                @endphp

                @if($currentTimeframe)
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h3 class="text-lg font-semibold mb-3">Current Timeframe</h3>
                        <p class="mb-2">
                            <span class="font-medium">Start Date:</span>
                            {{ \Carbon\Carbon::parse($currentTimeframe->start_date)->format('d/m/Y') }}
                        </p>
                        <p>
                            <span class="font-medium">End Date:</span>
                            {{ \Carbon\Carbon::parse($currentTimeframe->end_date)->format('d/m/Y') }}
                        </p>
                    </div>
                @endif

                <!-- Set New Timeframe Form -->
                <h3 class="text-xl font-semibold mb-4">Set New Supervisor Hunting Period</h3>

                <form id="timeframeForm" method="POST" action="{{ route('coordinator.save_timeframe') }}" onsubmit="return confirmTimeframe()">
                    @csrf
                    <div class="mb-4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Save Timeframe
                    </button>
                </form>

                @if(session('success'))
                <div class="alert alert-success mt-3" id="successMessage">
                    {{ session('success') }}
                </div>
            @endif

                @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        .py-12 {
            padding: 3rem 0;
        }

        .max-w-7xl {
            max-width: 80rem;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .bg-white {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            margin-top: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.25);
        }

        .btn-primary {
            background-color: #4a90e2;
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background-color: #357abd;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .alert {
            padding: 1rem;
            margin-top: 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .mb-6 {
            margin-bottom: 2rem;
        }

        .text-xl {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 1.5rem;
        }

        .bg-blue-50 {
            background-color: #f0f7ff;
            padding: 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid #bfdbfe;
            margin-bottom: 2rem;
        }

        .text-lg {
            font-size: 1.125rem;
            color: #2d3748;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-medium {
            font-weight: 500;
            color: #4a5568;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4a5568;
            font-weight: 500;
        }

        .block {
            display: block;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .text-gray-700 {
            color: #4a5568;
        }

        /* Date picker customization */
        .flatpickr-calendar {
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .flatpickr-day.selected {
            background: #4a90e2;
            border-color: #4a90e2;
        }

        .flatpickr-day:hover {
            background: #f0f7ff;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize flatpickr for both date inputs
            flatpickr("#start_date", {
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: function(selectedDates) {
                    // Update end date minimum when start date changes
                    endDatePicker.set("minDate", selectedDates[0]);
                }
            });

            const endDatePicker = flatpickr("#end_date", {
                dateFormat: "Y-m-d",
                minDate: "today"
            });
            const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            // Set a timer to hide the success message after 5 seconds
            setTimeout(function () {
                successMessage.style.display = 'none';
            }, 5000); // 5000 milliseconds = 5 seconds
        }
        });

        function confirmTimeframe() {
            return confirm('Are you sure you want to set this timeframe? This will affect the supervisor hunting period.');
        }
    </script>
</body>
</html>
