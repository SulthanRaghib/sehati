<!-- Vendor JS Files -->
<script src="{{ url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ url('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ url('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ url('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ url('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>

<!-- Main JS File -->
<script src="{{ url('assets/js/main.js') }}"></script><!-- Vendor JS Files -->
<script src="{{ url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ url('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ url('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ url('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ url('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>

<!-- Main JS File -->
<script src="{{ url('assets/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js"
    integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+" crossorigin="anonymous">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('mine/editor_img/pintura.js') }}"></script>

{{-- Data Tabel --}}
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        [...tooltipTriggerList].forEach(el => new bootstrap.Tooltip(el));
    });
</script>

@kropifyScripts

<!-- Load FilePond library -->
{{-- <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js">
</script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const body = document.querySelector('body');
        const navToggle = document.querySelector('.mobile-nav-toggle');
        const navMenu = document.querySelector('#navmenu');

        if (navToggle) {
            navToggle.addEventListener('click', function() {
                body.classList.toggle('mobile-nav-active');

                // Ganti ikon
                if (navToggle.classList.contains('bi-list')) {
                    navToggle.classList.remove('bi-list');
                    navToggle.classList.add('bi-x');
                } else {
                    navToggle.classList.remove('bi-x');
                    navToggle.classList.add('bi-list');
                }
            });
        }
    });
</script>

<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    const notifCount = document.getElementById('notif-count');
    const notifList = document.getElementById('notif-list');
    const notifHeader = document.getElementById('notif-header');
    const notifBadge = document.getElementById('notif-badge');

    function fetchJawabanNotif() {
        fetch('/notifikasi/fetch/jawaban')
            .then(res => res.json())
            .then(data => {
                notifList.innerHTML = '';
                const maxDisplay = 3;

                const unreadNotifs = data.filter(notif => !notif.is_read);
                const unread = unreadNotifs.length;

                // Simpan jumlah ke localStorage
                localStorage.setItem('unreadNotifs', unread);

                // Update header jika ada
                if (notifHeader) {
                    notifHeader.textContent = unread === 0 ?
                        'Semua Jawaban Sudah Dirating' :
                        'Jawaban Belum Dirating';
                }

                // Tampilkan hanya 3 notifikasi
                unreadNotifs.slice(0, maxDisplay).forEach(notif => {
                    const bodyPreview = notif.body.length > 24 ? notif.body.slice(0, 24) + '...' : notif
                        .body;

                    notifList.innerHTML += `
                        <li class="list-group-item border-0 align-items-start">
                            <a href="/siswa-konseling/jawaban-unread" class="d-flex text-dark text-decoration-none">
                                <div class="avatar bg-primary mr-3">
                                    <span class="avatar-content"><i data-feather="mail"></i></span>
                                </div>
                                <div>
                                    <h6 class="text-bold mb-1">${notif.title}</h6>
                                    <p class="text-xs mb-0">${bodyPreview}</p>
                                </div>
                            </a>
                        </li>
                    `;
                });

                // Tombol lihat semua
                if (unread > maxDisplay) {
                    notifList.innerHTML += `
                        <li class="list-group-item text-center border-top">
                            <a href="/siswa-konseling/jawaban-unread" class="text-primary font-weight-bold">
                                Lihat Semua Jawaban
                            </a>
                        </li>
                    `;
                }

                // Update badge dan count
                if (notifBadge) notifBadge.textContent = unread;
                if (notifCount) notifCount.textContent = unread;

                feather.replace();
            })
            .catch(err => {
                console.error('❌ Gagal mengambil notifikasi jawaban:', err);
            });
    }

    // Saat halaman dimuat, pakai cache jika ada
    window.addEventListener('DOMContentLoaded', () => {
        const savedUnread = localStorage.getItem('unreadNotifs');
        if (savedUnread) {
            if (notifBadge) notifBadge.textContent = savedUnread;
            if (notifCount) notifCount.textContent = savedUnread;
        }
    });

    // Inisialisasi pertama
    fetchJawabanNotif();

    // Pusher setup
    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true
    });

    const channelJawabanKonseling = pusher.subscribe('jawaban-konseling');
    channelJawabanKonseling.bind('jawaban-konseling', function(data) {
        console.log('✅ Dapat data dari Pusher (jawaban konseling):', data);
        fetchJawabanNotif();
    });
</script>



@stack('scripts')
