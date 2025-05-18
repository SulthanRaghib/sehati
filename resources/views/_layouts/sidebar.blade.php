<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header" style="color: #156796">
            <img src="{{ url('mine/img/logo_tanpa_text_png.png') }}" alt="" srcset="" width="30%" />Sehati
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Main Menu</li>

                <li class="sidebar-item {{ Route::is('admin.dashboard*') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                        <i data-feather="home" width="20"></i>
                        <span style="color: black; font-weight:500">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">Bimbingan Konseling</li>
                <li class="sidebar-item {{ Route::is('admin.konseling*') ? 'active' : '' }}">
                    <a href="{{ route('admin.konseling') }}" class="sidebar-link" onclick="markAsRead()">
                        <i data-feather="message-square" width="20"></i>
                        <span style="color: black; font-weight:500">Konseling Masuk</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('konseling.riwayat*') ? 'active' : '' }}">
                    <a href="{{ route('konseling.riwayat') }}" class="sidebar-link">
                        <i data-feather="book-open" width="20"></i>
                        <span style="color: black; font-weight:500">Riwayat Konseling</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('artikel*') ? 'active' : '' }}">
                    <a href="{{ route('artikel') }}" class="sidebar-link">
                        <i data-feather="file-text" width="20"></i>
                        <span style="color: black; font-weight:500">Artikel</span>
                    </a>
                </li>

                <li class="sidebar-title">Data Sekolah</li>
                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'developer')
                    <li class="sidebar-item {{ Route::is('admin.guru*') ? 'active' : '' }}">
                        <a href="{{ route('admin.guru') }}" class="sidebar-link">
                            <i data-feather="user" width="20"></i>
                            <span style="color: black; font-weight:500">Guru</span>
                        </a>
                    </li>
                @endif

                <li class="sidebar-item {{ Route::is('admin.siswa*') ? 'active' : '' }}">
                    <a href="{{ route('admin.siswa') }}" class="sidebar-link">
                        <i data-feather="user" width="20"></i>
                        <span style="color: black; font-weight:500">Siswa</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::is('admin.tahunAkademik*') ? 'active' : '' }}">
                    <a href="{{ route('admin.tahunAkademik') }}" class="sidebar-link">
                        <i data-feather="calendar" width="20"></i>
                        <span style="color: black; font-weight:500">Tahun Akademik</span>
                    </a>
                </li>

                <li class="sidebar-title">All Data</li>

                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'developer')
                    <li class="sidebar-item {{ Route::is('admin.kelas*') ? 'active' : '' }}">
                        <a href="{{ route('admin.kelas') }}" class="sidebar-link">
                            <i data-feather="layout" width="20"></i>
                            <span style="color: black; font-weight:500">Kelas</span>
                        </a>
                    </li>
                @endif

                <li class="sidebar-item {{ Route::is('admin.users') ? 'active' : '' }}">
                    <a href="{{ route('admin.users') }}" class="sidebar-link">
                        <i data-feather="user" width="20"></i>
                        <span style="color: black; font-weight:500">User</span>
                    </a>
                </li>

                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'developer')
                    <li class="sidebar-item has-sub {{ Route::is('admin.*') || Route::is('guru.*') ? 'active' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i data-feather="layers" width="20"></i>
                            <span style="color: black; font-weight:500">Data Master</span>
                        </a>

                        @php
                            $activeDataMaster =
                                Route::is('admin.agama*') ||
                                Route::is('admin.pendidikanTerakhir*') ||
                                Route::is('admin.pekerjaan*') ||
                                Route::is('admin.artikelKategori*') ||
                                Route::is('admin.kategoriKonseling*');
                        @endphp

                        <ul class="submenu {{ $activeDataMaster ? 'active' : '' }}">
                            <li>
                                <a href="{{ route('admin.kategoriKonseling') }}">Kategori Konseling</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.artikelKategori') }}">Kategori Artikel</a>
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

@push('scripts')
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
@endpush
