@extends('front.layouts.main')

@section('title', 'Shop UI')

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

@section('navbar-popular')
    @include('front/layouts/navbar-popular')
@endsection

@section('content')
<div class="main">
    <div class="container">
        <div class="row margin-bottom-40 ">
            @include('front/layouts/navbar')

            @php
                $arr_img = explode(',', $product->image);
            @endphp

            <!-- BEGIN CONTENT -->
            <div class="col-md-9 col-sm-7">
                <div class="product-page">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="product-main-image">
                                <img src="{{ asset($product->path.'/'.$arr_img[0]) }}" alt="{{ $product->name }}" class="img-responsive" data-BigImgsrc="{{ asset($product->path.'/'.$arr_img[0]) }}">
                            </div>
                            @if (count($arr_img) > 1)
                            <div class="product-other-images">
                                @for ($i = 1;$i < count($arr_img) - 1;$i++)
                                    <a href="{{ asset($product->path.'/'.$arr_img[$i]) }}" class="fancybox-button" rel="photos-lib"><img alt="{{ $product->name }}" src="{{ asset($product->path.'/'.$arr_img[$i]) }}"></a>
                                @endfor
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <h1>{{ $product->name }}</h1>
                            <div class="price-availability-block clearfix">
                                <div class="price">
                                    <strong>${{ number_format($product->price) }}</strong>
                                </div>
                            </div>
                            <div class="description">
                                <p>{{ $product->description }}</p>
                            </div>
                            @if (count($specification) > 0)
                                <div class="product-page-options">
                                    <div class="pull-left">
                                        <label class="control-label">規格:</label>
                                        <select class="form-control input-sm" id="spec">
                                        @foreach ($specification as $value)
                                            <option value="{{ $value->pid.'-'.$value->psid }}" data-quantity="{{ $value->quantity }}">{{ $value->specification }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="product-page-cart">
                                    <div class="product-quantity">
                                        <input id="product-quantity" type="text" value="0" readonly class="form-control input-sm">
                                    </div>
                                    <button class="btn btn-primary" type="button">Add to cart</button>
                                    <button class="btn btn-primary" type="button">Add to wishlist</button>
                                </div>
                            @else
                                <div class="product-page-cart">
                                    <span>庫存不足</span>
                                    <button class="btn btn-primary" type="button">Add to wishlist</button>
                                </div>
                            @endif
                        </div>

                        <div class="product-page-content">
                            <ul class="nav nav-tabs">
                                <li><a href="#Description" data-toggle="tab">描述</a></li>
                                <li class="active"><a href="#Reviews" data-toggle="tab">評論</a></li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade" id="Description">
                                    <p>{!! nl2br($product->detail) !!}</p>
                                </div>
                                <div class="tab-pane fade in active" id="Reviews">
                                    <div>
                                        @include('front/template/review')
                                    </div>
                                    <!-- BEGIN FORM-->
                                    <form class="reviews-form" role="form" id="reviews-form">
                                        {{ csrf_field() }}
                                        <h2>留下評論</h2>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="8" name="review"></textarea>
                                        </div>
                                        <div class="padding-top-20">
                                            <button type="submit" class="btn btn-primary">提交</button>
                                        </div>
                                    </form>
                                    <!-- END FORM--> 
                                </div>
                            </div>
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

<script src="{{ asset('front/corporate/scripts/layout.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        Layout.init();    
        Layout.initOWL();
        Layout.initTwitter();
        Layout.initImageZoom();
        Layout.initTouchspin();
        Layout.initUniform();

        $("#spec").on("change",function() {
            var maxLL = $("#spec").find(":selected").attr("data-quantity");
            $( "#product-quantity" ).val(0);
            $( "#product-quantity" ).trigger("touchspin.updatesettings", {max: maxLL});
        });

        $("#product-quantity").trigger("touchspin.updatesettings", {max: $("#spec").find(":selected").attr("data-quantity")});

        $('#reviews-form').on('submit', function() {
            var textarea = $('#reviews-form textarea');
            var button = $('#reviews-form button');

            button.attr('disabled','true');
            $.postJSON("{{ route('product.review', $product->pid) }}", $(this).serializeArray(), function(data) {
                if (data.err == 'false') {
                    $('#Reviews div:first').html(data.review);
                    textarea.val('');
                    button.removeAttr('disabled')
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