<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Supervisor Hunting</title>
  <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
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

    <div class="welcome-banner">
        @if(session('userName'))
            <div class="welcome-content">
                <div class="welcome-text">
                    <h1>Welcome, {{ session('userName') }}</h1>
                    <p>Manage your research topics and supervisions</p>
                </div>
                <div class="lecturer-stats">
                    <div class="stat-item">
                        <i class="fas fa-book"></i>
                        <div class="stat-details">
                            <span class="stat-number">{{ $lecturerCurrentQuota ?? 0 }}</span>
                            <span class="stat-label">Total Supervisee</span>
                        </div>
                    </div>
                </div>
            </div>



        @endif
    </div>
    <div class="module-grid">
        <a href="{{ route('posts.topic') }}" class="module-card">
            <div class="card-icon">
                <i class="fas fa-book"></i>
            </div>
            <h3>Research Topics</h3>
            <p>Manage your research topics and proposals</p>
        </a>

        <a href="{{ route('applications.index') }}" class="module-card">
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3>Student Applications</h3>
            <p>Review and manage student requests</p>
        </a>

        <a href="{{ route('lecturer.timeframe') }}" class="module-card">
            <div class="card-icon">
                <i class="fas fa-chart-line me-2"></i>
            </div>
            <h3>View Timeframe and Quota</h3>
            <p>View Timeframe set by Fyp Coordinator and View Quota set by FYP Coordinator</p>
        </a>
        <a href="{{ route('lecturer.schedule') }}" class="module-card">
            <div class="card-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h3>Schedule</h3>
            <p>Manage my schedules and appointments</p>
        </a>
    </div>
</body>
</html>
