<script src="{{ url('_partials/js/feather-icons/feather.min.js') }}"></script>
<script src="{{ url('_partials/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ url('_partials/js/app.js') }}"></script>

<script src="{{ url('_partials/vendors/chartjs/Chart.min.js') }}"></script>
<script src="{{ url('_partials/vendors/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ url('_partials/js/pages/dashboard.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script src="{{ url('_partials/js/main.js') }}"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


<script>
    ClassicEditor
        .create(document.querySelector('#wordArtikel'), {
            toolbar: {
                items: [
                    'undo', 'redo', '|',
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', 'highlight', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                    'alignment', '|',
                    'link', 'blockQuote', '|',
                    'numberedList', 'bulletedList', '|',
                    'outdent', 'indent', '|',
                    'codeBlock', 'removeFormat'
                ]
            },
            language: 'id',
        })
        .catch(error => {
            console.error(error);
        });
</script>

<script>
    $(document).ready(function() {
        $('#table1').DataTable({
            "paging": true, // Aktifkan pagination
            "lengthChange": true, // Aktifkan opsi jumlah data per halaman
            "searching": true, // Aktifkan fitur pencarian
            "ordering": true, // Aktifkan fitur sorting
            "info": true, // Aktifkan info jumlah data
            "autoWidth": false, // Matikan auto-width agar tabel responsif
            "responsive": true, // Aktifkan responsivitas DataTables
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>

{{-- Password Hide Show --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle for password
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = `<i data-feather="${type === 'password' ? 'eye-off' : 'eye'}"></i>`;
            feather.replace();
        });

        // Toggle for confirm password
        const toggleConfirm = document.querySelector('#togglePasswordConfirmation');
        const confirmInput = document.querySelector('#password_confirmation');
        toggleConfirm.addEventListener('click', function() {
            const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmInput.setAttribute('type', type);
            this.innerHTML = `<i data-feather="${type === 'password' ? 'eye-off' : 'eye'}"></i>`;
            feather.replace();
        });
    });
</script>


{{-- Notifikasi --}}
<script>
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('notifDropdownMenu');
        const toggle = document.getElementById('notifDropdownToggle');
        if (!menu.contains(event.target) && !toggle.contains(event.target)) {
            menu.classList.remove('show');
            toggle.setAttribute('aria-expanded', 'false');
        }
    });


    function openNotifDropdown(event) {
        event.preventDefault();

        const menu = document.getElementById('notifDropdownMenu');
        const toggle = document.getElementById('notifDropdownToggle');
        const isOpen = menu.classList.contains('show');

        // Hapus pemanggilan markAsRead()
        if (isOpen) {
            menu.classList.remove('show');
            toggle.setAttribute('aria-expanded', 'false');
        } else {
            menu.classList.add('show');
            toggle.setAttribute('aria-expanded', 'true');
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        [...tooltipTriggerList].forEach(el => new bootstrap.Tooltip(el));
    });
</script>

@kropifyScripts
@stack('scripts')
