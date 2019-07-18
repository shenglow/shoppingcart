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
        <div class="row margin-bottom-40 ">
            @include('front/layouts/navbar')

            <!-- BEGIN CONTENT -->
            <div class="col-md-9 col-sm-7">
                <h1>我的追蹤清單</h1>
                <div class="goods-page">
                    <div class="goods-data clearfix">
                        <div class="table-wrapper-responsive">
                            <table summary="Shopping cart">
                                <tr>
                                    <th class="goods-page-image">圖片</th>
                                    <th class="goods-page-description">描述</th>
                                    <th class="goods-page-stock">庫存</th>
                                    <th class="goods-page-price" colspan="2">價格</th>
                                </tr>
                                @if (count($wishlists) > 0)
                                    @foreach ($wishlists as $wishlist)
                                        @php
                                            $arr_img = explode(',', $wishlist->product->image);

                                            $have_stock = '無';
                                            foreach ($wishlist->specification as $specification) {
                                                if ($specification->quantity > 0) {
                                                    $have_stock = '有';
                                                    break;
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td class="goods-page-image">
                                                <a href="{{ url('product',[$wishlist->product->cid, $wishlist->product->pid])}}"><img src="{{ asset($wishlist->product->path.'/'.$arr_img[0]) }}" alt="{{ $wishlist->product->name }}"></a>
                                            </td>
                                            <td class="goods-page-description">
                                                <h3><a href="{{ url('product',[$wishlist->product->cid, $wishlist->product->pid])}}">{{ $wishlist->product->name }}</a></h3>
                                                <em>{{ $wishlist->product->description }}</em>
                                            </td>
                                            <td class="goods-page-stock">
                                                {{ $have_stock  }}
                                            </td>
                                            <td class="goods-page-price">
                                                <strong><span>$</span>{{ number_format($wishlist->product->price) }}</strong>
                                            </td>
                                            <td class="del-goods-col">
                                                <a class="del-goods" href="{{ route('wishlist.destroy', $wishlist->product->pid) }}">&nbsp;</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
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

        $('.del-goods').on('click', function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var url = $(this).attr('href');
            var tr = $(this).closest('tr');

            $.postJSON(url, { _method : 'delete', _token : CSRF_TOKEN }, function(data) {
                if (data.err == 'false') {
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