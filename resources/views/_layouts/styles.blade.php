<link rel="stylesheet" href="{{ url('_partials/css/bootstrap.css') }}" />

<link rel="stylesheet" href="{{ url('_partials/vendors/chartjs/Chart.min.css') }}" />

<link rel="stylesheet" href="{{ url('_partials/vendors/perfect-scrollbar/perfect-scrollbar.css') }}" />
<link rel="stylesheet" href="{{ url('_partials/css/app.css') }}" />
<link rel="shortcut icon" href="{{ url('mine/img/logo_tanpa_text_png.png') }}" type="image/x-icon" />

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

{{-- Sweet Alert2 --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Memberi border pada tabel */
    table.dataTable {
        /* border: 2px solid #dee2e6; */
        border-radius: 10px;
    }

    /* Warna header tabel */
    table.dataTable thead {
        background-color: #5A8DEE;
        color: white;
        font-weight: bold;
    }

    /* Hover effect */
    table.dataTable tbody tr:hover {
        background-color: #f1f1f1;
    }

    /* Membuat tampilan pagination lebih menarik */
    .dataTables_paginate .pagination {
        justify-content: end;
    }

    /* Styling untuk input search */
    .dataTables_filter input {
        width: 250px;
        /* Lebar search box */
        border: 2px solid #007bff;
        /* Warna border */
        border-radius: 8px;
        /* Membuat sudut melengkung */
        padding: 8px 12px;
        /* Padding agar lebih nyaman */
        outline: none;
        /* Menghilangkan outline saat fokus */
        transition: 0.3s ease-in-out;
    }

    /* Efek ketika input search dalam keadaan fokus */
    .dataTables_filter input:focus {
        border-color: #0056b3;
        /* Warna border saat fokus */
        box-shadow: 0px 0px 8px rgba(0, 91, 187, 0.5);
    }

    /* Mengatur posisi search agar lebih rapih */
    .dataTables_filter {
        text-align: right;
        margin-bottom: 15px;
    }

    /* Mengatur tampilan pagination */
    .dataTables_paginate {
        margin-top: 15px;
        text-align: right !important;
    }

    .dataTables_paginate .pagination {
        display: flex;
        gap: 5px;
        justify-content: end;
    }

    .dataTables_paginate .pagination .page-item {
        list-style: none;
    }

    .dataTables_paginate .pagination .page-item .page-link {
        color: #fff;
        background-color: #007bff;
        border-radius: 20px;
        padding: 6px 12px;
        transition: 0.3s;
        border: none;
    }

    .dataTables_paginate .pagination .page-item.active .page-link {
        background-color: #0056b3;
        color: #fff;
        font-weight: bold;
    }

    .dataTables_paginate .pagination .page-item .page-link:hover {
        background-color: #0056b3;
        color: #fff;
    }

    /* Menghilangkan border bawah tabel */
    table.dataTable {
        border-bottom: none;
    }
</style>
