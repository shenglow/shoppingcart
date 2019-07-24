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
<link href="{{ asset('front/pages/css/slider.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('front/pages/css/style-shop.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('front/corporate/css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('front/corporate/css/style-responsive.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('front/corporate/css/themes/red.css') }}" rel="stylesheet" type="text/css" id="style-color">
<link href="{{ asset('front/corporate/css/custom.css') }}" rel="stylesheet" type="text/css">
<!-- Theme styles END -->
@endsection

@section('content')
@if (count($carousels) > 0)
    <!-- BEGIN SLIDER -->
    <div class="page-slider margin-bottom-35">
        <div id="carousel-generic" class="carousel slide carousel-slider">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                @for ($i = 0;$i < count($carousels);$i++)
                    <li data-target="#carousel-generic" data-slide-to="{{ $i }}" @if($i == 0) class="active" @endif></li>
                @endfor
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                @for ($i = 0;$i < count($carousels);$i++)
                    <!-- each slide -->
                    <div class="item @if($i == 0) active @endif">
                        <div>
                            <a href={{ (!empty($carousels[$i]->href)) ? $carousels[$i]->href : "javascript:;" }}>
                                <img src="{{ asset($carousels[$i]->image) }}" alt="">
                            </a>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Controls -->
            <a class="left carousel-control carousel-control-shop" href="#carousel-generic" role="button" data-slide="prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>
            <a class="right carousel-control carousel-control-shop" href="#carousel-generic" role="button" data-slide="next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <!-- END SLIDER -->
@endif

<div class="main">
    <div class="container">
        <!-- BEGIN SALE PRODUCT & NEW ARRIVALS -->
        <div class="row margin-bottom-40">
            <!-- BEGIN SALE PRODUCT -->
            <div class="col-md-12 sale-product">
                <h2>最新商品</h2>
                <div class="owl-carousel owl-carousel5">
                    @foreach($new_products as $key => $product)
                        @php
                            $arr_img = explode(',', $product->image);
                        @endphp
                        <div class="product-item">
                            <div class="pi-img-wrapper">
                                <img src="{{ asset($product->path.'/'.$arr_img[0]) }}" class="img-responsive" alt="{{ $product->name }}">
                                <div>
                                    <a href="{{ asset($product->path.'/'.$arr_img[0]) }}" class="btn btn-default fancybox-button">放大</a>
                                </div>
                            </div>
                            <h3><a href="{{ url('product', [$product->cid, $product->pid]) }}">{{ $product->name }}</a></h3>
                            <div class="pi-price">${{ number_format($product->price) }}</div>
                            <a href="{{ url('product', [$product->cid, $product->pid]) }}" class="btn btn-default add2cart">購買</a>
                            <div class="sticker sticker-new"></div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- END SALE PRODUCT -->
        </div>
        <!-- END SALE PRODUCT & NEW ARRIVALS -->

        <div class="row margin-bottom-40 ">
            @include('front/layouts/navbar')

            <!-- BEGIN CONTENT -->
            <div class="col-md-9 col-sm-8">
                @foreach ($popular_products as $category_products)
                    @if(count($category_products->getRelation('products')) > 0)
                        <h2>{{ $category_products->subname }}</h2>
                        <div class="owl-carousel owl-carousel3">
                        @foreach ($category_products->getRelation('products') as $product)
                            @php
                                $arr_img = explode(',', $product->image);
                            @endphp
                            <div class="product-item">
                                <div class="pi-img-wrapper">
                                    <img src="{{ asset($product->path.'/'.$arr_img[0]) }}" class="img-responsive" alt="{{ $product->name }}">
                                    <div>
                                        <a href="{{ asset($product->path.'/'.$arr_img[0]) }}" class="btn btn-default fancybox-button">放大</a>
                                    </div>
                                </div>
                                <h3><a href="{{ url('product', [$product->cid, $product->pid]) }}">{{ $product->name }}</a></h3>
                                <div class="pi-price">${{ number_format($product->price) }}</div>
                                <a href="{{ url('product', [$product->cid, $product->pid]) }}" class="btn btn-default add2cart">購買</a>
                            </div>
                        @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
</div>
@endsection

@section('custom_script')
<!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
<script src="{{ asset('front/plugins/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script><!-- pop up -->
<script src="{{ asset('front/plugins/owl.carousel/owl.carousel.min.js') }}" type="text/javascript"></script>
<!-- slider for products -->
<script src="{{ asset('front/plugins/zoom/jquery.zoom.min.js') }}" type="text/javascript"></script><!-- product zoom -->
<script src="{{ asset('front/plugins/bootstrap-touchspin/bootstrap.touchspin.js') }}" type="text/javascript"></script>
<!-- Quantity -->

<script src="{{ asset('front/corporate/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ asset('front/pages/scripts/bs-carousel.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        Layout.init();
        Layout.initOWL();
        Layout.initImageZoom();
        Layout.initTouchspin();
        Layout.initTwitter();
    });
</script>
<!-- END PAGE LEVEL JAVASCRIPTS -->
@endsection