@extends('front.layouts.main')

@section('title', 'Shop UI')

@section('custom_css')
<!-- Page level plugin styles START -->
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
                <h1>常見問答</h1>
                @if (count($faqs) <= 0)
                    <div class="shopping-cart-page">
                        <div class="shopping-cart-data clearfix">
                            <p>暫時沒有問答!</p>
                        </div>
                    </div>
                @else
                    <div class="faq-page">
                        @foreach($faqs as $key => $faq)
                            @php
                                $no = $key + 1;
                            @endphp
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" href="#accordion{{$no}}">
                                        {{ $no }}.{{ $faq->question }}
                                        </a>
                                    </h4>
                                </div>
                                <div id="accordion{{$no}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                    {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
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
<script type="text/javascript">
    jQuery(document).ready(function () {
        Layout.init();
        Layout.initOWL();
        Layout.initTwitter();
    });
</script>
<!-- END PAGE LEVEL JAVASCRIPTS -->
@endsection