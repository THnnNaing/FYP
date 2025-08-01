<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HR System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #4361ee;
            --primary-light: #e6ecfe;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --border-color: #e2e8f0;
            --transition-speed: 0.3s;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            transition: all var(--transition-speed) ease;
            position: relative;
            z-index: 10;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand-icon {
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .nav {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: var(--text-light);
            text-decoration: none;
            transition: all var(--transition-speed) ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background-color: var(--primary-light);
            color: var(--primary-color);
        }

        .nav-link.active {
            background-color: var(--primary-light);
            color: var(--primary-color);
            font-weight: 600;
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
            border: none;
        }

        /* User Profile */
        .user-profile {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }

        .user-dropdown:hover {
            background-color: var(--primary-light);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: 600;
        }

        .user-name {
            font-weight: 500;
            color: var(--text-dark);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            padding: 0.5rem;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            font-weight: 500;
            color: var(--text-dark);
            transition: all var(--transition-speed) ease;
        }

        .dropdown-item:hover {
            background-color: var(--primary-light);
            color: var(--primary-color);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            background-color: #f8fafc;
            min-height: 100vh;
            transition: all var(--transition-speed) ease;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            background: white;
            margin-bottom: 1.5rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: none;
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all var(--transition-speed) ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #3a56d4;
            border-color: #3a56d4;
            transform: translateY(-1px);
        }

        /* Alerts */
        .alert {
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            border: none;
        }

        /* Responsive */
        @media (max-width: 992px) {
            :root {
                --sidebar-width: 80px;
            }

            .sidebar-brand span,
            .nav-link span {
                display: none;
            }

            .sidebar-header {
                justify-content: center;
            }

            .nav-link {
                justify-content: center;
                padding: 0.75rem;
            }

            .user-dropdown span {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -100%;
                z-index: 1000;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <!-- Include the sidebar component -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
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

    <script>
        // Simple mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.createElement('button');
            toggleBtn.innerHTML = '☰';
            toggleBtn.style.position = 'fixed';
            toggleBtn.style.top = '1rem';
            toggleBtn.style.left = '1rem';
            toggleBtn.style.zIndex = '1000';
            toggleBtn.style.background = 'var(--primary-color)';
            toggleBtn.style.color = 'white';
            toggleBtn.style.border = 'none';
            toggleBtn.style.borderRadius = '50%';
            toggleBtn.style.width = '40px';
            toggleBtn.style.height = '40px';
            toggleBtn.style.display = 'none';

            document.body.appendChild(toggleBtn);

            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });

            function checkScreenSize() {
                if (window.innerWidth <= 768) {
                    toggleBtn.style.display = 'block';
                    sidebar.classList.remove('active');
                } else {
                    toggleBtn.style.display = 'none';
                    sidebar.classList.add('active');
                }
            }

            window.addEventListener('resize', checkScreenSize);
            checkScreenSize();
        });
    </script>
</body>

</html>