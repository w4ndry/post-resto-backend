<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('home') }}">Padang Resto</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('home') }}">PR</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('home') }}"
                    class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'users' ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('users') }}"><i class="far fa-user"></i> <span>Users</span></a>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'products' ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('products') }}"><i class="fa-solid fa-cart-plus"></i> <span>Products</span></a>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'categories' ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('categories') }}"><i class="fa-solid fa-tag"></i></i> <span>Categories</span></a>
            </li>
        </ul>
    </aside>
</div>
