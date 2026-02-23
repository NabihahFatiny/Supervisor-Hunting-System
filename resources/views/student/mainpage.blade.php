<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Supervisor Hunting</title>
    <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        .welcome-banner {
            background: linear-gradient(135deg, #1f2937 0%, #1f2937 100%);
            color: white;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .welcome-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-text h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .welcome-text p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .student-stats {
            display: flex;
            gap: 2rem;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-item i {
            font-size: 1.5rem;
        }

        .stat-details {
            display: flex;
            flex-direction: column;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .module-grid {
            max-width: 1200px;
            margin: 2rem auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            padding: 0 2rem;
        }

        .module-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
        }

        .card-icon {
            background: #f0f9ff;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .card-icon i {
            font-size: 1.5rem;
            color: #3b82f6;
        }

        .module-card h3 {
            font-size: 1.25rem;
            color: #1f2937;
            margin-bottom: 0.75rem;
        }

        .module-card p {
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.5;
        }
    </style>
</head>
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
                <a href="{{ route('student.schedule') }}" class="nav-item {{ request()->routeIs('student.schedule') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Schedule</span>
                </a>
                <a href="{{ route('student.change-password.view') }}" class="nav-item {{ request()->routeIs('student.change-password.view') ? 'active' : '' }}">
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

    <div class="welcome-banner">
        <div class="welcome-content">
            <div class="welcome-text">
                <h1>Welcome, {{ session('userName') }}!</h1>
                <p>Find your perfect research supervisor</p>
            </div>
            <div class="student-stats">
                <div class="stat-item">
                    <i class="fas fa-paper-plane"></i>
                    <div class="stat-details">
                        <span class="stat-number">{{ $applicationCount ?? 0 }}</span>
                        <span class="stat-label">Applications</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="module-grid">
        <a href="{{ route('student.topics') }}" class="module-card">
            <div class="card-icon">
                <i class="fas fa-search"></i>
            </div>
            <h3>Find Supervisor</h3>
            <p>Browse available research topics and find your perfect supervisor match.</p>
        </a>

        <a href="{{ route('student.applications') }}" class="module-card">
            <div class="card-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h3>My Applications</h3>
            <p>Track and manage your supervisor applications.</p>
        </a>

        <a href="{{ route('student.submit-application.form') }}" class="module-card">
            <div class="card-icon">
                <i class="fas fa-paper-plane"></i>
            </div>
            <h3>Submit Application</h3>
            <p>Submit your own FYP proposal</p>
        </a>

        <a href="{{ route('student.schedule') }}" class="module-card">
            <div class="card-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h3>Schedule</h3>
            <p>View lecturer schedule and make appointment.</p>
        </a>
        <a href="{{ route('student.timeframe') }}" class="module-card">
            <div class="card-icon">
                <i class="fas fa-tasks me-2"></i>
            </div>
            <h3>View Timeframe and Quota</h3>
            <p>View Timeframe and Quota set by fyp Coordinator</p>
        </a>

    </div>
</body>
</html>
