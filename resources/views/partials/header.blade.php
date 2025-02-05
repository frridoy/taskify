<nav class="shadow py-2 px-5 header-navs">
    <ul class="main-navbar">
        <li class="me-auto">
            <div class="search-btn d-lg-none">
                <button class="py-1 fs-6" type="button" id="openSidebar">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </li>
        {{-- <li>
            <div class="position-relative">
                <a href="/">
                    <img src="{{ asset('assets/icon/notification.svg') }}" alt="notification" class="main-nav-icon" />
                </a>
                <div class="notification-badge"></div>
            </div>
        </li> --}}


            <div class="text-center">
                {{ \Carbon\Carbon::now()->format('d M, Y \a\t h:i A') }}
            </div>

        <li>
            <div>
                <div class="d-flex align-items-center gap-2 main-navbar-profile">
                    <p class="d-flex gap-1 flex-column align-items-center">
                        <span class="small-text-12">Hello!
                            <a href="{{ route('profile.edit') }}" class="fw-semibold navbar-user-name">
                                {{ Auth::user()->name }}
                            </a>
                        </span>
                    </p>
                    <a href="{{ route('profile.edit') }}">
                        <img src="{{ Auth::user()->profile_photo ? Storage::url(Auth::user()->profile_photo) : asset('assets/icon/user-avatar.svg') }}"
                             alt="avatar" class="main-nav-avatar" />
                    </a>
                </div>
            </div>
        </li>
    </ul>
</nav>
