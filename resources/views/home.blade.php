<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $title }}</title>
    <meta name="description" content="Sistem Informasi Konseling" />
    <meta name="author" content="Sulthan Raghib Fillah" />
    <meta name="keywords" content="Sistem Informasi Konseling" />

    @include('_layouts_fe.styles')
</head>

<body class="index-page">

    @include('_layouts_fe.header')

    <main class="main light-background">
        @yield('main-content')
    </main>

    @include('_layouts_fe.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    @include('_layouts_fe.scripts')
</body>

</html>
