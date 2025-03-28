<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <img src="{{ url('mine/img/logo_tanpa_text_png.png') }}" alt="" srcset="" width="30%" />Sehati
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Main Menu</li>

                <li class="sidebar-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                        <i data-feather="home" width="20"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">All Data</li>
                <li class="sidebar-item {{ Route::is('admin.users') ? 'active' : '' }}">
                    <a href="{{ route('admin.users') }}" class="sidebar-link">
                        <i data-feather="user" width="20"></i>
                        <span>User</span>
                    </a>
                </li>
                @if (Auth::user()->role == 'admin')
                    <li class="sidebar-item {{ Route::is('admin.guru') ? 'active' : '' }}">
                        <a href="{{ route('admin.guru') }}" class="sidebar-link">
                            <i data-feather="user" width="20"></i>
                            <span>Guru</span>
                        </a>
                    </li>
                @endif

                <li class="sidebar-item {{ Route::is('admin.siswa') ? 'active' : '' }}">
                    <a href="{{ route('admin.siswa') }}" class="sidebar-link">
                        <i data-feather="user" width="20"></i>
                        <span>Siswa</span>
                    </a>
                </li>
                @if (Auth::user()->role == 'admin')
                    <li class="sidebar-item has-sub {{ Route::is('admin.*') || Route::is('guru.*') ? 'active' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i data-feather="layers" width="20"></i>
                            <span>Data Master</span>
                        </a>

                        @php
                            $activeDataMaster =
                                Route::is('admin.agama') ||
                                Route::is('admin.kelas') ||
                                Route::is('admin.pendidikanTerakhir') ||
                                Route::is('admin.pekerjaan');
                        @endphp

                        <ul class="submenu {{ $activeDataMaster ? 'active' : '' }}">
                            <li>
                                <a href="{{ route('admin.kelas') }}">Kelas</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.agama') }}">Agama</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.pekerjaan') }}">Pekerjaan</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.pendidikanTerakhir') }}">Pendidikan Terakhir</a>
                            </li>
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
        <button class="sidebar-toggler btn x">
            <i data-feather="x"></i>
        </button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let currentUrl = window.location.href;

        document.querySelectorAll(".sidebar-item.has-sub").forEach(function(item) {
            let submenuLinks = item.querySelectorAll(".submenu a");
            let isActive = false;

            submenuLinks.forEach(function(link) {
                if (link.href === currentUrl) {
                    isActive = true;
                    link.classList.add("active");
                }
            });

            if (isActive) {
                item.classList.add("active");
            } else {
                item.classList.remove("active"); // Hapus active jika bukan halaman dropdown
            }
        });
    });
</script>
