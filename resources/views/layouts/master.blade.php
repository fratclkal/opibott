<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.head')
    <body class="main-body app sidebar-mini dark-theme">
        <div id="global-loader">
            <img src="/assets/img/loader.svg" class="loader-img" alt="Loader">
        </div>
        <div class="page">
            @include('layouts.sidebar')
            <div class='main-content app-content'>
                @include('layouts.header')
                @yield('content')
            </div>
            @include('layouts.sidebar_right')
            @include('layouts.footer')
        </div>

        @include('layouts.js')
    </body>
</html>
