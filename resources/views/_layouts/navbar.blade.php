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
                    <h6 class="py-2 px-4" id="notif-header">Konseling Belum Dijawab</h6>
                    <ul class="list-group rounded-none" id="notif-list">
                        <!-- Notifikasi akan dimasukkan di sini -->
                    </ul>
                </div>
            </li>
            @push('scripts')
                <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
                <script>
                    const notifCount = document.getElementById('notif-count');
                    const notifList = document.getElementById('notif-list');
                    const notifHeader = document.getElementById('notif-header');

                    function fetchNotif() {
                        fetch('/notifikasi/fetch/konseling')
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

                                // Update header sesuai kondisi
                                if (unread === 0) {
                                    notifHeader.textContent = 'Konseling Sudah Dijawab Semua';
                                } else {
                                    notifHeader.textContent = 'Konseling Belum Dijawab';
                                }

                                // Tampilkan notifikasi (max 3)
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

                                // Tombol "Lihat Semua"
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

                    // Pusher setup
                    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                        forceTLS: true
                    });

                    // Subscribe ke channel konseling baru
                    const channelKonselingBaru = pusher.subscribe('konseling-baru');
                    channelKonselingBaru.bind('konseling-baru', function(data) {
                        console.log('✅ Dapat data dari Pusher (konseling baru):', data);
                        fetchNotif();
                    });

                    // Subscribe ke channel jawaban konseling
                    const channelJawabanKonseling = pusher.subscribe('jawaban-konseling');
                    channelJawabanKonseling.bind('jawaban-konseling', function(data) {
                        console.log('✅ Dapat data dari Pusher (jawaban konseling):', data);
                        fetchNotif();
                    });
                </script>
            @endpush

            <li class="dropdown">
                @php
                    $name = Auth::user()->name;
                    $words = explode(' ', $name);
                    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                @endphp
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px; font-weight: bold;">
                        {{ $initials }}
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    {{-- <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                    <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a> --}}
                    {{-- <div class="dropdown-divider"></div> --}}
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
