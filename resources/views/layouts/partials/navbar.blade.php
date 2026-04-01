@php
use App\Models\Pemesanan;
use Carbon\Carbon;

$user = auth()->user();
$role = $user->role;

$notifikasiOrder = Pemesanan::whereDate('created_at', Carbon::today())
                ->latest()
                ->take(5)
                ->get();

$countNotif = $notifikasiOrder->count();
@endphp
<nav class="navbar col-lg-12 col-12 p-lg-0 fixed-top d-flex flex-row 
@if($role === 'kasir') navbar-kasir @endif">
  <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between
@if($role === 'kasir') pl-0 @endif">
    <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href="index.html"><img src="{{ asset('admin/assets/images/logo-mini.svg') }}" alt="logo" /></a>
    @if($role !== 'kasir' && $role !== 'kurir')
    <div class="app-logo">
        <a href="{{ route($role.'.dashboard') }}">
            <img src="{{ asset('admin/assets/images/Logo C24-text.png') }}" style="height:70px;">
        </a>
    </div>
    <button class="navbar-toggler navbar-toggler align-self-center mr-2" type="button" data-toggle="minimize">
      <i class="mdi mdi-menu"></i>
    </button>
    @endif
    
    @if($role === 'kasir')
    <div class="kasir-logo">
    <a href="{{ route($role.'.dashboard') }}">
    <img src="{{ asset('admin/assets/images/Logo C24-text.png') }}" style="height:90px;">
    </a>
    </div>
    @endif
    <ul class="navbar-nav main-menu">

      @if($role === 'kasir')

      <li class="nav-item">
      <a class="nav-link" href="{{ route($role.'.dashboard') }}">
      <i class="mdi mdi-home"></i> Beranda
      </a>
      </li>

      <li class="nav-item">
      <a class="nav-link" href="{{ route('reservasi.create') }}">
      <i class="mdi mdi-calendar-plus"></i> Reservasi
      </a>
      </li>

      <li class="nav-item">
      <a class="nav-link" href="{{ route('pemesanan.index') }}">
      <i class="mdi mdi-package-variant"></i> Input Order
      </a>
      </li>

      <li class="nav-item">
      <a class="nav-link" href="{{ route($role.'.lacak.index') }}">
      <i class="mdi mdi-update"></i> Proses Order
      </a>
      </li>

      <li class="nav-item">
      <a class="nav-link" href="{{ route($role.'.riwayat.index') }}">
      <i class="mdi mdi-history"></i> Riwayat
      </a>
      </li>

      @endif
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
          <i class="mdi mdi-bell-outline"></i>
          @if($countNotif > 0)
          <span class="count count-varient1">{{ $countNotif }}</span>
          @endif
        </a>
        <div class="dropdown-menu navbar-dropdown navbar-dropdown-large preview-list" aria-labelledby="notificationDropdown">

          <h6 class="p-3 mb-0">
          Notifikasi Order Hari Ini
          </h6>

          @forelse($notifikasiOrder as $order)

          <a class="dropdown-item preview-item"
            href="{{ route($role.'.riwayat.index') }}">

          <div class="preview-thumbnail">
            <div class="preview-icon bg-success">
                <i class="mdi mdi-package-variant text-white"></i>
            </div>
          </div>

          <div class="preview-item-content">

          <p class="mb-0 font-weight-medium">
          Order #{{ $order->id }}
          </p>

          <p class="text-small text-muted mb-0">
          {{ $order->nama_lengkap }}
          • {{ $order->created_at->diffForHumans() }}
          </p>

          </div>

          </a>

          @empty

          <p class="p-3 text-muted">
          Tidak ada order baru hari ini
          </p>

          @endforelse

          <div class="dropdown-divider"></div>

          <a class="p-3 d-block text-center"
            href="{{ route('pemesanan.index') }}">
          Lihat Semua Order
          </a>

        </div>
      </li>
      @if($role !== 'kasir' && $role !== 'kurir')
        <li class="nav-item dropdown d-none d-sm-flex">
        <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown">
          <i class="mdi mdi-email-outline"></i>
          <span class="count count-varient2">5</span>
        </a>
        <div class="dropdown-menu navbar-dropdown navbar-dropdown-large preview-list" aria-labelledby="messageDropdown">
          <h6 class="p-3 mb-0">Messages</h6>
          <a class="dropdown-item preview-item">
            <div class="preview-item-content flex-grow">
              <span class="badge badge-pill badge-success">Request</span>
              <p class="text-small text-muted ellipsis mb-0"> Suport needed for user123 </p>
            </div>
            <p class="text-small text-muted align-self-start"> 4:10 PM </p>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-item-content flex-grow">
              <span class="badge badge-pill badge-warning">Invoices</span>
              <p class="text-small text-muted ellipsis mb-0"> Invoice for order is mailed </p>
            </div>
            <p class="text-small text-muted align-self-start"> 4:10 PM </p>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-item-content flex-grow">
              <span class="badge badge-pill badge-danger">Projects</span>
              <p class="text-small text-muted ellipsis mb-0"> New project will start tomorrow </p>
            </div>
            <p class="text-small text-muted align-self-start"> 4:10 PM </p>
          </a>
          <h6 class="p-3 mb-0">See all activity</h6>
        </div>
      </li>
      @endif
      @if($role !== 'kasir' && $role !== 'kurir')
      <li class="nav-item nav-search border-0 ml-1 ml-md-3 ml-lg-5 d-none d-md-flex">
        <form class="nav-link form-inline mt-2 mt-md-0">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" />
            <div class="input-group-append">
              <span class="input-group-text">
                <i class="mdi mdi-magnify"></i>
              </span>
            </div>
          </div>
        </form>
      </li>
      @endif

      <!-- KURIR -->
      @if($role === 'kurir')

      <li class="nav-item">
          <a class="nav-link" href="{{ route('kurir.dashboard') }}">
              <i class="mdi mdi-view-dashboard"></i>
              <span>Beranda</span>
          </a>
      </li>

      <li class="nav-item">
          <a class="nav-link" href="{{ route('kurir.tugas') }}">
              <i class="mdi mdi-truck-fast"></i>
              <span>Tugas</span>
          </a>
      </li>

      <li class="nav-item">
          <a class="nav-link" href="{{ route('kurir.riwayat.index') }}">
              <i class="mdi mdi-clipboard-text-clock"></i>
              <span>Riwayat</span>
          </a>
      </li>

      <li class="nav-item">
          <a class="nav-link" href="{{ route('kurir.profile') }}">
              <i class="mdi mdi-account"></i>
              <span>Profile</span>
          </a>
      </li>

      @endif
    </ul>

    <!-- {{-- MENU KURIR DESKTOP --}}
      @if($role === 'kurir')
      <div class="kurir-desktop-menu">
          <a href="{{ route('kurir.dashboard') }}">Home</a>
          <a href="#">Tugas</a>
          <a href="#">Riwayat</a>
          <a href="#">Profile</a>
      </div>
      @endif -->

    <ul class="navbar-nav navbar-nav-right ml-lg-auto">
      @if($role !== 'kasir' && $role !== 'kurir')
      <li class="nav-item dropdown d-none d-xl-flex border-0">
        <a class="nav-link dropdown-toggle" id="languageDropdown" href="#" data-toggle="dropdown">
          <i class="mdi mdi-earth"></i> English </a>
        <div class="dropdown-menu navbar-dropdown w-100" aria-labelledby="languageDropdown">
          <a class="dropdown-item" href="#"> French </a>
          <a class="dropdown-item" href="#"> Spain </a>
          <a class="dropdown-item" href="#"> Latin </a>
          <a class="dropdown-item" href="#"> Japanese </a>
        </div>
      </li>
      @endif
      <li class="nav-item nav-profile dropdown border-0">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown">
          <img class="nav-profile-img mr-2" alt=""
              src="{{ $user->foto ? asset('storage/'.$user->foto) : asset('admin/assets/images/faces/face1.jpg') }}" />

          <span class="profile-name">
              {{ $user->name }} ({{ ucfirst($role) }})
          </span>
        </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="{{ route($role.'.dashboard') }}">
            <i class="mdi mdi-view-dashboard mr-2 text-success"></i> Dashboard
          </a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item">
              <i class="mdi mdi-logout mr-2 text-primary"></i> Logout
            </button>
          </form>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>

