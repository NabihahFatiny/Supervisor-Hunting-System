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
<style>
/* General Styling for Both Button and File Input */
button, input[type="file"] {
    font-family: inherit; /* Ensures consistent font across elements */
    border-radius: 0.375rem; /* Rounded corners for both */
    padding: 0.75rem 1.5rem; /* Inner spacing */
    font-size: 1rem; /* Text size */
    font-weight: 600; /* Bold text */
    cursor: pointer; /* Pointer cursor for interactive elements */
    transition: all 0.3s ease; /* Smooth transition for all properties */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

/* Button Styling */
button {
    background-color: #1D4ED8; /* Primary blue color */
    color: #FFFFFF; /* White text */
    border: none; /* No border for a clean look */
}

button:hover {
    background-color: #2563EB; /* Darker blue on hover */
    transform: translateY(-2px); /* Slight lift effect */
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15); /* Enhanced shadow */
}

button:active {
    background-color: #1E40AF; /* Even darker blue on click */
    transform: translateY(0); /* Reset lift effect */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

/* File Input Styling */
input[type="file"] {
    background-color: #F9FAFB; /* Light background */
    color: #4B5563; /* Gray text */
    border: 1px solid #D1D5DB; /* Light border */
    outline: none; /* Remove default outline */
    padding-left: 1.25rem; /* Add space for file name */
}

input[type="file"]:hover {
    border-color: #2563EB; /* Blue border on hover */
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

input[type="file"]:focus {
    border-color: #1D4ED8; /* Focused blue border */
    box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.3); /* Blue focus ring */
}

/* Custom Styling for the Choose File Button inside File Input */
input[type="file"]::file-selector-button {
    background-color: #1D4ED8; /* Blue button */
    color: #FFFFFF; /* White text */
    padding: 0.5rem 1rem; /* Adjust padding */
    border: none; /* Remove default border */
    border-radius: 0.375rem; /* Rounded corners */
    cursor: pointer; /* Pointer cursor */
    font-size: 0.875rem; /* Slightly smaller text */
    transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth effects */
}

input[type="file"]::file-selector-button:hover {
    background-color: #2563EB; /* Darker blue on hover */
}

input[type="file"]::file-selector-button:active {
    background-color: #1E40AF; /* Even darker blue on click */
    transform: scale(0.98); /* Slight shrink on click */
}

    </style>

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
<div class="container mx-auto py-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-gray-700 mb-6">Bulk Registration</h1>

        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('coordinator.bulk-registration') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="file" class="block text-sm font-medium text-gray-700">Upload CSV File</label><br><br>
                <input type="file" name="file" id="file" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('file')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            <br><br>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                Upload
            </button>
        </form>
    </div>
</div>

</body>
</html>
