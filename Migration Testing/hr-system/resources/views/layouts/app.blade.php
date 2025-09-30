<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HR System') }} | @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
            --primary-light: #e6ecfe;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --border-color: #e2e8f0;
            --background: #f8fafc;
            --white: #ffffff;
            --success-light: #e6fffa;
            --danger-light: #fff1f0;
            --warning-light: #fefce8;
            --secondary-light: #f1f5f9;
            --transition-speed: 0.3s;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background-color: var(--background);
            margin: 0;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--white);
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            transition: transform var(--transition-speed) ease;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand-icon {
            font-size: 1.75rem;
            color: var(--primary-color);
        }

        .nav {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            color: var(--text-light);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all var(--transition-speed) ease;
        }

        .nav-link:hover {
            background-color: var(--primary-light);
            color: var(--primary-color);
            transform: translateX(4px);
        }

        .nav-link.active {
            background-color: var(--primary-light);
            color: var(--primary-color);
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .nav-link i {
            width: 1.5rem;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar-divider {
            height: 1px;
            background-color: var(--border-color);
            margin: 1.5rem 0;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 2rem;
            background-color: var(--background);
            min-height: 100vh;
            transition: margin-left var(--transition-speed) ease;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .content-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            background: var(--white);
            margin-bottom: 2rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: none;
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .card-body {
            padding: 0;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all var(--transition-speed) ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            color: var(--white);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #2e4ac6 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-outline-info,
        .btn-outline-warning,
        .btn-outline-danger {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            border-radius: 0.5rem;
            transition: all var(--transition-speed) ease;
        }

        .btn-outline-info:hover,
        .btn-outline-warning:hover,
        .btn-outline-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .alert {
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            border: none;
            font-weight: 500;
            position: relative;
        }

        .alert-success {
            background-color: var(--success-light);
            color: #0d9488;
        }

        .alert-danger {
            background-color: var(--danger-light);
            color: #dc2626;
        }

        .btn-close {
            filter: opacity(0.6);
            transition: filter 0.2s ease;
        }

        .btn-close:hover {
            filter: opacity(1);
        }

        /* Table Styles */
        .table {
            margin-bottom: 0;
            background-color: var(--white);
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 0.5rem;
            overflow: hidden;
            width: 100%;
            table-layout: fixed;
        }

        .table-responsive {
            border-radius: 0.5rem;
            overflow-x: auto;
        }

        .table thead th {
            padding: 1rem 1.25rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
            background-color: var(--primary-light);
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
            text-align: left;
        }

        .table tbody td {
            padding: 1rem 1.25rem;
            font-size: 0.9rem;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            white-space: nowrap;
            text-align: left;
        }

        .table thead th:first-child,
        .table tbody td:first-child {
            padding-left: 1.5rem;
        }

        .table thead th:last-child,
        .table tbody td:last-child {
            padding-right: 1.5rem;
            text-align: right;
        }

        .table tbody tr {
            transition: all var(--transition-speed) ease;
        }

        .table tbody tr:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table .badge {
            font-size: 0.8rem;
            font-weight: 500;
            padding: 0.4rem 0.75rem;
            border-radius: 1rem;
            text-transform: capitalize;
        }

        .badge-success {
            background-color: var(--success-light);
            color: #0d9488;
        }

        .badge-warning {
            background-color: var(--warning-light);
            color: #d97706;
        }

        .badge-danger {
            background-color: var(--danger-light);
            color: #dc2626;
        }

        .badge-secondary {
            background-color: var(--secondary-light);
            color: var(--text-light);
        }

        /* Pagination Styles */
        .pagination {
            margin-top: 1.5rem;
            justify-content: center;
        }

        .pagination .page-item .page-link {
            border-radius: 0.5rem;
            margin: 0 0.25rem;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all var(--transition-speed) ease;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-color: var(--primary-color);
            color: var(--white);
            font-weight: 600;
        }

        .pagination .page-item .page-link:hover {
            background-color: var(--primary-light);
            border-color: var(--primary-light);
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .pagination .page-item.disabled .page-link {
            color: var(--text-light);
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Responsive Table */
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.85rem;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border-radius: 0.5rem;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                background-color: var(--white);
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 1rem;
                border-bottom: 1px solid var(--border-color);
                font-size: 0.85rem;
            }

            .table tbody td:last-child {
                border-bottom: none;
            }

            .table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--text-dark);
                flex: 1;
                text-align: left;
            }

            .table tbody td:not(:last-child)::after {
                content: '';
                display: block;
                height: 1px;
                background-color: var(--border-color);
                margin: 0.5rem -1rem 0;
            }

            .table tbody td .badge {
                margin-left: auto;
            }

            .table tbody td .d-flex {
                margin-left: auto;
            }

            .table tbody td:first-child,
            .table tbody td:last-child {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .pagination {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .pagination .page-item .page-link {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .navbar-toggler {
                display: block;
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1100;
                background: var(--primary-color);
                border: none;
                color: var(--white);
                border-radius: 0.5rem;
                padding: 0.5rem;
                font-size: 1.5rem;
                transition: all var(--transition-speed) ease;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <x-sidebar />

        <!-- Main Content -->
        <div class="main-content">
            <button class="navbar-toggler d-md-none" type="button" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list"></i>
            </button>

            <div class="container">
                <div class="content-header">
                    <h1 class="content-title">@yield('title', 'HR System')</h1>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const toggler = document.querySelector('.navbar-toggler');

            toggler.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.add('active');
                } else {
                    sidebar.classList.remove('active');
                }
            });

            if (window.innerWidth > 768) {
                sidebar.classList.add('active');
            }
        });
    </script>
</body>
</html>