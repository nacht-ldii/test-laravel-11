@auth
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
        <a href="">LARAVEL</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
        <a href="">LARAVEL</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('home') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            @if (Auth::user()->role == 'superadmin')
            <li class="menu-header">Hak Akses</li>
            <li class="{{ Request::is('hakakses') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('hakakses') }}"><i class="fas fa-user-shield"></i> <span>Hak Akses</span></a>
            </li>
            @endif
            <li class="menu-header">Product</li>
            <li class="{{ Request::is('table-example') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('table-example') }}"><i class="fas fa-book"></i> <span>Books</span></a>
            </li>
            <li class="{{ Request::is('categories') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('categories') }}"><i class="fas fa-list"></i> <span>Categories</span></a>
            </li>
        </ul>
    </aside>
</div>
@endauth
