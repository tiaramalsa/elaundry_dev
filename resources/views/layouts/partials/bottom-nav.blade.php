<div class="bottom-nav">
    <a href="{{ route('kurir.dashboard') }}" class="nav-item">
        <i class="mdi mdi-home"></i>
        <span>Home</span>
    </a>

    <a href="{{ route('kurir.tugas') }}" class="nav-item">
        <i class="mdi mdi-format-list-bulleted"></i>
        <span>Tugas</span>
    </a>

    <a href="{{ route('kurir.riwayat.index') }}" class="nav-item">
        <i class="mdi mdi-history"></i>
        <span>Riwayat</span>
    </a>

    <a href="{{ route('kurir.profile') }}" class="nav-item">
        <i class="mdi mdi-account"></i>
        <span>Profile</span>
    </a>
</div>

<style>
.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height: 65px;
    background: #fff;
    border-top: 1px solid #ddd;
    display: flex;
    justify-content: space-around;
    align-items: center;
    z-index: 999999 !important;
}

.bottom-nav .nav-item {
    text-align: center;
    font-size: 12px;
    color: #666;
    text-decoration: none;
}

.bottom-nav .nav-item i {
    display: block;
    font-size: 20px;
}

/* DESKTOP: sembunyikan */
@media (min-width: 768px) {
    .bottom-nav {
        display: none;
    }
}

/* PAKSA tampil di mobile */
@media (max-width: 767px) {
    .bottom-nav {
        display: flex !important;
    }
}
</style>