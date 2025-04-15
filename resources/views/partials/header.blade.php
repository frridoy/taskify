<nav class="shadow py-2 px-5 header-navs">
    <ul class="main-navbar d-flex align-items-center list-unstyled mb-0">


        <li class="me-auto d-lg-none">
            <div class="search-btn">
                <button class="py-1 fs-6 btn" type="button" id="openSidebar">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </li>


        <li class="mx-3">
            <div class="position-relative">
                <a href="#" class="text-dark position-relative">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle notification-badge">
                        <span class="visually-hidden">New alerts</span>
                    </span>
                </a>
            </div>
        </li>


        <li class="mx-3">
            <div class="text-center small-text-12">
                {{ \Carbon\Carbon::now()->format('d M, Y \a\t h:i A') }}
            </div>
        </li>

        <li class="dropdown ms-auto">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ Auth::user()->profile_photo ? Storage::url(Auth::user()->profile_photo) : asset('assets/icon/user-avatar.svg') }}"
                         alt="avatar" class="main-nav-avatar rounded-circle" style="width: 40px; height: 40px;" />
                    <span class="small-text-12">
                        Hello! <span class="fw-semibold navbar-user-name">{{ Auth::user()->name }}</span>
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-circle me-2"></i> Update Profile
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>


