@extends('layouts.lecturer')

@section('title', 'Dashboard - Supervisor Hunting')

@section('content')
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
@endsection
