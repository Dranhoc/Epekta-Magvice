<head>
    @include("partials._seo")

    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Add google fonts here --}}

    <script src="{{ asset("vendor/tarteaucitron/tarteaucitron.min.js") }}"></script>
    <script src="{{ asset("vendor/tarteaucitron/tarteaucitron.services.min.js") }}"></script>
    @vite(['resources/scss/frontoffice/index.scss', 'resources/js/frontoffice/index.ts', 'resources/js/frontoffice/tarteaucitron.js'])

    @include('partials._marker')

    @env('production')
        <script>
            window.gtagUa = ''; // G-XXXXXXX
            window.googletagmanagerId = '';
            window.gajsUa = '';
            window.facebookpixelId = '';
        </script>
    @endenv

    @env('local')
        <script>
            window.gtagUa = 'G-XXXXXXX';
        </script>
    @endenv
</head>



