<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register User - Supervisor Hunting</title>
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
    <div class="container">
        <div class="register-card">
            <h2 class="register-title">Register New User</h2>
            <p class="register-subtitle">Create a new account for lecturer or student</p>

            @if(session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('coordinator.register.submit') }}" class="register-form" id="register-form">
                @csrf

                <div class="form-group">
                    <label for="name">
                        <i class="fas fa-user"></i>
                        Full Name
                    </label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                        placeholder="Enter full name">
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-at"></i>
                        Username
                    </label>
                    <input type="text" name="username" id="username" required value="{{ old('username') }}"
                        placeholder="Enter username">
                    @error('username')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                        Email Address
                    </label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                        placeholder="Enter email address">
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="user_id">
                        <i class="fas fa-id-card"></i>
                        Student/Lecturer ID
                    </label>
                    <input type="text" name="user_id" id="user_id" required value="{{ old('user_id') }}"
                        placeholder="Enter user ID">
                    @error('user_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role">
                        <i class="fas fa-user-tag"></i>
                        Role
                    </label>
                    <select name="role" id="role" required>
                        <option value="">Select Role</option>
                        <option value="Lecturer" {{ old('role') == 'Lecturer' ? 'selected' : '' }}>Lecturer</option>
                        <option value="Student" {{ old('role') == 'Student' ? 'selected' : '' }}>Student</option>
                    </select>
                    @error('role')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="register-button">
                    <i class="fas fa-user-plus"></i>
                    Register User
                </button>
            </form>
        </div>
    </div>

    <script>
        // If there's a success message
        if (document.getElementById('success-alert')) {
            // After 3 seconds
            setTimeout(function() {
                // Clear the form
                document.getElementById('register-form').reset();
                // Hide the success message with fade out effect
                var alert = document.getElementById('success-alert');
                alert.style.transition = 'opacity 0.5s ease-in-out';
                alert.style.opacity = '0';
                // After fade out, remove the element
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }, 3000);
        }
    </script>

    <style>
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .register-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            animation: fadeIn 0.5s ease-out;
        }

        .register-title {
            color: #1a4f8b;
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .register-subtitle {
            color: #6b7280;
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-form {
            display: grid;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            color: #374151;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group label i {
            color: #1a4f8b;
            width: 1rem;
        }

        .form-group input,
        .form-group select {
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #1a4f8b;
            box-shadow: 0 0 0 3px rgba(26, 79, 139, 0.1);
            outline: none;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .register-button {
            background: linear-gradient(135deg, #1a4f8b 0%, #2c3e50 100%);
            color: white;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 79, 139, 0.2);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 640px) {
            .container {
                margin: 1rem auto;
            }

            .register-card {
                padding: 1.5rem;
            }

            .register-title {
                font-size: 1.5rem;
            }
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: opacity 0.5s ease-in-out;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert ul {
            margin: 0;
            padding-left: 1.5rem;
        }

        .alert li {
            margin-bottom: 0.25rem;
        }
    </style>
</body>
</html>

