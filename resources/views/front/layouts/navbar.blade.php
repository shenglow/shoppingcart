<!-- BEGIN SIDEBAR -->
<div class="sidebar col-md-3 col-sm-4">
    <ul class="list-group margin-bottom-25 sidebar-menu">
        @foreach ($categories as $name => $category)
            <li class="list-group-item clearfix dropdown">
                <a href="#">
                    <i class="fa fa-angle-right"></i>
                    {{ $name }}
                </a>
                <ul class="dropdown-menu">
                    @foreach ($category as $subcategory)
                        <li><a href="#"><i class="fa fa-angle-right"></i> {{ $subcategory['subname'] }}</a></li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</div>
<!-- END SIDEBAR -->