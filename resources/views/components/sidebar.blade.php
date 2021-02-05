<div>
    <!-- Sidebar outter -->
    <div class="main-sidebar sidebar-style-2">
        <!-- sidebar wrapper -->
        <aside id="sidebar-wrapper">
            <!-- sidebar brand -->
            <div class="sidebar-brand">
                <a href="#">{{ config('app.name', 'Laravel') }}</a>
            </div>
            <!-- sidebar menu -->
            <ul class="sidebar-menu">
                <!-- menu header -->
                <li class="menu-header">General</li>
                <!-- menu item -->
                <li class="{{ Route::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-fire"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ Route::is('profile') ? 'active' : '' }}">
                    <a href="{{ route('profile') }}">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="{{ Route::is('posyandu') ? 'active' : '' }}">
                    <a href="{{ route('posyandu') }}">
                        <i class="fas fa-ambulance"></i>
                        <span>Posyandu</span>
                    </a>
                </li>
                <li class="{{ Route::is('kader') ? 'active' : '' }}">
                    <a href="{{ route('kader') }}">
                        <i class="fas fa-address-card"></i>
                        <span>Kader Posyandu</span>
                    </a>
                </li>
                <li class="{{ Route::is('anggota') ? 'active' : '' }}">
                    <a href="{{ route('anggota') }}">
                        <i class="fas fa-address-book"></i>
                        <span>Anggota Kader</span>
                    </a>
                </li>
                <li class="">
                    <a href="#">
                        <i class="fas fa-clock"></i>
                        <span>Absen Anggota</span>
                    </a>
                </li>
            </ul>
        </aside>
    </div>
</div>
