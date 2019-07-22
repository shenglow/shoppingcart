@extends('front.layouts.main')

@section('title', 'Shop UI')

@section('extra_meta')
<!-- provide the csrf token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('custom_css')
<!-- Page level plugin styles START -->
<link href="{{ asset('front/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet">
<link href="{{ asset('front/plugins/owl.carousel/assets/owl.carousel.css') }}" rel="stylesheet">
<link href="{{ asset('front/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css">
<!-- Page level plugin styles END -->

<!-- Theme styles START -->
<link href="{{ asset('front/pages/css/components.css') }}" rel="stylesheet">
<link href="{{ asset('front/corporate/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('front/pages/css/style-shop.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('front/corporate/css/style-responsive.css') }}" rel="stylesheet">
<link href="{{ asset('front/corporate/css/themes/red.css') }}" rel="stylesheet" id="style-color">
<link href="{{ asset('front/corporate/css/custom.css') }}" rel="stylesheet">
<!-- Theme styles END -->
@endsection

@section('content')
<div class="main">
    <div class="container">
        <div class="row margin-bottom-40 ">
            <!-- BEGIN CONTENT -->
            <div class="col-md-12 col-sm-12">
                <h1>結帳</h1>
                @if (session('msg'))
                    <div class="alert {{ session()->get('msg')['type'] }}" role="alert">
                        {{ session()->get('msg')['content'] }}
                    </div>
                @endif
                <form action="{{ url('/checkout') }}" method="POST">
                    {{ csrf_field() }}
                    <!-- BEGIN CHECKOUT PAGE -->
                    <div class="panel-group checkout-page accordion scrollable" id="checkout-page">
                        <!-- BEGIN PAYMENT ADDRESS -->
                        <div id="payment-address" class="panel panel-default">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#checkout-page" href="#payment-address-content" class="accordion-toggle">
                                        Step 1: 訂購人資訊
                                    </a>
                                </h2>
                            </div>
                            <div id="payment-address-content" class="panel-collapse collapse in">
                                <div class="panel-body row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="orderer_name">姓名 <span class="require">*</span></label>
                                            <input type="text" name="orderer_name" id="orderer_name" class="form-control" value="{{ old('orderer_name') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="orderer_email">E-Mail <span class="require">*</span></label>
                                            <input type="text" name="orderer_email" id="orderer_email" class="form-control" value="{{ old('orderer_email') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="orderer_tel">電話 <span class="require">*</span></label>
                                            <input type="text" name="orderer_tel" id="orderer_tel" class="form-control" value="{{ old('orderer_tel') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="orderer_add">地址 <span class="require">*</span></label>
                                            <input type="text" name="orderer_add" id="orderer_add" class="form-control" value="{{ old('orderer_add') }}">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary pull-right" type="button" data-toggle="collapse" data-parent="#checkout-page" data-target="#shipping-address-content">下一步</button>                     
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PAYMENT ADDRESS -->

                        <!-- BEGIN SHIPPING ADDRESS -->
                        <div id="shipping-address" class="panel panel-default">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#checkout-page" href="#shipping-address-content" class="accordion-toggle">
                                        Step 2: 收件人資訊
                                    </a>
                                </h2>
                            </div>
                            <div id="shipping-address-content" class="panel-collapse collapse">
                                <div class="panel-body row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="recipient_name">姓名 <span class="require">*</span></label>
                                            <input type="text" name="recipient_name" id="recipient_name" class="form-control" value="{{ old('recipient_name') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient_email">E-Mail <span class="require">*</span></label>
                                            <input type="text" name="recipient_email" id="recipient_email" class="form-control" value="{{ old('recipient_email') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="recipient_tel">電話 <span class="require">*</span></label>
                                            <input type="text" name="recipient_tel" id="recipient_tel" class="form-control" value="{{ old('recipient_tel') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient_add">地址 <span class="require">*</span></label>
                                            <input type="text" name="recipient_add" id="recipient_add" class="form-control" value="{{ old('recipient_add') }}">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="sync_info" id="sync_info" value="1" @if (old('sync_info')) checked @endif>同訂購人資訊
                                            </label>
                                        </div>
                                        <button class="btn btn-primary  pull-right" type="button" data-toggle="collapse" data-parent="#checkout-page" data-target="#confirm-content">下一步</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END SHIPPING ADDRESS -->

                        <!-- BEGIN CONFIRM -->
                        <div id="confirm" class="panel panel-default">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#checkout-page" href="#confirm-content" class="accordion-toggle">
                                        Step 3: 確認訂單
                                    </a>
                                </h2>
                            </div>
                            <div id="confirm-content" class="panel-collapse collapse">
                                <div class="panel-body row">
                                    <div class="col-md-12 clearfix">
                                        <div class="table-wrapper-responsive">
                                            <table>
                                                <tr>
                                                    <th class="checkout-image">圖片</th>
                                                    <th class="checkout-description">描述</th>
                                                    <th class="checkout-quantity">數量</th>
                                                    <th class="checkout-price">單價</th>
                                                    <th class="checkout-total">小計</th>
                                                </tr>
                                                @foreach ($allCart as $psid => $product)
                                                    @php
                                                        $arr_img = explode(',', $product['image']);
                                                    @endphp
                                                <tr>
                                                    <td class="checkout-image">
                                                        <img src="{{ asset($product['path'].'/'.$arr_img[0]) }}" alt="{{ $product['name'] }}">
                                                    </td>
                                                    <td class="checkout-description">
                                                        <h3>{{ $product['name'] }}</h3>
                                                        <p>{{ $product['specification'] }}</p>
                                                        <em>{{ $product['description'] }}</em>
                                                    </td>
                                                    <td class="checkout-quantity">{{ $product['quantity'] }}</td>
                                                    <td class="checkout-price"><strong>{{ '$'.number_format($product['price']) }}</strong></td>
                                                    <td class="checkout-total"><strong>{{ '$'.number_format($product['total']) }}</td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    <div class="checkout-total-block">
                                        <ul>
                                            <li class="checkout-total-price">
                                                <em>總價</em>
                                                <strong class="price">{{ $topCart['total'] }}</strong>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="clearfix"></div>
                                    <button class="btn btn-primary pull-right" type="submit" id="button-confirm">確認</button>
                                    <a href="{{ url('/shoppingcart') }}" class="btn btn-default pull-right margin-right-20">取消</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END CONFIRM -->
                    </div>
                    <!-- END CHECKOUT PAGE -->
                </form>
          </div>
          <!-- END CONTENT -->
        </div>
    </div>
