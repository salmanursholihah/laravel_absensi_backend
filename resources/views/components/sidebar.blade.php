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
            <li>

            </li>


            @endif
            {{-- Jika user login, link ke admin --}}
            @if(auth()->user()->role == 'user')
            <li>
                <a href="{{ route('messages.index', $admin->id) }}">Chat dengan Admin</a>
            </li>
            @endif

            {{-- Jika admin login, link ke semua user --}}
            @if(auth()->user()->role == 'admin')
            @foreach ($users as $user)
            <li>
                <a href="{{ route('messages.index', $user->id) }}">Chat dengan {{ $user->name }}</a>
            </li>
            @endforeach
            @endif

            {{-- Menu Catatan - untuk semua role --}}
            @if(auth()->user()->role ==='user')
            <li class="nav-item">
                <a href="{{ route('public.catatans.index') }}" class="nav-link">
                    <i class="fas fa-columns"></i>
                    <span>user Catatan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('messages.index', ['receiverId' => 1]) }}" class="nav-link">
                    <i class="fas fa-columns"></i>
                    <span>message</span>
                </a>

            </li>
            @endif

        </ul>
    </aside>
</div>