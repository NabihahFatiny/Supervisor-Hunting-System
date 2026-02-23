<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications - Supervisor Hunting</title>
    <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
        }



        /* Main content styles */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .page-description {
            color: #6b7280;
            font-size: 0.875rem;
        }

        /* Applications list styles */
        .applications-list {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .application-item {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s;
        }

        .application-item:last-child {
            border-bottom: none;
        }

        .application-item:hover {
            background-color: #f9fafb;
        }

        .application-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .application-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .application-supervisor {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .application-status {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .application-details {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1rem;
        }

        .application-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.75rem;
            color: #9ca3af;
        }

        .application-date {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .application-attachment {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: #3b82f6;
            text-decoration: none;
        }

        .application-attachment:hover {
            text-decoration: underline;
        }

        .no-applications {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }

        .success-message {
            background-color: #d1fae5;
            color: #065f46;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .error-message {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
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


    <div class="container">
        <div class="page-header">
            <h1 class="page-title">My Applications</h1>
            <p class="page-description">Track the status of your FYP applications</p>
        </div>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <div class="applications-list">
            @if($applications->count() > 0)
                @foreach($applications as $application)
                    <div class="application-item">
                        <div class="application-header">
                            <div>
                                <h3 class="application-title">{{ $application->custom_title }}</h3>
                                <p class="application-supervisor">Supervisor: {{ $application->lecturerName }}</p>
                            </div>
                            <span class="application-status status-{{ strtolower($application->status) }}">
                                {{ $application->status }}
                            </span>
                        </div>
                        <div class="application-details">
                            {{ $application->description }}
                        </div>
                        <div class="application-meta">
                            <div class="application-date">
                                <i class="far fa-calendar"></i>
                                Submitted on {{ \Carbon\Carbon::parse($application->created_at)->format('F j, Y') }}
                            </div>
                            @if($application->file_path)
                                <a href="{{ Storage::url($application->file_path) }}" class="application-attachment" target="_blank">
                                    <i class="fas fa-paperclip"></i>
                                    View Attachment
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no-applications">
                    <i class="fas fa-inbox fa-3x" style="color: #9ca3af; margin-bottom: 1rem;"></i>
                    <p>You haven't submitted any applications yet.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
