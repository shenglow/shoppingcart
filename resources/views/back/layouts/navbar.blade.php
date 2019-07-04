<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-store"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Shop Admin</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item @yield('nav_index')">
    <a class="nav-link" href="{{ route('admin.') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>儀表板</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Product
</div>

<!-- Nav Item - Charts -->
<li class="nav-item @yield('nav_category')">
    <a class="nav-link" href="{{ route('admin.category.index') }}">
        <i class="fas fa-fw fa-tag"></i>
        <span>類別設定</span>
    </a>
</li>

<!-- Nav Item - Charts -->
<li class="nav-item @yield('nav_product')">
    <a class="nav-link" href="products.html">
        <i class="fas fa-fw fa-archive"></i>
        <span>商品管理</span>
    </a>
</li>

<!-- Nav Item - Charts -->
<li class="nav-item @yield('nav_product_main')">
    <a class="nav-link" href="product-main.html">
        <i class="fas fa-fw fa-bullhorn"></i>
        <span>主打商品設定</span>
    </a>
</li>

<!-- Nav Item - Charts -->
<li class="nav-item @yield('nav_product_order')">
    <a class="nav-link" href="product-orders.html">
        <i class="fas fa-fw fa-paste"></i>
        <span>訂單管理</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Other
</div>

<!-- Nav Item - Tables -->
<li class="nav-item @yield('nav_setting')">
    <a class="nav-link" href="settings.html">
        <i class="fas fa-fw fa-key"></i>
        <span>系統設定</span>
    </a>
</li>

<!-- Nav Item - Tables -->
<li class="nav-item @yield('nav_faq')">
    <a class="nav-link" href="faq.html">
        <i class="fas fa-fw fa-table"></i>
        <span>常見問題</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->