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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @stack('styles')

    <style>
        /* GENERAL */
        .content-wrapper {
            padding-bottom: 90px;
        }

        /* =========================
        KASIR & KURIR MODE
        ========================= */
        @if(auth()->user()->role === 'kasir' || auth()->user()->role === 'kurir')

        .sidebar {
            display: none !important;
        }

        .page-body-wrapper {
            margin-left: 0 !important;
            padding-left: 0 !important;
            width: 100% !important;
        }

        .main-panel {
            width: 100% !important;
            margin-left: 0 !important;
            max-width: 100% !important;
            flex: 1 1 100% !important;
        }

        .container-fluid.page-body-wrapper {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .navbar {
            width: 100% !important;
            left: 0 !important;
            padding-right: 0 !important;
        }

        body:not(.sidebar-icon-only) .main-panel {
            margin-left: 0 !important;
        }

        @endif

        /* =========================
        NAVBAR UNIVERSAL FIX
        ========================= */

        /* wrapper utama */
        .navbar-menu-wrapper {
            display: flex;
            align-items: center;
            width: 100%;
        }

        /* LEFT */
        .nav-left {
            min-width: 150px;
        }

        /* CENTER MENU */
        .main-menu {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 25px;
        }

        /* MENU ITEM */
        .main-menu .nav-link {
            display: flex;
            align-items: center;
            gap: 6px;
            height: 60px;
            font-size: 14px;
            white-space: nowrap;
        }

        /* RIGHT */
        .nav-right {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-left: auto;
        }

        .navbar-menu-wrapper {
            display: flex;
            align-items: center;
            width: 100%;
            padding-right: 15px; /* opsional biar ga nempel banget */
        }

        /* PROFILE */
        .nav-profile {
            margin-right: 10px;
        }

        /* HAPUS GARIS ANEH */
        .navbar .nav-item,
        .navbar .nav-link {
            border: none !important;
            box-shadow: none !important;
        }

        /* FIX DROPDOWN KE KANAN */
        .navbar-nav-right .dropdown-menu,
        .nav-right .dropdown-menu {
            right: 0;
            left: auto;
        }

        /* DARK MODE UNTUK KASIR & KURIR */
        @if(auth()->user()->role === 'kasir' || auth()->user()->role === 'kurir')
        .navbar {
            background: #000;
        }
        @endif

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/assets/js/misc.js') }}"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    @stack('scripts')

</body>
</html>