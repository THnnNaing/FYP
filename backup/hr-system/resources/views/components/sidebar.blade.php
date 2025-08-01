<!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->
<div class="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-brand">
            <i class="sidebar-brand-icon">👥</i>
            <span>{{ config('app.name', 'HR System') }}</span>
        </a>
    </div>

    <ul class="nav">
        @auth
        @if(auth()->user()->user_type === 'admin')
        <!-- Admin Sidebar -->
        <li>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <i>📊</i>
                <span>Dashboard (Admin)</span>
            </a>
        </li>

        <!-- Designation Management -->
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link">
                <i>🏷️</i>
                <span>Designation Management</span>
                <i class="submenu-toggle">▼</i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="{{ route('designations.index') }}" class="nav-link {{ Route::is('designations.index') ? 'active' : '' }}">
                        <span>View Designations</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('designations.create') }}" class="nav-link {{ Route::is('designations.create') ? 'active' : '' }}">
                        <span>Create Designations</span>
                    </a>
                </li>

            </ul>
        </li>

        <!-- Department Management -->
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link">
                <i>🏢</i>
                <span>Department Management</span>
                <i class="submenu-toggle">▼</i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="{{ route('departments.index') }}" class="nav-link {{ Route::is('departments.index') ? 'active' : '' }}">
                        <span>View Departments</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('departments.create') }}" class="nav-link {{ Route::is('departments.create') ? 'active' : '' }}">
                        <span>Create Departments</span>
                    </a>
                </li>

            </ul>
        </li>

        <!-- Employee Management -->
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link">
                <i>👨‍💼</i>
                <span>Employee Management</span>
                <i class="submenu-toggle">▼</i>
            </a>
            <ul class="submenu">
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
                <i>📊</i>
                <span>Dashboard (HR)</span>
            </a>
        </li>

        <!-- Employee Management -->
        <li class="nav-item has-submenu">
            <a href="#" class="nav-link">
                <i>👨‍💼</i>
                <span>Employee Management</span>
                <i class="submenu-toggle">▼</i>
            </a>
            <ul class="submenu">
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

        @else
        <!-- Employee Sidebar -->
        <li>
            <a href="{{ route('employee.dashboard') }}" class="nav-link {{ Route::is('employee.dashboard') ? 'active' : '' }}">
                <i>📊</i>
                <span>Dashboard</span>
            </a>
        </li>

        @if(auth()->user()->employee)
        <li>
            <a href="{{ route('employees.show', auth()->user()->employee) }}" class="nav-link {{ Route::is('employees.show') ? 'active' : '' }}">
                <i>👤</i>
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
                        <i>👤</i>
                        <span>My Account</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i>🚪</i>
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
    <div class="d-flex flex-column gap-2">
        <a href="{{ route('login') }}" class="nav-link">
            <i>🔑</i>
            <span>Login</span>
        </a>
        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="nav-link">
            <i>👤</i>
            <span>Register</span>
        </a>
        @endif
    </div>
    @endauth
</div>