<nav class="sidebar sidebar-offcanvas" id="sidebar">

  <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
    <a class="sidebar-brand brand-logo" href="{{ route(auth()->user()->role.'.dashboard') }}">
      <img src="{{ asset('admin/assets/images/logo.svg') }}" alt="logo"/>
    </a>
    <a class="sidebar-brand brand-logo-mini pl-4 pt-3" href="{{ route(auth()->user()->role.'.dashboard') }}">
      <img src="{{ asset('admin/assets/images/logo-mini.svg') }}" alt="logo"/>
    </a>
  </div>

  @php
      $role = auth()->user()->role;
  @endphp

  <ul class="nav">

    {{-- PROFILE --}}
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="{{ asset('admin/assets/images/faces/face1.jpg') }}" alt="profile"/>
          <span class="login-status online"></span>
        </div>

        <div class="nav-profile-text d-flex flex-column pr-3">
          <span class="font-weight-medium mb-2">{{ auth()->user()->name }}</span>
          <span class="font-weight-normal">{{ ucfirst($role) }}</span>
        </div>
      </a>
    </li>

    {{-- DASHBOARD --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route($role.'.dashboard') }}">
        <i class="mdi mdi-home menu-icon"></i>
        <span class="menu-title">Beranda</span>
      </a>
    </li>

    {{-- RESERVASI --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route('reservasi.create') }}">
        <i class="mdi mdi-calendar-plus menu-icon"></i>
        <span class="menu-title">Reservasi</span>
      </a>
    </li>

    {{-- PEMESANAN --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route('pemesanan.create') }}">
        <i class="mdi mdi-package-variant menu-icon"></i>
        <span class="menu-title">Pemesanan</span>
      </a>
    </li>

    {{-- UPDATE STATUS --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route($role.'.lacak.index') }}">
        <i class="mdi mdi-update menu-icon"></i>
        <span class="menu-title">Update Status</span>
      </a>
    </li>

    {{-- RIWAYAT --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route($role.'.riwayat.index') }}">
        <i class="mdi mdi-history menu-icon"></i>
        <span class="menu-title">Riwayat</span>
      </a>
    </li>

    @if($role === 'admin')

    {{-- MANAJEMEN --}}
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#manajemen" aria-expanded="false">
        <i class="mdi mdi-folder menu-icon"></i>
        <span class="menu-title">Manajemen</span>
        <i class="menu-arrow"></i>
      </a>

      <div class="collapse" id="manajemen">
        <ul class="nav flex-column sub-menu">

          <li class="nav-item">
            <a class="nav-link" href="{{ route('manajemen.indexpromo') }}">
              Promo
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('manajemen.customer.index') }}">
              Customer
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('manajemen.harga.index') }}">
              Harga
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('manajemen.user.index') }}">
              User
            </a>
          </li>

        </ul>
      </div>
    </li>

    {{-- PENGATURAN --}}
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#pengaturan-menu" aria-expanded="false" aria-controls="pengaturan-menu">
        <i class="mdi mdi-settings menu-icon"></i>
        <span class="menu-title">Pengaturan</span>
        <i class="menu-arrow"></i>
      </a>

      <div class="collapse" id="pengaturan-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('outlet.*') ? 'active' : '' }}" href="{{ route('outlet.index') }}">
              Outlet
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('karyawan.*') ? 'active' : '' }}" href="{{ route('karyawan.index') }}">
              Karyawan
            </a>
          </li>
        </ul>
      </div>
    </li>
    @endif

    {{-- LOGOUT --}}
    <li class="nav-item sidebar-actions">
      <div class="nav-link">

        <form method="POST" action="{{ route('logout') }}">
          @csrf

          <button type="submit" class="btn btn-block btn-danger">
            Logout
          </button>
        </form>

      </div>
    </li>

  </ul>

</nav>