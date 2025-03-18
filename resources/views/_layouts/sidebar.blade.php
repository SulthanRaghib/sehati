<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <img src="{{ url('mine/img/logo_tanpa_text_png.png') }}" alt="" srcset="" width="30%" />Sehati
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Main Menu</li>
                @if (Auth::user()->role == 'admin')
                    <li class="sidebar-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                            <i data-feather="home" width="20"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                @elseif (Auth::user()->role == 'gurubk')
                    <li class="sidebar-item {{ Route::is('guru.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('guru.dashboard') }}" class="sidebar-link">
                            <i data-feather="home" width="20"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                @endif

                <li class="sidebar-title">All Data</li>
                <li class="sidebar-item has-sub {{ Route::is('admin.*') || Route::is('guru.*') ? 'active' : '' }}">
                    <a href="#" class="sidebar-link">
                        <i data-feather="layers" width="20"></i>
                        <span>Data Master</span>
                    </a>

                    <ul class="submenu {{ Route::is('admin.users') || Route::is('admin.guru') ? 'active' : '' }}">
                        <li>
                            <a href="{{ route('admin.users') }}">Users</a>
                        </li>

                        <li>
                            <a href="{{ route('admin.guru') }}">Guru</a>
                        </li>

                    </ul>
                </li>
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
