<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0; /* Remove the padding-top */
        }
        .container {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 20px;
            margin: 20px auto;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .success {
            color: green;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">
                <img src="{{ asset('img/fk.png') }}" alt="FK Logo" class="logo-image">
                <a href="/homepage" class="logo-text">Supervisor Hunting</a>
            </div>
            <div class="nav-links">
                @if(session('role') === 'Student')
                    <a href="{{ route('student.mainpage') }}" class="nav-item">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                    <a href="{{ route('student.topics') }}" class="nav-item">
                        <i class="fas fa-book"></i>
                        <span>Topics</span>
                    </a>
                    <a href="{{ route('student.applications') }}" class="nav-item">
                        <i class="fas fa-file-alt"></i>
                        <span>Applications</span>
                    </a>
                @else
                    <a href="{{ route('lecturer.mainpage') }}" class="nav-item">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                    <a href="{{ route('posts.topic') }}" class="nav-item">
                        <i class="fas fa-book"></i>
                        <span>Topics</span>
                    </a>
                    <a href="{{ route('applications.index') }}" class="nav-item">
                        <i class="fas fa-file-alt"></i>
                        <span>Applications</span>
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Change Password</h2>
        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ session('role') === 'Student' ? route('student.change-password.update') : route('lecturer.change-password.update') }}">
            @csrf
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required>

            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="new_password_confirmation">Confirm New Password</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>

            <button type="submit">Change Password</button>
        </form>
    </div>
</body>
</html>

