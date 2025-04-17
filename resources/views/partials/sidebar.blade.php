{{-- <!-- sidebar for desktop start -->
<aside class="dashboard-sidebar-bg sidebar-closed">
    <nav class="dashboard-sidebar">
        <div class="d-lg-none d-flex justify-content-end close-btn">
            <button class="bg-transparent border-0 text-white me-3" id="closeSidebar">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="logo-sidebar-contnet d-flex align-items-center justify-content-center gap-3 ml-03x">
            <div class="mb-5" style="padding: 5px">

                <h1 class="text-white fw-bold" style="font-size: 24px;">
                    Taskify&nbsp;<span class="logo-text">Management</span>
                </h1>
            </div>

        </div>

        <ul class="d-flex flex-column gap-1">
            <p class="admin-title">Dashboard</p>
            <li>
                <div class="dashboard-sidebar-option">
                    <a href="{{ route('superAdmin.dashboard') }}" class="d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/icon/dashboards.png') }}" alt="dashboard" />
                        <span>Dashboard</span>
                    </a>
                    <div class="sidebar-vertical-line"></div>
                </div>
            </li>
        </ul>

        @if (auth()->user()->role == 1 || auth()->user()->role == 2)
            <ul class="d-flex flex-column gap-3">
                <p class="admin-title mt-3">User Management</p>
                <li>
                    <div class="dashboard-sidebar-option">
                        <a href="{{ route('users.index') }}"
                            class="d-flex align-items-center gap-3 p-3 rounded-lg hover:bg-primary-100 transition-all">
                            <i class="fas fa-building text-primary text-2xl"></i>
                            <span class="text-lg font-medium">User List</span>
                        </a>
                        <div class="sidebar-vertical-line"></div>
                    </div>

                </li>
            </ul>
        @endif
        @if (auth()->user()->role == 1 || auth()->user()->role == 2)
            <ul class="d-flex flex-column gap-3">
                <p class="admin-title mt-3">Task Management</p>
                <li>
                    <div class="dashboard-sidebar-option">
                        <a href="{{ route('tasks.index') }}"
                            class="d-flex align-items-center gap-3 p-3 rounded-lg hover:bg-primary-100 transition-all">
                            <i class="fas fa-tasks text-primary text-2xl"></i> <!-- Updated icon -->
                            <span class="text-lg font-medium">Task List</span>
                        </a>
                        <div class="sidebar-vertical-line"></div>
                    </div>
                </li>
            </ul>
        @endif
        <ul class="d-flex flex-column gap-3">
            <p class="admin-title mt-3 text-white">Team Management</p>

            <!-- Team Dropdown -->
            <li>
                <div class="dashboard-sidebar-option d-flex align-items-center gap-3 p-3 rounded-lg hover:bg-primary-100 transition-all text-white"
                    data-bs-toggle="collapse" data-bs-target="#teamMenu" aria-expanded="false">
                    <i class="fas fa-users text-blue-500 text-2xl"></i> <!-- Team Icon (Blue) -->
                    <span class="text-lg font-medium">Team</span>
                    <i class="fas fa-chevron-down ml-auto text-white"></i> <!-- Dropdown Indicator (White) -->
                </div>

                <!-- Submenu (Indented) -->
                <ul id="teamMenu" class="collapse pl-6">

                    @if (auth()->user()->role == 1 || auth()->user()->role == 2)
                        <li>
                            <a href="{{ route('team.build') }}"
                                class="d-flex align-items-center gap-3 p-2 rounded-lg hover:bg-primary-200 transition-all text-white">
                                <i class="fas fa-tasks text-blue-500"></i> <!-- Task Icon (Blue) -->
                                <span>Task Build</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('team.index') }}"
                            class="d-flex align-items-center gap-3 p-2 rounded-lg hover:bg-primary-200 transition-all text-white">
                            <i class="fas fa-users text-blue-500"></i> <!-- Team List Icon (Blue) -->
                            <span>Team List</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        @if (auth()->user()->role == 3)
            <ul class="d-flex flex-column gap-3">
                <p class="admin-title mt-3">Task Management</p>
                <li>
                    <div class="dashboard-sidebar-option">
                        <a href="{{ route('my.tasks') }}"
                            class="d-flex align-items-center gap-3 p-3 rounded-lg hover:bg-primary-100 transition-all">
                            <i class="fas fa-tasks text-primary text-2xl"></i> <!-- Updated icon -->
                            <span class="text-lg font-medium">ALl Tasks</span>
                        </a>
                        <div class="sidebar-vertical-line"></div>
                    </div>
                    <div class="dashboard-sidebar-option">
                        <a href="{{ route('pending_tasks') }}"
                            class="d-flex align-items-center gap-3 p-3 rounded-lg hover:bg-primary-100 transition-all">
                            <i class="fas fa-tasks text-primary text-2xl"></i> <!-- Updated icon -->
                            <span class="text-lg font-medium">Pending Tasks</span>
                        </a>
                        <div class="sidebar-vertical-line"></div>
                    </div>
                    <div class="dashboard-sidebar-option">
                        <a href="{{ route('processing_tasks') }}"
                            class="d-flex align-items-center gap-3 p-3 rounded-lg hover:bg-primary-100 transition-all">
                            <i class="fas fa-tasks text-primary text-2xl"></i> <!-- Updated icon -->
                            <span class="text-lg font-medium">Processing Tasks</span>
                        </a>
                        <div class="sidebar-vertical-line"></div>
                    </div>
                    <div class="dashboard-sidebar-option">
                        <a href="{{ route('completed_tasks') }}"
                            class="d-flex align-items-center gap-3 p-3 rounded-lg hover:bg-primary-100 transition-all">
                            <i class="fas fa-tasks text-primary text-2xl"></i> <!-- Updated icon -->
                            <span class="text-lg font-medium">Completed Tasks</span>
                        </a>
                        <div class="sidebar-vertical-line"></div>
                    </div>
                </li>
            </ul>
        @endif
        @if (auth()->user()->role == 2 || auth()->user()->role == 1)
        <ul class="d-flex flex-column gap-3">
            <p class="admin-title mt-3">Setting</p>
            <li>
                    <div class="dashboard-sidebar-option">
                        <a href="{{ route('office_info_setup.index') }}"
                            class="d-flex align-items-center gap-3 p-3 rounded-lg hover:bg-primary-100 transition-all">
                            <i class="fas fa-tasks text-primary text-2xl"></i>
                            <span class="text-lg font-medium">List</span>
                        </a>
                        <div class="sidebar-vertical-line"></div>
                    </div>
                @php
                $officeInfoExists = \App\Models\Setting::first();
                @endphp
                @if (!$officeInfoExists)
                    <div class="dashboard-sidebar-option">
                        <a href="{{ route('office_info_setup.form') }}"
                            class="d-flex align-items-center gap-3 p-3 rounded-lg hover:bg-primary-100 transition-all">
                            <i class="fas fa-tasks text-primary text-2xl"></i>
                            <span class="text-lg font-medium">Form</span>
                        </a>
                        <div class="sidebar-vertical-line"></div>
                    </div>
                @endif
            </li>
        </ul>
    @endif

    <ul class="d-flex flex-column gap-3">
        <p class="admin-title mt-3">Attendance</p>
        <li>
                <div class="dashboard-sidebar-option">
                    <a href="{{ route('attendance.list') }}"
                        class="d-flex align-items-center gap-3 p-3 rounded-lg hover:bg-primary-100 transition-all">
                        <i class="fas fa-tasks text-primary text-2xl"></i>
                        <span class="text-lg font-medium">List</span>
                    </a>
                    <div class="sidebar-vertical-line"></div>
                </div>
                <div class="dashboard-sidebar-option">
                    <a href="{{ route('attendance.provide') }}"
                        class="d-flex align-items-center gap-3 p-3 rounded-lg hover:bg-primary-100 transition-all">
                        <i class="fas fa-tasks text-primary text-2xl"></i>
                        <span class="text-lg font-medium">Attendance</span>
                    </a>
                    <div class="sidebar-vertical-line"></div>
                </div>
        </li>
    </ul>

    </nav>
