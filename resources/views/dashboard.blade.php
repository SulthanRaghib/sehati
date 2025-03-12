<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>

    @include('layout_backend.style')
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        @include('layout_backend.navbar')
        <!-- partial -->

        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            @include('layout_backend.sidebar')
            <!-- partial -->

            <div class="main-panel">
                @yield('content')
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                @include('layout_backend.footer')
                <!-- partial -->

            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ url('backend/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ url('backend/assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ url('backend/assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <!-- <script src="{{ url('backend/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script> -->
    <script src="{{ url('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ url('backend/assets/js/dataTables.select.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ url('backend/assets/js/off-canvas.js') }}"></script>
    <script src="{{ url('backend/assets/js/template.js') }}"></script>
    <script src="{{ url('backend/assets/js/settings.js') }}"></script>
    <script src="{{ url('backend/assets/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ url('backend/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ url('backend/assets/js/dashboard.js') }}"></script>
    <!-- <script src="{{ url('backend/assets/js/Chart.roundedBarCharts.js') }}"></script> -->
    <!-- End custom js for this page-->
</body>

</html>
