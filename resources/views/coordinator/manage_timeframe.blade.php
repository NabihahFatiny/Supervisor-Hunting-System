<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register User - Supervisor Hunting</title>
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
                <div class="row g-4">
                    <!-- Set Timeframe Card -->
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm hover-card">
                            <div class="card-body text-center p-4">
                                <h5 class="card-title mb-3">Set Timeframe</h5>
                                <p class="card-text text-muted mb-4">Set the timeframe for supervisor hunting period</p>
                                <a href="{{ route('coordinator.setTimeframe') }}" class="btn btn-primary w-100">
                                    <i class="fas fa-clock me-2"></i> Set Timeframe
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Set Quota Card -->
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm hover-card">
                            <div class="card-body text-center p-4">
                                <h5 class="card-title mb-3">Set Quota</h5>
                                <p class="card-text text-muted mb-4">Set the maximum number of students per supervisor
                                </p>
                                <a href="{{ route('coordinator.setQuota') }}" class="btn btn-primary w-100">
                                    <i class="fas fa-users me-2"></i> Set Quota
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            padding: 2rem;
        }

        .col-md-6 {
            flex: 1;
            min-width: 300px;
        }

        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            border: none;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d3748;
            margin: 0;
        }

        .card-text {
            color: #6b7280;
            text-align: center;
            margin: 0;
            line-height: 1.5;
        }

        .btn-primary {
            background-color: #4a90e2;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            width: auto;
            min-width: 200px;
            justify-content: center;
        }

        .btn-primary:hover {
            background-color: #357abd;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .fas {
            font-size: 1.1rem;
        }

        .bg-white {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 2rem;
            padding: 2rem;
        }

        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 1rem;
            overflow: hidden;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .text-muted {
            color: #6b7280 !important;
        }

        .shadow-sm {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
</body>
</html>