</aside> --}}



<!-- sidebar for desktop start -->
<aside class="dashboard-sidebar-bg sidebar-closed">
    <nav class="dashboard-sidebar">
        <!-- Header with logo -->
        <div class="py-4 px-3 text-center border-bottom border-indigo-800">
            <h1 class="text-white fw-bold mb-0" style="font-size: 24px;">
                Taskify<span style="color: #4AD9E4; font-weight: 300;">Management</span>
            </h1>
            {{-- <div class="mt-1 mb-2">
                <span class="badge bg-indigo-700 text-cyan-300 px-2 py-1 rounded-pill" style="font-size: 10px;">TEAM WORKSPACE</span>
            </div> --}}
        </div>

        <!-- User profile snippet -->
        <div class="d-flex align-items-center px-3 py-3 border-bottom border-indigo-800">
            <div class="rounded-circle bg-cyan-300 text-indigo-900 d-flex align-items-center justify-content-center"
                style="width: 38px; height: 38px; font-weight: bold;">
                {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
            </div>
            <div class="ms-3">
                <div class="text-white" style="font-size: 14px; font-weight: 500;">{{ auth()->user()->name ?? 'User' }}
                </div>
                <div class="text-cyan-200" style="font-size: 12px;">
                    @if (auth()->user()->role == 1)
                        Super Admin
                    @elseif(auth()->user()->role == 2)
                        Admin
                    @else
                        Employee
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Dashboard -->
        <div class="px-3 pt-4">
            <div class="menu-category">
                <div class="d-flex align-items-center mb-3">
                    <div class="menu-category-line me-2"></div>
                    <span class="text-cyan-200 text-uppercase"
                        style="font-size: 12px; letter-spacing: 1px;">Dashboard</span>
                </div>

                <a href="{{ route('superAdmin.dashboard') }}" class="menu-item">
                    <div class="menu-icon">
                        <i class="bi bi-grid-1x2-fill"></i>
                    </div>
                    <span>Overview</span>
                </a>
            </div>

            <!-- Task Management -->
            <div class="menu-category mt-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="menu-category-line me-2"></div>
                    <span class="text-cyan-200 text-uppercase"
                        style="font-size: 12px; letter-spacing: 1px;">Tasks</span>
                </div>

                <div class="menu-item dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#taskMenu">
                    <div class="menu-icon">
                        <i class="bi bi-kanban-fill"></i>
                    </div>
                    <span>Tasks</span>
                    <i class="bi bi-chevron-down ms-auto menu-arrow"></i>
                </div>

                <div id="taskMenu" class="collapse mt-1">
                    @if (auth()->user()->role == 1 || auth()->user()->role == 2)
                        <a href="{{ route('tasks.index') }}" class="submenu-item">
                            <div class="submenu-bullet"></div>
                            <span>All Tasks</span>
                        </a>
                    @endif

                    <a href="{{ route('tasks.assign') }}" class="submenu-item">
                        <div class="submenu-bullet"></div>
                        <span>Tasks Assign</span>
                    </a>

                    @if (auth()->user()->role == 3)
                        <a href="{{ route('my.tasks') }}" class="submenu-item">
                            <div class="submenu-bullet"></div>
                            <span>All Tasks</span>
                        </a>
                        <a href="{{ route('pending_tasks') }}" class="submenu-item">
                            <div class="submenu-bullet"></div>
                            <span>Pending</span>
                        </a>
                        <a href="{{ route('processing_tasks') }}" class="submenu-item">
                            <div class="submenu-bullet"></div>
                            <span>In Progress</span>
                        </a>
                        <a href="{{ route('completed_tasks') }}" class="submenu-item">
                            <div class="submenu-bullet"></div>
                            <span>Completed</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Attendance Management -->
            <div class="menu-category mt-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="menu-category-line me-2"></div>
                    <span class="text-cyan-200 text-uppercase"
                        style="font-size: 12px; letter-spacing: 1px;">Attendance</span>
                </div>

                <div class="menu-item dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#attendanceMenu">
                    <div class="menu-icon">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <span>Attendance</span>
                    <i class="bi bi-chevron-down ms-auto menu-arrow"></i>
                </div>

                <div id="attendanceMenu" class="collapse mt-1">
                    <a href="{{ route('attendance.list') }}" class="submenu-item">
                        <div class="submenu-bullet"></div>
                        <span>Records</span>
                    </a>
                    @if(auth()->user()->role == 2 || auth()->user()->role == 3)
                    <a href="{{ route('attendance.provide') }}" class="submenu-item">
                        <div class="submenu-bullet"></div>
                        <span>Check In/Out</span>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Team Management -->
            <div class="menu-category mt-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="menu-category-line me-2"></div>
                    <span class="text-cyan-200 text-uppercase" style="font-size: 12px; letter-spacing: 1px;">Team</span>
                </div>

                <div class="menu-item dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#teamMenu">
                    <div class="menu-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <span>Teams</span>
                    <i class="bi bi-chevron-down ms-auto menu-arrow"></i>
                </div>

                <div id="teamMenu" class="collapse mt-1">
                    @if (auth()->user()->role == 1 || auth()->user()->role == 2)
                        <a href="{{ route('team.build') }}" class="submenu-item">
                            <div class="submenu-bullet"></div>
                            <span>Team Builder</span>
                        </a>
                    @endif
                    <a href="{{ route('team.index') }}" class="submenu-item">
                        <div class="submenu-bullet"></div>
                        <span>Team Directory</span>
                    </a>
                </div>
            </div>


            <!-- User Management -->
            @if (auth()->user()->role == 1 || auth()->user()->role == 2)

            <div class="menu-category mt-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="menu-category-line me-2"></div>
                    <span class="text-cyan-200 text-uppercase" style="font-size: 12px; letter-spacing: 1px;">User</span>
                </div>

                <div class="menu-item dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#userMenu">
                    <div class="menu-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <span>User</span>
                    <i class="bi bi-chevron-down ms-auto menu-arrow"></i>
                </div>

                <div id="userMenu" class="collapse mt-1">
                    @if (auth()->user()->role == 1)
                        <a href="{{ route('users.create') }}" class="submenu-item">
                            <div class="submenu-bullet"></div>
                            <span>User Create</span>
                        </a>
                        @endif
                    <a href="{{ route('users.index') }}" class="submenu-item">
                        <div class="submenu-bullet"></div>
                        <span>User Directory</span>
                    </a>
                </div>
            </div>

            @endif


            <!-- System Settings -->
            @if (auth()->user()->role == 1)
                <div class="menu-category mt-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="menu-category-line me-2"></div>
                        <span class="text-cyan-200 text-uppercase"
                            style="font-size: 12px; letter-spacing: 1px;">System</span>
                    </div>

                    <a href="{{ route('office_info_setup.index') }}" class="menu-item">
                        <div class="menu-icon">
                            <i class="bi bi-gear-fill"></i>
                        </div>
                        <span>Configuration</span>
                    </a>

                    @php
                        $officeInfoExists = \App\Models\Setting::first();
                    @endphp
                    @if (!$officeInfoExists)
                        <a href="{{ route('office_info_setup.form') }}" class="menu-item">
                            <div class="menu-icon">
                                <i class="bi bi-building-fill"></i>
                            </div>
                            <span>Office Setup</span>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </nav>
</aside>

<style>
    /* Custom styles for the unique sidebar */
    .dashboard-sidebar-bg {
        background: linear-gradient(135deg, #1e1a4f 0%, #2a1e6b 100%);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }

    .menu-category-line {
        width: 18px;
        height: 2px;
        background-color: #4AD9E4;
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 10px 12px;
        margin-bottom: 4px;
        color: #e0e0ff;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 14px;
        font-weight: 500;
    }

    .menu-item:hover {
        background-color: rgba(74, 217, 228, 0.1);
        color: #ffffff;
    }

    .menu-item.active {
        background-color: rgba(74, 217, 228, 0.15);
        color: #4AD9E4;
    }

    .menu-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(74, 217, 228, 0.1);
        border-radius: 8px;
        margin-right: 12px;
        font-size: 16px;
        color: #4AD9E4;
    }

    .menu-arrow {
        font-size: 12px;
        transition: transform 0.2s;
    }

    .dropdown-toggle[aria-expanded="true"] .menu-arrow {
        transform: rotate(180deg);
    }

    .submenu-item {
        display: flex;
        align-items: center;
        padding: 8px 12px 8px 40px;
        color: #b8b8e0;
        text-decoration: none;
        font-size: 13px;
        position: relative;
        transition: all 0.2s ease;
        margin-bottom: 2px;
        border-radius: 6px;
    }

    .submenu-item:hover {
        background-color: rgba(74, 217, 228, 0.08);
        color: #ffffff;
    }

    .submenu-bullet {
        width: 6px;
        height: 6px;
        background-color: #4AD9E4;
        border-radius: 50%;
        margin-right: 10px;
        opacity: 0.6;
    }

    .submenu-item:hover .submenu-bullet {
        opacity: 1;
    }

    /* Add these classes for text colors */
    .text-cyan-200 {
        color: #a5fafd;
    }

    .text-cyan-300 {
        color: #4AD9E4;
    }

    .text-indigo-900 {
        color: #1e1a4f;
    }

    .border-indigo-800 {
        border-color: rgba(93, 93, 255, 0.2) !important;
    }

    .bg-indigo-700 {
        background-color: rgba(93, 93, 255, 0.2);
    }
</style>
