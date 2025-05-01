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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
@kropifyStyles

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="{{ asset('mine/editor_img/pintura.css') }}">
<script src="{{ asset('mine/editor_img/pintura.js') }}"></script>

<!-- Filepond stylesheet -->
{{-- <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet" /> --}}


<style>
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
            top: 10px;
            z-index: 1;
        }
    }

    /* frame mobile */
    @media (max-width: 767px) {
        .toggle-laknat {
            position: absolute;
            right: 50px;
            top: 10px;
            z-index: 1;
        }
    }
</style>

{{-- <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
@vite('resources/js/app.js')
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
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": true, // Aktifkan pagination
            "lengthChange": true, // Aktifkan opsi jumlah data per halaman
            "searching": true, // Aktifkan fitur pencarian
            "ordering": true, // Aktifkan fitur sorting
            "info": true, // Aktifkan info jumlah data
            "autoWidth": false, // Matikan auto-width agar tabel responsif
            "responsive": true, // Aktifkan responsivitas DataTables
            "language": {
                "search": "Cari Riwayat Konseling :",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
        });
    });
</script>
