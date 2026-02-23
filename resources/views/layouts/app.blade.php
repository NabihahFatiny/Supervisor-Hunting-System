<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <title>Supervisor Hunting</title>
  <link rel="stylesheet" href="{{asset('css/styleMain.css')}}">
  <link rel="stylesheet" href="{{asset('css/edit.css')}}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">
                <img src="{{ asset('img/fk.png') }}" alt="FK Logo" class="logo-image">
                <a href="/homepage" class="logo-text">Supervisor Hunting</a>
            </div>

            <div class="nav-links">
                <a href="/homepage" class="nav-item active">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="/topic" class="nav-item">
                    <i class="fas fa-book"></i>
                    <span>Topics</span>
                </a>
                <div class="nav-item dropdown">
                    <button class="dropbtn">
                        <i class="fas fa-th"></i>
                        <span>Features</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="#"><i class="fas fa-chart-line"></i> Analytics</a>
                        <a href="#"><i class="fas fa-users"></i> Teams</a>
                        <a href="#"><i class="fas fa-cog"></i> Settings</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <button class="dropbtn">
                        <i class="fas fa-tools"></i>
                        <span>Services</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="#"><i class="fas fa-graduation-cap"></i> Academic</a>
                        <a href="#"><i class="fas fa-hands-helping"></i> Support</a>
                        <a href="#"><i class="fas fa-book-reader"></i> Resources</a>
                    </div>
                </div>
                <a href="#" class="nav-item">
                    <i class="fas fa-comment"></i>
                    <span>Feedback</span>
                </a>
            </div>

            <div class="nav-search">
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
