<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Applications</title>
    <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
    <link rel="stylesheet" href="{{asset('css/application.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .applications-header {
            margin-bottom: 2rem;
            padding: 1rem 0;
            border-bottom: 2px solid #e5e7eb;
        }

        .applications-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #1f2937;
        }

        .table-container {
            padding: 1.5rem;
            margin: 1rem 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                        0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .applications-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
        }

        .applications-table th,
        .applications-table td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .applications-table th {
            background-color: #f9fafb;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #4b5563;
        }

        .applications-table tbody tr {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .applications-table tbody tr:hover {
            background-color: #f3f4f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .applications-table td {
            font-size: 0.95rem;
            color: #374151;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
            text-align: center;
            min-width: 110px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .pending {
            background-color: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde047;
        }

        .approved {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .rejected {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .no-applications {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin: 2rem 0;
        }

        .no-applications i {
            font-size: 3rem;
            color: #9ca3af;
            margin-bottom: 1rem;
        }

        .no-applications p {
            color: #6b7280;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .applications-table tr:hover a {
            background-color: #f3f4f6;
        }

        .applications-table a {
            transition: background-color 0.3s ease;
        }

        .applications-table a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
    </style>
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
    <div class="container">
        <div class="applications-header">
            <h1>Student Applications</h1>
        </div>

        @if($applications->count() > 0)
            <div class="table-container">
                <table class="applications-table">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Student ID</th>
                            <th>Title</th>
                            <th>Applied Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                        <tr onclick="window.location.href='{{ url('/lecturer/applications/' . $application->application_id) }}'" style="cursor: pointer">
                            <td>
                                {{ $application->studName }}
                            </td>
                            <td>{{ $application->student_id }}</td>
                            <td>{{ $application->TitleName }}</td>
                            <td>{{ date('d M Y', strtotime($application->created_at)) }}</td>
                            <td>
                                <span class="status-badge {{ strtolower($application->status) }}">
                                    {{ $application->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-applications">
                <i class="fas fa-inbox"></i>
                <p>No applications found</p>
            </div>
        @endif
    </div>
</body>
</html>
