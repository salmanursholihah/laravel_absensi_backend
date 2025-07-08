<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no"
        name="viewport">
    <title>@yield('title') &mdash; Absensi</title>

    <!-- General CSS Files -->
    <link rel="stylesheet"
        href="{{ asset('backend/asset/library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    @stack('style')

    <!-- Template CSS -->
    <link rel="stylesheet"
        href="{{ asset('backend/asset/css/style.css') }}">
    <link rel="stylesheet"
        href="{{ asset('backend/asset/css/components.css') }}">

    <!-- Start GA -->
    <script async
        src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <!-- Content -->
                @yield('main')

                <!-- Footer -->
                @include('components.error-footer')
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('backend/asset/library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/asset/library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('backend/asset/library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('backend/asset/library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/asset/library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('backend/asset/library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('backend/asset/js/stisla.js') }}"></script>

    @stack('scripts')

    <!-- Template JS File -->
    <script src="{{ asset('backend/asset/js/scripts.js') }}"></script>
    <script src="{{ asset('backend/asset/js/custom.js') }}"></script>

</html>
