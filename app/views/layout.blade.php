<!DOCTYPE html>
<html lang="es" @if(Request::is('profe/*') || Request::is('academia/*')) prefix="og: http://ogp.me/ns#" @endif>
<head>
    @include('common_meta')

    @yield('page_meta')

    @include('common_head')

    @yield('page_head')

    @include('common_css')

    @yield('page_css')
</head>
<body>
    @include('header')

    @yield('content')

    @include('common_modals')

    @include('footer')

    @include('common_js')

    @yield('page_js')
</body>
</html>