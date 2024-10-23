<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @include("partials._head")
    <body>
        @if(!Request::is("admin") && !Request::is("admin/*") && !Request::is("*/admin") && !Request::is("*/admin/*"))
            @include("partials._header")
        @endif

        <main>
            @yield("content")
        </main>

        @if(!Request::is("admin") && !Request::is("admin/*") && !Request::is("*/admin") && !Request::is("*/admin/*"))
            @include("partials._footer")
        @endif
    </body>
</html>
