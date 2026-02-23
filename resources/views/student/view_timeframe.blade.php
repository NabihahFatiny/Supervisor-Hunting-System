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
                <a href="/homepage" class="logo-text">Supervisor Hunting</a>
            </div>

            <div class="nav-links">
                <a href="{{ route('lecturer.mainpage') }}" class="nav-item">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('posts.topic') }}" class="nav-item">
                    <i class="fas fa-book"></i>
                    <span>Topics</span>
                </a>
                <a href="{{ route('applications.index') }}" class="nav-item ">
                    <i class="fas fa-users"></i>
                    <span>Applications</span>
                </a>
                <a href="{{ route('student.timeframe') }}" class="nav-item active">
                    <i class="fas fa-users"></i>
                    <span>Timeframe</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Timeframe Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold mb-4">Supervisor Hunting Period</h3>
                    @php
                        $timeframe = \App\Models\Timeframe::latest()->first();
                    @endphp
                    @if($timeframe)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="mb-2">
                                <span class="font-medium">Start Date:</span>
                                {{ \Carbon\Carbon::parse($timeframe->start_date)->format('d M Y') }}
                            </p>
                            <p>
                                <span class="font-medium">End Date:</span>
                                {{ \Carbon\Carbon::parse($timeframe->end_date)->format('d M Y') }}
                            </p>
                        </div>
                    @else
                        <p class="text-gray-600">No hunting period has been set yet.</p>
                    @endif
                </div>

                <!-- Lecturers Quota Section -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">Lecturers Supervision Quota</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 border-b text-left">Lecturer Name</th>
                                    <th class="px-6 py-3 border-b text-center">Available Quota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                     $lecturers = \App\Models\Lecturer::orderBy('lecturerName')->get();
                                @endphp
                                @foreach($lecturers as $lecturer)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 border-b">{{ $lecturer->lecturerName }}</td>
                                        <td class="px-6 py-4 border-b text-center">
                                            {{ $lecturer->balance_quota ?? 0 }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th {
            background-color: #f9fafb;
            font-weight: 600;
        }
        td, th {
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
        }
        tr:hover {
            background-color: #f9fafb;
        }
    </style>
</body>
</html>

