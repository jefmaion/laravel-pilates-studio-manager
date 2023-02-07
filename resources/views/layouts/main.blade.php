<!DOCTYPE html>
<html lang="en">

<!-- blank.html  21 Nov 2019 03:54:41 GMT -->
<head>
    @include('layouts.includes.header')
</head>
@yield('outbody')
<body class="light theme-white dark-sidebar">
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            @include('layouts.includes.navbar')
            <div class="main-sidebar sidebar-style-2">
                @include('layouts.includes.sidebar')
            </div>
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-body">
                        @include('layouts.alerts')
                        @yield('content')
                    </div>
                </section>
                @include('layouts.includes.rightbar')
            </div>
            @include('layouts.includes.footer')
        </div>
    </div>
    @include('layouts.includes.scripts')
</body>



<!-- blank.html  21 Nov 2019 03:54:41 GMT -->

</html>