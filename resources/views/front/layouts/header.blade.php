<!-- BEGIN TOP BAR -->
<div class="pre-header">
    <div class="container">
        <div class="row">
            <!-- BEGIN TOP BAR MENU -->
            <div class="col-md-12 col-sm-12 additional-nav">
                <ul class="list-unstyled list-inline pull-right">
                    @if (isset($user))
                        <li>{{ $user->username }}</li>
                        <li><a href="{{ url('logout') }}">登出</a></li>
                    @else
                        <li><a href="{{ url('login') }}">登入</a></li>
                    @endif
                    <li><a href="{{ route('account.index') }}">會員中心</a></li>
                    <li><a href="{{ route('wishlist.index') }}">追蹤清單</a></li>
                    <li><a href="#">結帳</a></li>
                </ul>
            </div>
            <!-- END TOP BAR MENU -->
        </div>
    </div>
</div>
<!-- END TOP BAR -->

<!-- BEGIN HEADER -->
<div class="header">
    <div class="container">
        <a class="site-logo" href="{{ url('/') }}"><img src="{{ asset('front/corporate/img/logos/logo-shop-red.png') }}" alt="Shop UI"></a>

        <!-- BEGIN CART -->
        <div class="top-cart-block">
            <div class="top-cart-info">
                <a href="{{ route('shoppingcart.index') }}" class="top-cart-info-count" id="cart-count">{{ $topCart['count'].' 項商品' }}</a>
                <a href="{{ route('shoppingcart.index') }}" class="top-cart-info-value" id="cart-total">{{ $topCart['total'] }}</a>
            </div>
            <i class="fa fa-shopping-cart"></i>
        </div>
      <!--END CART -->
    </div>
</div>
<!-- Header END -->