@extends('front.layouts.main')

@section('title', 'Shop UI')

@section('custom_css')
<!-- Page level plugin styles START -->
<link href="{{ asset('front/pages/css/animate.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('front/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('front/plugins/owl.carousel/assets/owl.carousel.css') }}" rel="stylesheet" type="text/css">
<!-- Page level plugin styles END -->

<!-- Theme styles START -->
<link href="{{ asset('front/pages/css/components.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('front/pages/css/style-shop.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('front/corporate/css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('front/corporate/css/style-responsive.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('front/corporate/css/themes/red.css') }}" rel="stylesheet" type="text/css" id="style-color">
<link href="{{ asset('front/corporate/css/custom.css') }}" rel="stylesheet" type="text/css">
<!-- Theme styles END -->
@endsection

@section('content')
<div class="main">
    <div class="container">
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
            <!-- BEGIN CONTENT -->
            <div class="col-xs-12">
                <h1>會員中心</h1>
                @if (session('msg'))
                    <div class="alert {{ session()->get('msg')['type'] }}" role="alert">
                        {{ session()->get('msg')['content'] }}
                    </div>
                @endif
                <div class="content-page">
                    <h3>帳戶相關</h3>
                    <ul>
                        <li><a href="{{ route('account.edit')}}">修改帳戶資料</a></li>
                        <li><a href="{{ route('wishlist.index') }}">追蹤清單</a></li>
                    </ul>
                    <hr>
                    <h3>訂單相關</h3>
                    <ul>
                        <li><a href="javascript:;">訂單查詢</a></li>
                    </ul>
                    <hr>
                    <h3>其他</h3>
                    <ul>
                        <li><a href="javascript:;">常見問題</a></li>
                    </ul>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
    </div>
</div>
@endsection

@section('custom_script')
<!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
<script src="{{ asset('front/plugins/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script><!-- pop up -->
<script src="{{ asset('front/plugins/owl.carousel/owl.carousel.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('front/corporate/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ asset('front/pages/scripts/bs-carousel.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        Layout.init();
        Layout.initOWL();
        Layout.initTwitter();
    });
</script>
<!-- END PAGE LEVEL JAVASCRIPTS -->
@endsection