</div>
@endsection

@section('custom_script')
<!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
<script src="{{ asset('front/plugins/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script><!-- pop up -->
<script src="{{ asset('front/plugins/owl.carousel/owl.carousel.min.js') }}" type="text/javascript"></script><!-- slider for products -->
<script src="{{ asset('front/plugins/zoom/jquery.zoom.min.js') }}" type="text/javascript"></script><!-- product zoom -->
<script src="{{ asset('front/plugins/bootstrap-touchspin/bootstrap.touchspin.js') }}" type="text/javascript"></script><!-- Quantity -->
<script src="{{ asset('front/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('front/corporate/scripts/layout.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        Layout.init();
        Layout.initOWL();
        Layout.initTwitter();
        Layout.initImageZoom();
        Layout.initTouchspin();
        Layout.initUniform();
    });

    $('#sync_info').on('click', function() {
        if ($(this).is(':checked')) {
            $('#recipient_name').val($('#orderer_name').val());
            $('#recipient_email').val($('#orderer_email').val());
            $('#recipient_tel').val($('#orderer_tel').val());
            $('#recipient_add').val($('#orderer_add').val());
        } else{
            $('#recipient_name').val('');
            $('#recipient_email').val('');
            $('#recipient_tel').val('');
            $('#recipient_add').val('');
        }
    });
</script>
<!-- END PAGE LEVEL JAVASCRIPTS -->
@endsection