<style>
  .navbar-nav .nav-link{
    font-weight:500;
    padding:0 14px;
    }

  @if($role === 'kasir')
    .navbar-menu-wrapper{
    padding-left:0 !important;
    }
    @endif

  @if($role === 'kasir')

  .navbar-nav .nav-link{
    font-weight:500;
    padding:0 10px;
    font-size:14px;
    display:flex;
    align-items:center;
    height:60px;
    }

    .navbar-nav .nav-link i{
    margin-right:6px;
    }

    @endif

  .navbar-kasir{
    left:0 !important;
    width:100vw !important;
    background:#000;
    }

    .navbar-kasir .navbar-menu-wrapper{
    width:100% !important;
    max-width:100% !important;
    flex:1;
    }

    .navbar-kasir .navbar-nav{
    margin-left:0 !important;
    }

    @if($role === 'kasir')

    .main-panel{
        margin-left:0 !important;
        width:100% !important;
    }

    .page-body-wrapper{
        padding-left:0 !important;
    }

    @endif

    .navbar-kasir .navbar-nav{
    display:flex;
    align-items:center;
    margin-left:30px;
    }

    .navbar-kasir .nav-item{
    border-right:none !important;
    }

    .navbar-kasir .navbar-nav .nav-link{
    border-right:none !important;
    }

    @if($role === 'kasir')

    .navbar-kasir .navbar-nav{
    display:flex;
    align-items:center;
    justify-content:center;
    flex:1;
    margin-left:0;
    }
    @endif

    @if($role === 'kasir')

    .navbar-kasir .nav-item:first-child{
    margin-left:20px;
    }
    @endif

    .navbar-nav-right .dropdown-menu{
    min-width:100px;
    } 

    @if($role === 'kasir')

    .navbar-kasir .nav-item{
    border-right:none !important;
    }

    .navbar-kasir .nav-link{
    border-right:none !important;
    }

    @endif

    @if($role === 'kasir')

    .kasir-menu{
    flex:1;
    display:flex;
    justify-content:center;
    align-items:center;
    gap:25px;
    }

    @endif

    @if($role === 'kasir')

    .navbar-kasir .navbar-nav .nav-item{
    border:none !important;
    }

    @endif

    .nav-profile .dropdown-menu{
    right:0;
    left:auto;
    min-width:180px;
    }

    .navbar-kasir .navbar-menu-wrapper{
    display:flex;
    align-items:center;
    }

    .navbar-kasir{
    height:70px;
    }

    @if($role === 'kasir')

    .kasir-logo{
    margin-left:50px;
    display:flex;
    align-items:center;
    }

    .kasir-menu{
    flex:1;
    display:flex;
    justify-content:center;
    align-items:center;
    gap:25px;
    }

    .navbar-kasir .nav-item{
    border:none !important;
    }

    .nav-profile .dropdown-menu{
    right:0;
    left:auto;
    min-width:180px;
    }

    @endif

    @if($role === 'kasir')

    /* menu tetap satu baris */
    .kasir-menu{
    flex:1;
    display:flex;
    justify-content:center;
    align-items:center;
    gap:25px;
    flex-wrap:nowrap;
    }

    /* text menu tidak boleh turun baris */
    .kasir-menu .nav-link{
    white-space:nowrap;
    }

    @endif

    /* MENU KURIR DESKTOP */
    .kurir-desktop-menu {
        display: none; /* default sembunyi */
        background: #fff;
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
        justify-content: space-around;
        align-items: center;
        display: flex;
    }

    .kurir-desktop-menu a {
        text-decoration: none;
        color: #666;
        font-size: 14px;
        text-align: center;
    }

    @media (max-width: 767px) {
        .kurir-desktop-menu {
            display: none; /* sembunyi mobile */
        }
    }

    @media (min-width: 768px) {
        .kurir-desktop-menu {
            display: flex; /* tampil desktop */
        }
    }

    /* KURIR */
    .main-menu{
        flex:1;
        display:flex;
        justify-content:center;
        align-items:center;
        gap:12px;
    }

    .main-menu .nav-link{
        display:flex;
        align-items:center;
        height:60px;
        white-space:nowrap;
    }

    .main-menu .nav-link i{
        margin-right:6px;
    }

    @if($role === 'kurir')
    .navbar{
        background:#000;
    }
    @endif

    @if($role === 'kurir')

    .sidebar{
        display:none !important;
    }

    .page-body-wrapper{
        margin-left:0 !important;
        padding-left:0 !important;
    }

    .main-panel{
        margin-left:0 !important;
        width:100% !important;
    }

    .navbar{
        left:0 !important;
        width:100% !important;
    }

    @endif

    @if($role === 'kurir')

    .main-menu{
        flex:1;
        display:flex;
        justify-content:center;
        align-items:center;
        gap:30px;
    }

    .navbar-nav-right{
        margin-left:auto;
    }

    /* ICON NAVBAR */
    .main-menu .nav-link i {
        font-size: 18px;
        margin-right: 6px;
    }

    /* TEXT + ICON RAPI */
    .main-menu .nav-link {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* HOVER EFFECT (biar lebih hidup) */
    .main-menu .nav-link:hover {
        color: #4B49AC;
    }

    /* FIX NAVBAR CENTER PERFECT */
    .navbar-menu-wrapper {
        display: flex;
        align-items: center;
    }

    .main-menu {
        flex: 1;
        display: flex;
        justify-content: center; /* 🔥 center beneran */
        align-items: center;
    }

    .navbar-nav-right {
        margin-left: auto; /* 🔥 dorong ke kanan */
    }

    @endif



  </style>
