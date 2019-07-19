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
<link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css"><!-- for slider-range -->
<link href="{{ asset('front/plugins/rateit/src/rateit.css" rel="stylesheet') }}" type="text/css">
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
        <!-- BEGIN CONTENT -->
        <div class="row margin-bottom-40">
            <div class="col-md-12 col-sm-12">
                <h1>我的購物車</h1>
                <div class="shopping-cart-page @if (count($allCart) > 0) hide @endif" id="shopping-cart-page">
                    <div class="shopping-cart-data clearfix">
                        <p>您的購物車沒有商品!</p>
                    </div>
                </div>
                <div class="goods-page @if (count($allCart) <= 0) hide @endif"" id="goods-page">
                    <div class="goods-data clearfix">
                        <div class="table-wrapper-responsive">
                            <table summary="Shopping cart">
                                <tr>
                                    <th class="goods-page-image">圖片</th>
                                    <th class="goods-page-description">描述</th>
                                    <th class="goods-page-quantity">數量</th>
                                    <th class="goods-page-price">單價</th>
                                    <th class="goods-page-total" colspan="2">小計</th>
                                </tr>
                                @foreach ($allCart as $psid => $product)
                                    @php
                                        $arr_img = explode(',', $product['image']);
                                    @endphp
                                <tr>
                                    <td class="goods-page-image">
                                        <a href="{{ url('product', [ $product['cid'], $product['pid'] ]) }}"><img src="{{ asset($product['path'].'/'.$arr_img[0]) }}" alt="{{ $product['name'] }}"></a>
                                    </td>
                                    <td class="goods-page-description">
                                        <h3><a href="{{ url('product', [ $product['cid'], $product['pid'] ]) }}">{{ $product['name'] }}</a></h3>
                                        <p>{{ $product['specification'] }}</p>
                                        <em>{{ $product['description'] }}</em>
                                    </td>
                                    <td class="goods-page-quantity">
                                        <div class="product-quantity">
                                            <input name="quantity" type="text" value="{{ $product['quantity'] }}" data-max="{{ $product['remain_quantity'] }}" data-url="{{ route('shoppingcart.update', $psid) }}" readonly class="form-control input-sm">
                                        </div>
                                    </td>
                                    <td class="goods-page-price">
                                        <strong>{{ '$'.number_format($product['price']) }}</strong>
                                    </td>
                                    <td class="goods-page-total">
                                        <strong>{{ '$'.number_format($product['total']) }}</strong>
                                    </td>
                                    <td class="del-goods-col">
                                        <a class="del-goods" href="javascript:;" data-url="{{ route('shoppingcart.destroy', $psid) }}">&nbsp;</a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>

                        <div class="shopping-total">
                            <ul>
                                <li class="shopping-total-price">
                                    <em>總價</em>
                                    <strong class="price" id="price">{{ $topCart['total'] }}</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <a class="btn btn-default" href="{{ url('/') }}">繼續購物 <i class="fa fa-shopping-cart"></i></a>
                    <a class="btn btn-primary" href="javascript:;">結帳 <i class="fa fa-check"></i></a>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
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
<script src="{{ asset('front/plugins/rateit/src/jquery.rateit.js') }}" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script><!-- for slider-range -->

<script src="{{ asset('front/corporate/scripts/layout.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        Layout.init();    
        Layout.initOWL();
        Layout.initTwitter();
        Layout.initImageZoom();
        Layout.initTouchspin();
        Layout.initUniform();

        $('input[name=quantity]').trigger("touchspin.updatesettings", {max: $(this).attr("data-max")});

        $('input[name=quantity]').on('touchspin.on.startspin', function () {
            var itemTotal = $(this).closest('tr').find('.goods-page-total');
            var quantity = $(this).val();
            var url = $(this).attr("data-url");
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.postJSON(url, { _method : 'put', _token : CSRF_TOKEN , quantity : quantity }, function(data) {
                if (data.err == 'false') {
                    if (data.result.length != 0) {
                        $('#cart-count').text(data.result.count + ' 項商品');
                        $('#cart-total').text(data.result.total);

                        $('#price').text(data.result.total);
                        itemTotal.html('<strong>' + data.result.itemTotal + '</strong>')
                    }
                } else {
                    alert(data.err_msg);
                };
            })
        });

        $('.del-goods').on('click', function() {
            var tr = $(this).closest('tr');
            var url = $(this).attr("data-url");
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.postJSON(url, { _method : 'delete', _token : CSRF_TOKEN }, function(data) {
                if (data.err == 'false') {
                    if (data.result.length != 0) {
                        $('#cart-count').text(data.result.count + ' 項商品');
                        $('#cart-total').text(data.result.total);

                        $('#price').text(data.result.total);

                        if (data.result.count == 0) {
                            $('#shopping-cart-page').removeClass('hide');
                            $('#goods-page').addClass('hide');
                        }
                    }
                    tr.remove();
                } else {
                    alert(data.err_msg);
                };
            })
            return false;
        });
    });
</script>
<!-- END PAGE LEVEL JAVASCRIPTS -->
@endsection