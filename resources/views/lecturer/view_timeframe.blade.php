<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Applications</title>
    <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
    <link rel="stylesheet" href="{{asset('css/application.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @php
                    $timeframe = \App\Models\Timeframe::latest()->first();
                    $lecturer = Auth::user();
                @endphp

                <!-- Timeframe Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">Supervisor Hunting Period</h3>
                    @if($timeframe)
                        <div class="bg-blue-50 border border-blue-200 rounded p-4">
                            <p class="mb-2"><strong>Start Date: </strong>{{ date('d M Y', strtotime($timeframe->start_date)) }}</p>
                            <p><strong>End Date: </strong>{{ date('d M Y', strtotime($timeframe->end_date)) }}</p>
                        </div>
                    @else
                        <p class="text-gray-500">No timeframe has been set yet.</p>
                    @endif
                </div>
                @php
    $lecturer = \App\Models\Lecturer::where('lecturerID', session('userId'))->first();
    @endphp
                <!-- Quota Section -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4">Your Supervision Quota</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-lg">
                            Assigned Quota: <span class="font-semibold">{{  $lecturer->assigned_quota ?? 0 }}</span> students
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-lg">
                            Current Quota: <span class="font-semibold">{{ $lecturer->current_quota ?? 0  }}</span> students
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gray-50 {
            background-color: #f9fafb;
        }
        .rounded-lg {
            border-radius: 0.5rem;
        }
        .font-semibold {
            font-weight: 600;
        }
        .font-medium {
            font-weight: 500;
        }
        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }
        .text-gray-600 {
            color: #4b5563;
        }
    </style>
</body>
</html>
