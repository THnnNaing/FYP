<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HR System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #007bff;
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

        .submenu-toggle.show {
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
            background-color: #f8f9fa;
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
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#employees-submenu">
                        <i class="bi bi-person-workspace"></i>
                        <span>Employees</span>
                        <i class="submenu-toggle bi bi-chevron-down"></i>
                    </a>
                    <ul class="submenu collapse {{ Route::is('employees.*') ? 'show' : '' }}" id="employees-submenu">
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
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#departments-submenu">
                        <i class="bi bi-building"></i>
                        <span>Departments</span>
                        <i class="submenu-toggle bi bi-chevron-down"></i>
                    </a>
                    <ul class="submenu collapse {{ Route::is('departments.*') ? 'show' : '' }}" id="departments-submenu">
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
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#designations-submenu">
                        <i class="bi bi-briefcase-fill"></i>
                        <span>Designations</span>
                        <i class="submenu-toggle bi bi-chevron-down"></i>
                    </a>
                    <ul class="submenu collapse {{ Route::is('designations.*') ? 'show' : '' }}" id="designations-submenu">
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
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#leave-types-submenu">
                        <i class="bi bi-calendar-check"></i>
                        <span>Leave Types</span>
                        <i class="submenu-toggle bi bi-chevron-down"></i>
                    </a>
                    <ul class="submenu collapse {{ Route::is('leave_types.*') ? 'show' : '' }}" id="leave-types-submenu">
                        <li>
                            <a href="{{ route('leave_types.index') }}" class="nav-link {{ Route::is('leave_types.index') ? 'active' : '' }}">
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
                <li class="nav-item">
                    <a href="{{ route('bonus_types.index') }}" class="nav-link {{ Route::is('bonus_types.*') ? 'active' : '' }}">Bonus Types</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('deduction_types.index') }}" class="nav-link {{ Route::is('deduction_types.*') ? 'active' : '' }}">Deduction Types</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('payrolls.index') }}" class="nav-link {{ Route::is('payrolls.*') ? 'active' : '' }}">Payrolls</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('training_programs.index') }}" class="nav-link {{ Route::is('training_programs.*') ? 'active' : '' }}">Training Programs</a>
                </li>
                @elseif(auth()->user()->user_type === 'hr')
                <!-- HR Sidebar -->
                <li>
                    <a href="{{ route('hr.dashboard') }}" class="nav-link {{ Route::is('hr.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#employees-submenu">
                        <i class="bi bi-person-workspace"></i>
                        <span>Employees</span>
                        <i class="submenu-toggle bi bi-chevron-down"></i>
                    </a>
                    <ul class="submenu collapse {{ Route::is('hr.employees.*') ? 'show' : '' }}" id="employees-submenu">
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
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#leaves-submenu">
                        <i class="bi bi-calendar-check"></i>
                        <span>Leaves</span>
                        <i class="submenu-toggle bi bi-chevron-down"></i>
                    </a>
                    <ul class="submenu collapse {{ Route::is('hr.leaves.*') ? 'show' : '' }}" id="leaves-submenu">
                        <li>
                            <a href="{{ route('hr.leaves.index') }}" class="nav-link {{ Route::is('hr.leaves.index') ? 'active' : '' }}">
                                <span>View Leaves</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('hr.leaves.create') }}" class="nav-link {{ Route::is('hr.leaves.create') ? 'active' : '' }}">
                                <span>Request Leave</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hr.payrolls.index') }}" class="nav-link {{ Route::is('hr.payrolls.*') ? 'active' : '' }}">Payrolls</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hr.training_assignments.index') }}" class="nav-link {{ Route::is('hr.training_assignments.*') ? 'active' : '' }}">Training Assignments</a>
                </li>
                @else
                <!-- Employee Sidebar -->
                <li>
                    <a href="{{ route('employee.dashboard') }}" class="nav-link {{ Route::is('employee.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if(auth()->user()->employee)
                <li>
                    <a href="{{ route('employee.profile.show', auth()->user()->employee) }}" class="nav-link {{ Route::is('employee.profile.show') ? 'active' : '' }}">
                        <i class="bi bi-person-fill"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li class="nav-item has-submenu">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#leaves-submenu">
                        <i class="bi bi-calendar-check"></i>
                        <span>Leaves</span>
                        <i class="submenu-toggle bi bi-chevron-down"></i>
                    </a>
                    <ul class="submenu collapse {{ Route::is('employee.leaves.*') ? 'show' : '' }}" id="leaves-submenu">
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
                    <li class="nav-item">
                            <a href="{{ route('employee.training_assignments.index') }}" class="nav-link {{ Route::is('employee.training_assignments.*') ? 'active' : '' }}">Training Assignments</a>
                        </li>
                </li>
                <li class="nav-item">
                    <a href="{{ route('employee.payrolls.index') }}" class="nav-link {{ Route::is('employee.payrolls.*') ? 'active' : '' }}">Payrolls</a>
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
            <!-- @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif -->
            <!-- @yield('content') -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle submenu toggle
            document.querySelectorAll('.nav-link[data-bs-toggle="collapse"]').forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('data-bs-target').substring(1);
                    const submenu = document.getElementById(targetId);
                    const icon = this.querySelector('.submenu-toggle');
                    submenu.classList.toggle('show');
                    icon.classList.toggle('show');
                });
            });
        });
    </script>
</body>

</html>