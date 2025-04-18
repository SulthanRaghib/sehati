<nav class="navbar navbar-header navbar-expand navbar-light">
    <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
    <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">
            <li class="dropdown nav-icon">
                <a href="#" id="notifDropdownToggle" class="nav-link dropdown-toggle nav-link-lg nav-link-user"
                    onclick="openNotifDropdown(event)">
                    <div class="bell-notification">
                        <i data-feather="bell" style="width: 28px; height: 28px;"></i>
                        <span class="badge" id="notif-count">0</span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-large" aria-labelledby="notifDropdownToggle"
                    id="notifDropdownMenu">
                    <h6 class="py-2 px-4">Notifications</h6>
                    <ul class="list-group rounded-none" id="notif-list">
                        <!-- Notifikasi akan dimasukkan di sini -->
                    </ul>
                </div>
            </li>
            <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
            @vite('resources/js/app.js')
            <script>
                const notifCount = document.getElementById('notif-count');
                const notifList = document.getElementById('notif-list');

                function fetchNotif() {
                    fetch('/notifikasi/fetch')
                        .then(res => res.json())
                        .then(data => {
                            notifList.innerHTML = '';
                            let unread = 0;
                            const maxDisplay = 3;

                            // Hitung unread
                            data.forEach(notif => {
                                if (!notif.is_read) unread++;
                            });

                            // Hanya tampilkan notifikasi yang belum dibaca
                            const unreadNotifs = data.filter(notif => !notif.is_read);

                            unreadNotifs.slice(0, maxDisplay).forEach(notif => {
                                notifList.innerHTML += `
                                    <li class="list-group-item border-0 align-items-start">
                                        <a href="/konseling" class="d-flex text-dark text-decoration-none">
                                            <div class="avatar bg-success mr-3">
                                                <span class="avatar-content"><i data-feather="bell"></i></span>
                                            </div>
                                            <div>
                                                <h6 class="text-bold mb-1">${notif.title}</h6>
                                                <p class="text-xs mb-0">${notif.body}</p>
                                            </div>
                                        </a>
                                    </li>
                                `;
                            });

                            if (unreadNotifs.length > maxDisplay) {
                                notifList.innerHTML += `
                                    <li class="list-group-item text-center border-top">
                                        <a href="/konseling" class="text-primary font-weight-bold">
                                            Lihat Semua Konseling
                                        </a>
                                    </li>
                                `;
                            }

                            notifCount.textContent = unread;
                            feather.replace();
                        });
                }

                // Inisialisasi pertama
                fetchNotif();

                // Pusher listener
                Pusher.logToConsole = true;
                const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                    cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                    forceTLS: true
                });

                const channel = pusher.subscribe('konseling-baru');
                channel.bind('konseling-baru', function(data) {
                    console.log('Data masuk dari Pusher:', data); // <--- Tambahkan ini
                    fetchNotif(); // Ambil ulang setelah ada notifikasi baru
                });
            </script>

            {{-- Message --}}
            <li class="dropdown nav-icon mr-2">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <div class="d-lg-inline-block">
                        <i data-feather="mail"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                    <a class="dropdown-item active" href="#"><i data-feather="mail"></i>
                        Messages</a>
                    <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i data-feather="log-out"></i> Logout</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <div class="avatar mr-1">
                        <img src="{{ url('_partials/images/avatar/avatar-s-1.png') }}" alt="" srcset="" />
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                    <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i data-feather="log-out"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
