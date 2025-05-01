<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center"
        style="justify-content: space-between">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto me-xl-0 text-decoration-none">
            <img src="{{ url('mine/img/logo_tanpa_text_png.png') }}" alt="">
            <h1 class="sitename">Sehati</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('home') }}"
                        class="{{ Route::is('home') ? 'active fw-bold' : '' }} text-decoration-none">Home</a></li>
                <li><a href="{{ route('siswa.konseling') }}"
                        class="{{ Route::is('siswa.konseling') ? 'active fw-bold' : '' }} text-decoration-none">Konseling</a>
                </li>
                <li><a href="{{ route('siswa.artikel') }}"
                        class="{{ Route::is('siswa.artikel') ? 'active fw-bold' : '' }} text-decoration-none">Artikel</a>
                </li>
            </ul>

            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <div class="d-flex align-items-center gap-2">
            @auth
                {{-- Notifikasi --}}
                <div class="dropdown">
                    <button class="btn btn-primary position-relative" type="button" id="notifDropdownToggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            id="notif-badge">
                            0
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-large" aria-labelledby="notifDropdownToggle"
                        id="notifDropdownMenu" style="width: 200px;">
                        <ul class="list-group rounded-0" id="notif-list">
                            <!-- Notifikasi akan muncul di sini -->
                        </ul>
                    </div>
                </div>

                {{-- User Dropdown --}}
                <div class="dropdown">
                    @php
                        $nama = Auth::user()->name;
                        $getFirstName = explode(' ', $nama);
                    @endphp
                    <a class="btn btn-getstarted dropdown-toggle fs-6 ms-0" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $getFirstName[0] }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('siswa.profile.show') }}">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger fw-bold">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="btn-getstarted fs-6 text-decoration-none ms-0">Login</a>
            @endguest
        </div>

    </div>
</header>

{{-- <header id="header" class="header d-flex align-items-center fixed-top">
    <div
        class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto me-xl-0 text-decoration-none">
            <img src="{{ url('mine/img/logo_tanpa_text_png.png') }}" alt="">
            <h1 class="sitename">Sehati</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('home') }}"
                        class="{{ Route::is('home') ? 'active fw-bold' : '' }} text-decoration-none">Home</a></li>
                <li><a href="{{ route('siswa.konseling') }}"
                        class="{{ Route::is('siswa.konseling') ? 'active fw-bold' : '' }} text-decoration-none">Konseling</a>
                </li>
                <li><a href="{{ route('siswa.artikel') }}"
                        class="{{ Route::is('siswa.artikel') ? 'active fw-bold' : '' }} text-decoration-none">Artikel</a>
                </li>
            </ul>

            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        @auth
            <div class="toggle-laknat">
                @php
                    $nama = Auth::user()->name;
                    $getFirstName = explode(' ', $nama);
                @endphp
                <div class="dropdown">
                    <a class="btn btn-getstarted dropdown-toggle fs-6 ms-0" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $getFirstName[0] }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger fw-bold">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="btn-getstarted fs-6 text-decoration-none ms-0">Login</a>
        @endguest

    </div>
</header> --}}
