<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include("partials._seo")

<link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
<link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

@vite(['resources/scss/backoffice/index.scss', 'resources/js/backoffice/index.ts'])

<body>

<main>
    <div id="app">
        <div class="loader -full -main"></div>
        <app></app>
    </div>
</main>

</body>
</html>
