<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @stack('styles')

    <style>
        html, body {
            height: 100%;
        }

        .container-scroller{
            min-height: 100vh;
        }

        .sidebar{
            width: 260px;
            min-height: 100vh;
        }

        .page-body-wrapper{
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative; /* 🔥 TAMBAH */
        }

        .main-panel{
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative; /* 🔥 TAMBAH */
        }

        .content-wrapper{
            flex: 1;
            width: 100%;
            padding-bottom: 90px; /* 🔥 WAJIB */
        }

        .navbar{
            width: 100%;
        }

        /* FIX NAVBAR KASIR */
        @if(auth()->user()->role === 'kasir')

        .container-fluid.page-body-wrapper{
            margin-left:0 !important;
            padding-left:0 !important;
        }

        .page-body-wrapper{
            margin-left:0 !important;
        }

        .sidebar{
            display:none !important;
        }

        .navbar{
            left:0 !important;
            width:100% !important;
        }

        .main-panel{
            margin-left:0 !important;
            width:100% !important;
        }

        /* TAMBAHAN FIX */
        .container-scroller{
            display:block !important;
        }

        .page-body-wrapper{
            width:100% !important;
        }

        .navbar{
            position:fixed;
            left:0 !important;
            width:100% !important;
        }

        @endif

        @if(auth()->user()->role === 'kurir')
        .content-wrapper{
            padding-bottom:80px !important;
        }
        @endif

        @media (max-width: 767px) {
            nav.navbar {
                position: absolute;
                top: -100px;
            }
        }

    </style>

</head>

<body>
<div class="container-scroller">

    {{-- SIDEBAR --}}
    @php $role = auth()->user()->role; @endphp

    @if(auth()->user()->role === 'admin')
    @include('layouts.partials.sidebar')
    @endif

    <div class="container-fluid page-body-wrapper">

        {{-- NAVBAR --}}
        @include('layouts.partials.navbar')

        {{-- MAIN CONTENT --}}
        <div class="main-panel">
            <div class="content-wrapper pb-0">

                @yield('content')

            </div>

            {{-- FOOTER --}}
            @include('layouts.partials.footer')

        </div>
            
    </div>
</div>

    {{-- BOTTOM NAV KHUSUS KURIR --}}
        @if(auth()->user()->role === 'kurir')
            @include('layouts.partials.bottom-nav')
        @endif

    {{-- JS --}}
    <script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/assets/js/misc.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    @stack('scripts')

</body>
</html>