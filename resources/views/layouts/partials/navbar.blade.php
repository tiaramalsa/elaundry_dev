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
    @if($role !== 'kasir')
    <button class="navbar-toggler navbar-toggler align-self-center mr-2" type="button" data-toggle="minimize">
      <i class="mdi mdi-menu"></i>
    </button>
    @endif
    <ul class="navbar-nav">

      @if($role === 'kasir')

      <li class="nav-item d-flex align-items-center mr-3">
      <a href="{{ route($role.'.dashboard') }}">
      <img src="{{ asset('admin/assets/images/Logo C24-text.png') }}"
          style="height:110px;">
      </a>
      </li>

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
      @if($role !== 'kasir')
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
      @if($role !== 'kasir')
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
    </ul>
    <ul class="navbar-nav navbar-nav-right ml-lg-auto">
      @if($role !== 'kasir')
      <li class="nav-item dropdown d-none d-xl-flex border-0">
        <a class="nav-link dropdown-toggle" id="languageDropdown" href="#" data-toggle="dropdown">
          <i class="mdi mdi-earth"></i> English </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
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
        <div class="dropdown-menu navbar-dropdown w-100" aria-labelledby="profileDropdown">
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
    padding:0 18px;
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
</style>
