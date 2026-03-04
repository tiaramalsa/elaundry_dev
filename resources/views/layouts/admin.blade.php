<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
</head>

<body>
<div class="container-scroller">

    {{-- SIDEBAR --}}
    @include('layouts.partials.sidebar')

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

{{-- JS --}}
<script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('admin/assets/js/misc.js') }}"></script>

</body>
</html>