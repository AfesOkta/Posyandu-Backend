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
                <li class="{{ Route::is('puskesmas') ? 'active' : '' }}">
                    <a href="{{ route('puskesmas') }}">
                        <i class="fas fa-account_balance"></i>
                        <span>Puskesmas</span>
                    </a>
                </li>
                <li class="{{ Route::is('kader') ? 'active' : '' }}">
                    <a href="{{ route('kader') }}">
                        <i class="fas fa-contacts"></i>
                        <span>Kader Puskesmas</span>
                    </a>
                </li>
                <li class="{{ Route::is('anggota') ? 'active' : '' }}">
                    <a href="{{ route('anggota') }}">
                        <i class="fas fa-contacts"></i>
                        <span>Anggota Kader</span>
                    </a>
                </li>
                {{-- <li class="{{ Route::is('absensi') ? 'active' : '' }}">
                    <a href="{{ route('absensi') }}">
                        <i class="fas fa-documents"></i>
                        <span>Absen Anggota</span>
                    </a>
                </li> --}}
            </ul>
        </aside>
    </div>
</div>
