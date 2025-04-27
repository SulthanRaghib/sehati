<!-- Favicons -->
<link href="{{ url('mine/img/logo_tanpa_text_png.png') }}" rel="icon" />
<link href="{{ url('mine/img/logo_tanpa_text_png.png') }}" rel="apple-touch-icon" />

<!-- Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect" />
<link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />

<!-- Vendor CSS Files -->
<link href="{{ url('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ url('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
<link href="{{ url('assets/vendor/aos/aos.css') }}" rel="stylesheet" />
<link href="{{ url('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet" />
<link href="{{ url('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet" />

<!-- Main CSS File -->
<link href="{{ url('assets/css/main.css') }}" rel="stylesheet" />
<style>
    .mobile-nav-toggle {
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    body.mobile-nav-active .navmenu {
        right: 0;
        opacity: 1;
    }

    /* Dropdown otomatis terbuka saat hover */
    .dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
        /* supaya dropdown langsung nempel */
    }

    /* Sedikit transisi supaya lebih halus */
    .dropdown-menu {
        transition: all 0.3s ease;
    }
</style>

<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
@vite('resources/js/app.js')
<script>
    Pusher.logToConsole = true;

    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true
    });

    const channel = pusher.subscribe('konseling-baru');
    channel.bind('konseling-baru', function(data) {
        console.log('✅ Dapat data dari Pusher (frontend):', data);
        if (typeof fetchNotif === 'function') {
            fetchNotif();
        }
    });

    // Optional: auto-fetch saat load (kalau ingin tampil langsung juga)
    if (typeof fetchNotif === 'function') {
        fetchNotif();
    }
</script>
