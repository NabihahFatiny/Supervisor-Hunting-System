<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Supervisor Hunting</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a4f8b 0%, #2c3e50 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('img/pattern.png') }}') repeat;
            opacity: 0.05;
            z-index: 0;
        }

        .login-wrapper {
            width: 100%;
            padding: 1rem;
            display: flex;
            justify-content: center;
            position: relative;
            z-index: 1;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 3rem;
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 420px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }

        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .logo-image {
            width: 120px;
            height: auto;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
            transition: transform 0.3s ease;
        }

        .logo-image:hover {
            transform: scale(1.05);
        }

        .logo-text {
            color: #1a4f8b;
            font-size: 1.75rem;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 0.1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .welcome-text {
            color: #4b5563;
            font-size: 1rem;
            margin-bottom: 2.5rem;
            line-height: 1.5;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #1a4f8b;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .input-field {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            color: #1f2937;
        }

        .input-field:focus {
            outline: none;
            border-color: #1a4f8b;
            background: white;
            box-shadow: 0 0 0 4px rgba(26, 79, 139, 0.1);
        }

        .input-field:focus + i {
            color: #1a4f8b;
            transform: translateY(-50%) scale(1.1);
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error-message::before {
            content: '⚠';
            font-size: 1rem;
        }

        .login-button {
            background: linear-gradient(135deg, #1a4f8b 0%, #2c3e50 100%);
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 0.75rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 79, 139, 0.2);
        }

        .forgot-password {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .forgot-password a {
            color: #1a4f8b;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .forgot-password a:hover {
            color: #2c3e50;
            transform: translateX(5px);
        }

        .forgot-password a::after {
            content: '→';
            transition: transform 0.3s ease;
        }

        .forgot-password a:hover::after {
            transform: translateX(5px);
        }

        @media (max-width: 640px) {
            .login-container {
                padding: 2rem;
            }

            .logo-image {
                width: 100px;
            }

            .logo-text {
                font-size: 1.5rem;
            }
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

        .login-container {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="logo">
                <img src="{{ asset('img/fk.png') }}" alt="FK Logo" class="logo-image">
                <a href="/" class="logo-text">Supervisor Hunting</a>
                <p class="welcome-text">Welcome back! Please sign in to your account.</p>
            </div>

            <form action="{{ route('SHS.submit') }}" method="POST" class="login-form">
                @csrf
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input
                        type="text"
                        name="username"
                        placeholder="Enter your username"
                        required
                        class="input-field"
                        value="{{ old('username') }}"
                    >
                    @error('username')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                        class="input-field"
                    >
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="login-button">
                    Sign In
                </button>

                <div class="forgot-password">
                    <a href="#">Forgot your password?</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
