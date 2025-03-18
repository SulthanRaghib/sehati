<script src="{{ url('_partials/js/feather-icons/feather.min.js') }}"></script>
<script src="{{ url('_partials/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ url('_partials/js/app.js') }}"></script>

<script src="{{ url('_partials/vendors/chartjs/Chart.min.js') }}"></script>
<script src="{{ url('_partials/vendors/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ url('_partials/js/pages/dashboard.js') }}"></script>

<script src="{{ url('_partials/js/main.js') }}"></script>

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
