<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Supervisor Hunting')</title>
    <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    @yield('styles')
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
                <a href="{{ route('lecturer.topics') }}" class="nav-item {{ request()->routeIs('lecturer.topics') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Topics</span>
                </a>
                <a href="{{ route('lecturer.applications') }}" class="nav-item {{ request()->routeIs('lecturer.applications') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Applications</span>
                </a>
                <a href="{{ route('lecturer.profile') }}" class="nav-item {{ request()->routeIs('lecturer.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="{{ route('logout') }}" class="nav-item"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>
