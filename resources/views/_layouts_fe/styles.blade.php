<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

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
<meta name="csrf-token" content="{{ csrf_token() }}">
@kropifyStyles

<link rel="stylesheet" href="{{ asset('mine/editor_img/pintura.css') }}">

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Filepond stylesheet -->
{{-- <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet" /> --}}


<style>
    html,
    body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
        background: #f3f9ff;
    }


    /* Ini global styling */
    .mobile-nav-toggle {
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    body.mobile-nav-active .navmenu {
        right: 0;
        opacity: 1;
    }

    .dropdown-menu {
        transition: all 0.3s ease;
        display: none;
        /* default hidden */
    }

    /* hanya aktif saat desktop */
    @media (min-width: 768px) {
        .dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }
    }

    /* frame tablet */
    @media (min-width: 768px) and (max-width: 1024px) {
        .toggle-laknat {
            position: absolute;
            right: 50px;
            top: 20px;
            z-index: 1;
        }
    }

    /* frame mobile */
    @media (max-width: 767px) {
        .toggle-laknat {
            position: absolute;
            right: 50px;
            top: 20px;
            z-index: 1;
        }
    }
</style>

{{-- <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    Pusher.logToConsole = true;

    // Inisialisasi Pusher
    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true
    });

    // Subscribe ke channel jawaban konseling
    const channelJawabanKonseling = pusher.subscribe('jawaban-konseling');
    channelJawabanKonseling.bind('jawaban-konseling', function(data) {
        console.log('✅ Dapat data dari Pusher (jawaban konseling):', data);
        if (typeof fetchNotif === 'function') {
            fetchNotif();
        }
    });

    // Fetch notifikasi saat halaman dimuat
    if (typeof fetchNotif === 'function') {
        fetchNotif();
    }
</script> --}}



{{-- Data Tabel --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">

@stack('styles')
