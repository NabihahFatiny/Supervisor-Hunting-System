<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Submit Application - Supervisor Hunting</title>
    <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        .application-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .application-form {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            margin-bottom: 2rem;
        }

        .form-header h1 {
            font-size: 1.5rem;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #6b7280;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #374151;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .title-info {
            background: #f9fafb;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .title-info h3 {
            font-size: 1.1rem;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .title-info p {
            color: #6b7280;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .title-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .btn-submit {
            background: #2563eb;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            width: 100%;
        }

        .btn-submit:hover {
            background: #1d4ed8;
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
                <h1>Submit New Application</h1>
                <p>Please fill in the details below to submit your FYP application proposal.</p>
            </div>

            <div class="title-info">
                <h3>Submit Your Own FYP Proposal</h3>
                <p>Create and submit your own FYP title and proposal to your chosen supervisor.</p>
            </div>

            <form action="{{ route('student.submit-application') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student_id }}">

                <div class="form-group">
                    <label for="lecturer_id">Select Supervisor</label>
                    <select name="lecturer_id" id="lecturer_id" class="form-control" required>
                        <option value="">Choose a supervisor...</option>
                        @foreach($lecturers as $lecturer)
                            <option value="{{ $lecturer->lecturerID }}">{{ $lecturer->lecturerName }}</option>
                        @endforeach
                    </select>
                    @error('lecturer_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="custom_title">Project Title</label>
                    <input type="text" name="custom_title" id="custom_title" class="form-control" required
                        placeholder="Enter your proposed FYP title">
                    @error('custom_title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Project Description</label>
                    <textarea name="description" id="description" class="form-control" required rows="5"
                        placeholder="Describe your proposed project, its objectives, and expected outcomes..."></textarea>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="file">Supporting Document (Optional)</label>
                    <input type="file" name="file" id="file" class="form-control"
                        accept=".pdf,.doc,.docx">
                    <small class="text-muted">Upload a PDF or Word document (max 20MB)</small>
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
