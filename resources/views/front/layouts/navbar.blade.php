<!-- BEGIN SIDEBAR -->
<div class="sidebar col-md-3 col-sm-4">
    <ul class="list-group margin-bottom-25 sidebar-menu">
        @foreach ($categories as $name => $category)
            <li class="list-group-item clearfix dropdown @isset ($category['cid']) {{ 'active' }} @endisset">
                <a href="#">
                    <i class="fa fa-angle-right"></i>
                    {{ $name }}
                </a>
                <ul class="dropdown-menu" style="@isset ($category['cid']) {{ 'display:block;' }} @endisset">
                    @foreach ($category['subcategory'] as $subcategory)
                        <li class="@if (isset($category['cid']) && $category['cid'] == $subcategory['cid']) {{ 'active' }} @endif"><a href="{{ url('product-lists', $subcategory['cid']) }}"><i class="fa fa-angle-right"></i> {{ $subcategory['subname'] }}</a></li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>

    @yield('navbar-popular')

</div>
<!-- END SIDEBAR -->