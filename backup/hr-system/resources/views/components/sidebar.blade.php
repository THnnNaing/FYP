<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HR System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Bootstrap Icons (optional, approve if needed) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #007bff;
            /* Blue */
            color: white;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1rem;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
        }

        .sidebar-brand-icon {
            margin-right: 0.5rem;
        }

        .nav {
            flex-direction: column;
            padding: 0 1rem;
        }

        .nav-link {
            color: white;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            border-radius: 0.25rem;
            cursor: pointer;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: #0056b3;
            /* Darker blue */
        }

        .nav-link i {
            margin-right: 0.5rem;
        }

        .submenu {
            padding-left: 2rem;
            display: none;
        }

        .submenu.show {
            display: block;
        }

        .submenu-toggle {
            margin-left: auto;
            transition: transform 0.2s ease;
        }

        .submenu-toggle.rotate-180 {
            transform: rotate(180deg);
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin: 1rem 0;
        }

        .user-profile {
            padding: 1rem;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
        }

        .user-avatar {
            width: 2rem;
            height: 2rem;
            background-color: #0056b3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
        }

        .dropdown-menu {
            background-color: #fff;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
        }

        .dropdown-item i {
            margin-right: 0.5rem;
        }

        .content {
            margin-left: 250px;
            /* Match sidebar width */
            background-color: #f8f9fa;
            /* Light gray */
            min-height: 100vh;
            padding: 2rem;
        }

        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <a href="{{ url('/') }}" class="sidebar-brand">
                    <i class="sidebar-brand-icon bi bi-people-fill"></i>
                    <span>{{ config('app.name', 'HR System') }}</span>
                </a>
            </div>

            <ul class="nav">
                @auth
                @if(auth()->user()->user_type === 'admin')
                <!-- Admin Sidebar -->
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house-fill"></i>
                        <span>Dashboard (Admin)</span>
                    </a>
                </li>

                <!-- Leave Types Management -->
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#leave-types-submenu">
                        <i class="bi bi-calendar-check"></i>
                        <span>Leave Types Management</span>
                        <i class="submenu-toggle bi bi-chevron-down"></i>
                    </a>
                    <ul class="submenu collapse" id="leave-types-submenu">
                        <li>
                            <a href="{{ route('leave_types.index') }}" class="nav-link {{ Route::is('leave_types.*') ? 'active' : '' }}">
                                <span>View Leave Types</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('leave_types.create') }}" class="nav-link {{ Route::is('leave_types.create') ? 'active' : '' }}">
                                <span>Create Leave Type</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Designation Management -->
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#designations-submenu">
                        <i class="bi bi-briefcase-fill"></i>
                        <span>Designation Management</span>
                        <i class="submenu-toggle bi bi-chevron-down"></i>
                    </a>
                    <ul class="submenu collapse" id="designations-submenu">
                        <li>
                            <a href="{{ route('designations.index') }}" class="nav-link {{ Route::is('designations.index') ? 'active' : '' }}">
                                <span>View Designations</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('designations.create') }}" class="nav-link {{ Route::is('designations.create') ? 'active' : '' }}">
                                <span>Create Designation</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Department Management -->
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#departments-submenu">
                        <i class="bi bi-building"></i>
                        <span>Department Management</span>
                        <i class="submenu-toggle bi bi-chevron-down"></i>
                    </a>
                    <ul class="submenu collapse" id="departments-submenu">
                        <li>
                            <a href="{{ route('departments.index') }}" class="nav-link {{ Route::is('departments.index') ? 'active' : '' }}">
                                <span>View Departments</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('departments.create') }}" class="nav-link {{ Route::is('departments.create') ? 'active' : '' }}">
                                <span>Create Department</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Employee Management -->
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#employees-submenu">
                        <i class="bi bi-person-workspace"></i>
                        <span>Employee Management</span>
                        <i class="submenu-toggle bi bi-chevron-down"></i>
                    </a>
                    <ul class="submenu collapse" id="employees-submenu">
                        <li>
                            <a href="{{ route('employees.index') }}" class="nav-link {{ Route::is('employees.index') ? 'active' : '' }}">
                                <span>View Employees</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('employees.create') }}" class="nav-link {{ Route::is('employees.create') ? 'active' : '' }}">
                                <span>Create Employee</span>
                            </a>
                        </li>
                    </ul>
                </li>

                @elseif(auth()->user()->user_type === 'hr')
                <!-- HR Sidebar -->
                <li>
                    <a href="{{ route('hr.dashboard') }}" class="nav-link {{ Route::is('hr.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house-fill"></i>
                        <span>Dashboard (HR)</span>
                    </a>
                </li>

                <!-- Leave Management -->
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#leaves-submenu">
                        <i class="bi bi-calendar-check"></i>
                        <span>Leave Management</span>
                        <i class="submenu-toggle bi bi-chevron-down"></i>
                    </a>
                    <ul class="submenu collapse" id="leaves-submenu">
                        <li>
                            <a href="{{ route('hr.leaves.index') }}" class="nav-link {{ Route::is('hr.leaves.index') ? 'active' : '' }}">
                                <span>All Leaves</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('hr.leaves.create') }}" class="nav-link {{ Route::is('hr.leaves.create') ? 'active' : '' }}">
                                <span>Request Leave</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Employee Management -->
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#employees-hr-submenu">
                        <i class="bi bi-person-workspace"></i>
                        <span>Employee Management</span>
                        <i class="submenu-toggle bi bi-chevron-down"></i>
                    </a>
                    <ul class="submenu collapse" id="employees-hr-submenu">
                        <li>
                            <a href="{{ route('hr.employees.index') }}" class="nav-link {{ Route::is('hr.employees.index') ? 'active' : '' }}">
                                <span>View Employees</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('hr.employees.create') }}" class="nav-link {{ Route::is('hr.employees.create') ? 'active' : '' }}">
                                <span>Create Employee</span>
                            </a>
                        </li>
                    </ul>
                </li>

                @else
                <!-- Employee Sidebar -->
                <li>
                    <a href="{{ route('employee.dashboard') }}" class="nav-link {{ Route::is('employee.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house-fill"></i>
                        <span>Dashboard (Employee)</span>
                    </a>
                </li>

                <!-- Leave Management -->
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#leaves-employee-submenu">
                        <i class="bi bi-calendar-check"></i>
                        <span>Leave Management</span>
                        <i class="submenu-toggle bi bi-chevron-down"></i>
                    </a>
                    <ul class="submenu collapse" id="leaves-employee-submenu">
                        <li>
                            <a href="{{ route('employee.leaves.index') }}" class="nav-link {{ Route::is('employee.leaves.index') ? 'active' : '' }}">
                                <span>My Leaves</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('employee.leaves.create') }}" class="nav-link {{ Route::is('employee.leaves.create') ? 'active' : '' }}">
                                <span>Request Leave</span>
                            </a>
                        </li>
                    </ul>
                </li>

                @if(auth()->user()->employee)
                <li>
                    <a href="{{ route('employee.profile.show', auth()->user()->employee) }}" class="nav-link {{ Route::is('employee.profile.show') ? 'active' : '' }}">
                        <i class="bi bi-person-fill"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                @endif
                @endif
                @endauth
            </ul>

            <div class="sidebar-divider"></div>

            @auth
            <div class="user-profile">
                <div class="dropdown">
                    <div class="user-dropdown" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="user-name">{{ Auth::user()->name }}</span>
                    </div>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.show') }}">
                                <i class="bi bi-person-circle"></i>
                                <span>My Account</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            @else
            <div class="d-flex flex-column gap-2 p-3">
                <a href="{{ route('login') }}" class="nav-link">
                    <i class="bi bi-key-fill"></i>
                    <span>Login</span>
                </a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="nav-link">
                    <i class="bi bi-person-plus-fill"></i>
                    <span>Register</span>
                </a>
                @endif
            </div>
            @endauth
        </div>

        <!-- Content -->
        <div class="content flex-grow-1 p-4">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Submenu Toggle Script -->
    <script>
        function toggleSubmenu(menuId) {
            const menu = document.getElementById(menuId);
            const toggleIcon = document.querySelector(`#${menuId} + .submenu-toggle`);

            menu.classList.toggle('show');
            toggleIcon.classList.toggle('rotate-180');
        }

        // Initialize any active menus
        document.addEventListener('DOMContentLoaded', function() {
            const currentRoute = window.location.pathname;

            // Find all submenu links
            document.querySelectorAll('.submenu .nav-link').forEach(link => {
                const linkPath = link.getAttribute('href');
                if (linkPath && currentRoute.startsWith(linkPath)) {
                    // Find and open the parent submenu
                    const parentMenu = link.closest('.submenu');
                    if (parentMenu) {
                        parentMenu.classList.add('show');
                        // Rotate the toggle icon
                        parentMenu.previousElementSibling.querySelector('.submenu-toggle').classList.add('rotate-180');
                    }
                }
            });
        });
    </script>
</body>

</html>