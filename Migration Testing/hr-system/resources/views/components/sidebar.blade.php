<!-- resources/views/components/sidebar.blade.php -->
<div class="sidebar" id="sidebar">
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
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('employees.index') }}" class="nav-link {{ Route::is('employees.*') ? 'active' : '' }}">
                <i class="bi bi-person-workspace"></i>
                <span>Employees</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('departments.index') }}" class="nav-link {{ Route::is('departments.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Departments</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('designations.index') }}" class="nav-link {{ Route::is('designations.*') ? 'active' : '' }}">
                <i class="bi bi-briefcase-fill"></i>
                <span>Designations</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('leave_types.index') }}" class="nav-link {{ Route::is('leave_types.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                <span>Leave Types</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('bonus_types.index') }}" class="nav-link {{ Route::is('bonus_types.*') ? 'active' : '' }}">
                <i class="bi bi-currency-dollar"></i>
                <span>Bonus Types</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('deduction_types.index') }}" class="nav-link {{ Route::is('deduction_types.*') ? 'active' : '' }}">
                <i class="bi bi-calculator"></i>
                <span>Deduction Types</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('payrolls.index') }}" class="nav-link {{ Route::is('payrolls.*') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i>
                <span>Payrolls</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('training_programs.index') }}" class="nav-link {{ Route::is('training_programs.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i>
                <span>Training Programs</span>
            </a>
        </li>
        @elseif(auth()->user()->user_type === 'hr')
        <!-- HR Sidebar -->
        <li class="nav-item">
            <a href="{{ route('hr.dashboard') }}" class="nav-link {{ Route::is('hr.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('hr.employees.index') }}" class="nav-link {{ Route::is('hr.employees.*') ? 'active' : '' }}">
                <i class="bi bi-person-workspace"></i>
                <span>Employees</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('hr.leaves.index') }}" class="nav-link {{ Route::is('hr.leaves.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                <span>Leaves</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('hr.payrolls.index') }}" class="nav-link {{ Route::is('hr.payrolls.*') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i>
                <span>Payrolls</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('hr.training_assignments.index') }}" class="nav-link {{ Route::is('hr.training_assignments.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i>
                <span>Training Assignments</span>
            </a>
        </li>
        @else
        <!-- Employee Sidebar -->
        <li class="nav-item">
            <a href="{{ route('employee.dashboard') }}" class="nav-link {{ Route::is('employee.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>
        @if(auth()->user()->employee)
        <li class="nav-item">
            <a href="{{ route('employee.profile.show') }}" class="nav-link {{ Route::is('employee.profile.show') ? 'active' : '' }}">
                <i class="bi bi-person-fill"></i>
                <span>My Profile</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('employee.leaves.index') }}" class="nav-link {{ Route::is('employee.leaves.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                <span>Leaves</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('employee.payrolls.index') }}" class="nav-link {{ Route::is('employee.payrolls.*') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i>
                <span>Payrolls</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('employee.training_assignments.index') }}" class="nav-link {{ Route::is('employee.training_assignments.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i>
                <span>Training Assignments</span>
            </a>
        </li>
        @endif
        @endif
        @endauth
    </ul>

    <div class="sidebar-divider"></div>

    @auth
    <ul class="nav">
        <li class="nav-item">
            <a href="{{ route('profile.show') }}" class="nav-link {{ Route::is('profile.show') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>{{ Auth::user()->name }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
    @else
    <ul class="nav">
        <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link">
                <i class="bi bi-key-fill"></i>
                <span>Login</span>
            </a>
        </li>
        @if (Route::has('register'))
        <li class="nav-item">
            <a href="{{ route('register') }}" class="nav-link">
                <i class="bi bi-person-plus-fill"></i>
                <span>Register</span>
            </a>
        </li>
        @endif
    </ul>
    @endauth
</div>