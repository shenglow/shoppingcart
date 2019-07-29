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

@section('navbar-popular')
    @include('front/layouts/navbar-popular')
@endsection

@section('content')
<div class="main">
    <div class="container">
        <div class="row margin-bottom-40 ">
            @include('front/layouts/navbar')

            <!-- BEGIN CONTENT -->
            <div class="col-md-9 col-sm-7">
                <div class="row list-view-sorting clearfix">
                    <form method="GET" action="{{ url('product-lists', $cid) }}">
                        <div class="col-sm-12">
                            <div class="pull-right">
                                <label class="control-label">Show:</label>
                                <select class="form-control input-sm" id="page">
                                    <option>10</option>
                                    <option>20</option>
                                    <option>30</option>
                                    <option>40</option>
                                    <option>50</option>
                                </select>
                            </div>
                            <div class="pull-right">
                                <label class="control-label">Sort&nbsp;By:</label>
                                <select class="form-control input-sm" id="order">
                                    <option value="default">預設排序</option>
                                    <option value="name-asc" @if($order == 'name-asc') selected @endif>名稱 (小 - 大)</option>
                                    <option value="name-desc" @if($order == 'name-desc') selected @endif>名稱 (大 - 小)</option>
                                    <option value="price-asc" @if($order == 'price-asc') selected @endif>價格 (低 &gt; 高)</option>
                                    <option value="price-desc" @if($order == 'price-desc') selected @endif>價格 (高 &gt; 低)</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- BEGIN PRODUCT LIST -->
                <div class="row product-list">
                @foreach ($products->items() as $product)
                    @php
                        $arr_img = explode(',', $product->image);
                    @endphp
                    <!-- PRODUCT ITEM START -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
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
                    </div>
                    <!-- PRODUCT ITEM END -->
                @endforeach
                </div>

                <!-- BEGIN PAGINATOR -->
                <div class="row">
                    <div class="col-md-4 col-sm-4 items-info">Items {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{$products->total()}} total</div>
                    <div class="col-md-8 col-sm-8">
                        <ul class="pagination pull-right">
                        @if (!$products->onFirstPage())
                            <li><a href="{{ $products->previousPageUrl() }}">&laquo;</a></li>
                        @else
                            <li><a href="#">&laquo;</a></li>
                        @endif
                        
                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                            @if ($i == $products->currentPage())
                                <li><span>{{ $i }}</span></li>
                            @else
                                <li><a href="{{ $products->url($i) }}">{{ $i }}</a></li>
                            @endif
                        @endfor

                        @if (!($products->currentPage() == $products->lastPage()))
                            <li><a href="{{ $products->nextPageUrl() }}">&raquo;</a></li>
                        @else
                            <li><a href="#">&raquo;</a></li>
                        @endif
                        </ul>
                    </div>
                </div>
                <!-- END PAGINATOR -->
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

        $('#page').on('change', function(e){
            var page = $(this);
            var order = $('#order');
            var form = page.closest('form');
            var action = page.closest('form').attr('action');
            form.attr('action', action + '/order/' + order.val() + '/perpage/' + page.val());
            form.submit();
        });

        $('#order').on('change', function(e){
            var page = $('#page');
            var order = $(this);
            var form = order.closest('form');
            var action = order.closest('form').attr('action');
            form.attr('action', action + '/order/' + order.val() + '/perpage/' + page.val());
            form.submit();
        });
    });
</script>
<!-- END PAGE LEVEL JAVASCRIPTS -->
@endsection