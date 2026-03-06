<?php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Technology Rental System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: linear-gradient(135deg, #0d47a1 0%, #388e3c 100%);
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
            color: white;
            min-height: 100vh;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .sidebar .nav-link {
            color: white;
            padding: 15px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
            font-weight: 500;
            margin: 5px 0;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-left-color: #4dd0e1;
            color: white;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }

        .main-content {
            padding: 30px;
            background: #f5f5f5;
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 20px;
        }

        .stat-card .number {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
        }

        .stat-card .label {
            color: #999;
            margin-top: 10px;
            font-size: 14px;
        }

        .logo {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .logout-btn {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
        }

        .tech-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        .badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .badge-available {
            background-color: #388e3c;
            color: white;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #333;
        }

        .badge-fixing {
            background-color: #dc3545;
            color: white;
        }

        /* Bootstrap Color Overrides */
        .btn-primary {
            background-color: #0d47a1;
            border-color: #0d47a1;
        }

        .btn-primary:hover {
            background-color: #1565c0;
            border-color: #1565c0;
        }

        .btn-primary:focus,
        .btn-primary.focus {
            background-color: #1565c0;
            border-color: #1565c0;
            box-shadow: 0 0 0 0.25rem rgba(13, 71, 161, 0.5);
        }

        .bg-primary {
            background-color: #0d47a1 !important;
        }

        a.bg-primary:hover,
        a.bg-primary:focus,
        button.bg-primary:hover,
        button.bg-primary:focus {
            background-color: #1565c0 !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-md-2 sidebar">
                <div class="logo">
                    <h2 style="font-size: 28px; font-weight: bold; color: #fff; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                        🌾 Camia AgriTech
                    </h2>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('rental.dashboard') ? 'active' : '' }}"
                        href="{{ route('rental.dashboard') }}">
                        <i class="fas fa-home"></i> Home
                    </a>
                    <a class="nav-link {{ request()->routeIs('rental.rentals.*') ? 'active' : '' }}"
                        href="{{ route('rental.rentals.create') }}">
                        <i class="fas fa-handshake"></i> Renting
                    </a>
                    <a class="nav-link" href="#"
                        onclick="alert('Monitor - View all active rentals'); return false;">
                        <i class="fas fa-television"></i> Monitor
                    </a>
                    <a class="nav-link" href="#"
                        onclick="alert('Report - Generate rental reports'); return false;">
                        <i class="fas fa-file-alt"></i> Report
                    </a>
                    <a class="nav-link" href="#"
                        onclick="alert('System Status - All systems operational'); return false;">
                        <i class="fas fa-cog"></i> System Status
                    </a>
                </nav>

                <div class="logout-btn">
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>
                    @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>