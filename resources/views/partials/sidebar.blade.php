<!-- sidebar for desktop start -->
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
                    <a href="{{route('superAdmin.dashboard')}}" class="d-flex align-items-center gap-3">
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
    @if (auth()->user()->role == 3)
    <ul class="d-flex flex-column gap-3">
        <p class="admin-title mt-3">Task Management</p>
        <li>
            <div class="dashboard-sidebar-option">
                <a href="{{ route('my.tasks') }}"
                    class="d-flex align-items-center gap-3 p-3 rounded-lg hover:bg-primary-100 transition-all">
                    <i class="fas fa-tasks text-primary text-2xl"></i> <!-- Updated icon -->
                    <span class="text-lg font-medium">My Tasks</span>
                </a>
                <div class="sidebar-vertical-line"></div>
            </div>
        </li>
    </ul>
@endif
        <ul class="d-flex flex-column gap-1">

            <p class="admin-title mt-3">Account</p>
            <li>
                <div class="dashboard-sidebar-option position-relative">
                    <a href="{{ route('profile.edit') }}"
                        class="border-0 bg-transparent d-flex align-items-center gap-3">
                        <div class="fs-5 text-white">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <span>My Profile</span>
                    </a>
                    <div class="sidebar-vertical-line"></div>
                </div>
            </li>
            <li>
                <div class="dashboard-sidebar-option">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="border-0 bg-transparent d-flex align-items-center gap-3">
                            <img src="{{ asset('assets/icon/logout.svg') }}" alt="logout" />
                            <span>Logout</span>
                        </button>
                    </form>
                    <div class="sidebar-vertical-line"></div>
                </div>
                {{-- <div class="dashboard-sidebar-option">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
                </div> --}}
            </li>
        </ul>
    </nav>
</aside>
