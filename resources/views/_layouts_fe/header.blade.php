<header id="header" class="header d-flex align-items-center fixed-top">
    <div
        class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto me-xl-0">
            <img src="{{ url('mine/img/logo_tanpa_text_png.png') }}" alt="">
            <h1 class="sitename">Sehati</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('home') }}" class="{{ Route::is('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('siswa.konseling') }}"
                        class="{{ Route::is('siswa.konseling') ? 'active' : '' }}">Konseling</a></li>
                <li><a href="{{ route('siswa.artikel') }}"
                        class="{{ Route::is('siswa.artikel') ? 'active' : '' }}">Artikel</a></li>

            </ul>
        </nav>
        @auth
            @php
                $nama = Auth::user()->name;
                $getFirstName = explode(' ', $nama);
            @endphp
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ $getFirstName[0] }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">Profile</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger fw-bold">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="btn btn-primary ms-3 px-4 rounded-5">Login</a>
        @endguest
    </div>
</header>
