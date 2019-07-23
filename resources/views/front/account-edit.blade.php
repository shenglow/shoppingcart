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
                <h1>會員中心 - 修改帳戶資料</h1>
                @if (session('msg'))
                    <div class="alert {{ session()->get('msg')['type'] }}" role="alert">
                        {{ session()->get('msg')['content'] }}
                    </div>
                @endif
                <div class="content-form-page">
                    <form method="POST" action="{{ route('account.update') }}" role="form" class="form-horizontal form-without-legend">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-xs-2 control-label" for="email">E-Mail <span class="require">*</span></label>
                            <div class="col-xs-8">
                                <input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label" for="original_password">舊密碼 </label>
                            <div class="col-xs-8">
                                <input type="password" name="original_password" id="original_password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label" for="new_password">新密碼 </label>
                            <div class="col-xs-8">
                                <input type="password" name="new_password" id="new_password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label" for="repeat_password">確認密碼 </label>
                            <div class="col-xs-8">
                                <input type="password" name="repeat_password" id="repeat_password" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-offset-2 padding-left-0 padding-top-20">
                                <button class="btn btn-primary" type="submit">修改</button>
                            </div>
                        </div>
                    </form>
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