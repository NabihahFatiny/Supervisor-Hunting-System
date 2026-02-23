<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for FYP Title - Supervisor Hunting</title>
    <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        .application-container {
            max-width: 800px;
            margin: 6rem auto;
            padding: 0 1rem;
        }

        .application-form {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-header h1 {
            color: #1f2937;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #6b7280;
        }

        .title-info {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 2rem;
        }

        .title-info h3 {
            color: #1f2937;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .info-group {
            margin-bottom: 1.5rem;
        }

        .info-group label {
            display: block;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .info-text {
            padding: 0.75rem;
            background: #f3f4f6;
            border-radius: 0.5rem;
            color: #4b5563;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background: #f9fafb;
        }

        .text-muted {
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .btn-submit {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            border: none;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
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

    <div class="application-container">
        <div class="application-form">
            <div class="form-header">
                <h1>Apply for FYP Title</h1>
                <p>Please review the title details and submit your proposal document.</p>
            </div>

            <div class="title-info">
                <div class="info-group">
                    <label>Project Title</label>
                    <div class="info-text">{{ $title->TitleName }}</div>
                </div>

                <div class="info-group">
                    <label>Project Description</label>
                    <div class="info-text">{{ $title->PostDescription }}</div>
                </div>

                <div class="info-group">
                    <label>Supervisor</label>
                    <div class="info-text">{{ $title->lecturerName }}</div>
                </div>
            </div>

            <form action="{{ route('student.apply.submit', ['titleId' => $title->TitleID]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student_id }}">
                <input type="hidden" name="lecturer_id" value="{{ $title->lecturer_id }}">
                <input type="hidden" name="title_id" value="{{ $title->TitleID }}">
                <input type="hidden" name="custom_title" value="{{ $title->TitleName }}">
                <input type="hidden" name="description" value="{{ $title->PostDescription }}">

                <div class="form-group">
                    <label for="file">Upload Proposal Document (Required)</label>
                    <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf,.doc,.docx" required>
                    <small class="text-muted">Upload your proposal document (PDF or Word, max 20MB)</small>
                    @error('file')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                @if(session('error'))
                    <div class="error-message">
                        {{ session('error') }}
                    </div>
                @endif

                <button type="submit" class="btn-submit">Submit Application</button>
            </form>
        </div>
    </div>
</body>
</html>
