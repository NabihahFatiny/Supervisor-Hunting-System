<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Supervisor Hunting</title>
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

    <div class="welcome-banner">
        @if(session('userName'))
            <div class="welcome-content">
                <div class="welcome-text">
                    <h1>Welcome, {{ session('userName') }}</h1>
                    <p>Manage the FYP process, supervise students, and manage topics</p>
                </div>
                <div class="lecturer-stats">
                    <div class="stat-item">
                        <i class="fas fa-book"></i>
                        <div class="stat-details">
                            <span class="stat-number">{{ $lecturerCount ?? 0 }}</span>
                            <span class="stat-label">Total Lecturers</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-users"></i>
                        <div class="stat-details">
                            <span class="stat-number">{{ $studentCount ?? 0 }}</span>
                            <span class="stat-label">Total Students</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="module-grid">
        <!-- Register User -->
        <a href="{{ route('coordinator.register_user') }}" class="module-card">
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3>Register User</h3>
            <p>Register lecturer and student</p>
        </a>
         <!-- Bulk Register User -->
         <a href="{{ route('coordinator.bulk-registrationForm') }}" class="module-card">
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3>Bulk Register User</h3>
            <p>Bulk register lecturer and student</p>
        </a>
        <!-- Timeframe & Quota -->
        <a href="{{ route('coordinator.timeframe') }}" class="module-card">
            <div class="card-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h3>Timeframe and Quota</h3>
            <p>Set supervision timeframes and quotas</p>
        </a>

    </div>
</body>
</html>
