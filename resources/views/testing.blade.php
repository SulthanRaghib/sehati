<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }}</title>

    @include('_layouts.styles')
</head>

<body>
    <div id="app">
        {{-- SIDEBAR --}}
        @include('_layouts.sidebar')
        {{-- END SIDEBAR --}}
        <div id="main">

            {{-- NAVBAR --}}
            @include('_layouts.navbar')
            {{-- END NAVBAR --}}

            {{-- MAIN CONTENT --}}
            @yield('content')
            {{-- END MAIN CONTENT --}}

            {{-- FOOTER --}}
            @include('_layouts.footer')
            {{-- END FOOTER --}}
        </div>
    </div>

    @include('_layouts.scripts')
</body>

</html>
