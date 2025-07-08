<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Absensi Milos</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">AM</a>
        </div>
        <ul class="sidebar-menu">

            {{-- Menu khusus admin --}}
            @if(auth()->user()->role === 'admin')
            <li class="nav-item">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-fire"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">
                    <i class="fas fa-columns"></i>
                    <span>Users</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('pages.companies.index') }}" class="nav-link">
                    <i class="fas fa-columns"></i>
                    <span>Company</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('attendances.index') }}" class="nav-link">
                    <i class="fas fa-columns"></i>
                    <span>Attendances</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('permissions.index') }}" class="nav-link">
                    <i class="fas fa-columns"></i>
                    <span>Permission</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('rekap.keterlambatan') }}" class="nav-link">
                    <i class="fas fa-columns"></i>
                    <span>Rekap Keterlambatan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('catatan.index') }}" class="nav-link">
                    <i class="fa fa-columns"></i>
                    <span>catatan</span>
                </a>
            </li>
            @endif

            {{-- Menu Catatan - untuk semua role --}}
            <li class="nav-item">
                <a href="{{ route('public.catatans.index') }}" class="nav-link">
                    <i class="fas fa-columns"></i>
                    <span>user Catatan</span>
                </a>
            </li>

        </ul>
    </aside>
</div>