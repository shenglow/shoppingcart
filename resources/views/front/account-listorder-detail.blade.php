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
                <h1>會員中心 - 訂單查詢 - 訂單明細</h1>
                <div class="goods-page">
                    <div class="goods-data compare-goods clearfix">
                        <div>
                            <table>
                                <tr>
                                    <th colspan="2">
                                        <h2>訂購人資訊</h2>
                                    </th>
                                </tr>
                                <tr>
                                    <td class="compare-info">姓名</td>
                                    <td class="compare-item">
                                        {{ $order->orderer_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-info">Email</td>
                                    <td class="compare-item">
                                        {{ $order->orderer_email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-info">電話</td>
                                    <td class="compare-item">
                                        {{ $order->orderer_tel }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-info">地址</td>
                                    <td class="compare-item">
                                        {{ $order->orderer_add }}
                                    </td>
                                </tr>

                                <tr>
                                    <th colspan="2">
                                        <h2>收件人資訊</h2>
                                    </th>
                                </tr>
                                <tr>
                                    <td class="compare-info">姓名</td>
                                    <td class="compare-item">
                                        {{ $order->recipient_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-info">Email</td>
                                    <td class="compare-item">
                                        {{ $order->recipient_email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-info">電話</td>
                                    <td class="compare-item">
                                        {{ $order->recipient_tel }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-info">地址</td>
                                    <td class="compare-item">
                                        {{ $order->recipient_add }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="orders-page">
                    <div class="orders-data clearfix">
                        <div class="table-wrapper-responsive">
                            <table summary="Shopping cart">
                                <tr>
                                    <th width="20%" class="text-center">圖片</th>
                                    <th width="20%" class="text-center">描述</th>
                                    <th width="20%" class="text-center">數量</th>
                                    <th width="20%" class="text-center">單價</th>
                                    <th width="20%" class="text-center">小計</th>
                                </tr>
                                @foreach ($orderProducts as $orderProduct)
                                    @php
                                        $arr_msg = explode(',', $orderProduct->product->image)
                                    @endphp
                                    <tr>
                                        <td><img src="{{ asset($orderProduct->product->path.'/'.$arr_msg[0]) }}" alt="{{ $orderProduct->product->name }}" class="img-thumbnail"></td>
                                        <td class="text-center">
                                            {{ $orderProduct->product->name }}
                                            <br>
                                            {{ $orderProduct->specification->specification }}
                                            <br>
                                            {{ $orderProduct->product->description }}
                                        </td>
                                        <td class="text-center">{{ $orderProduct->quantity }}</td>
                                        <td class="text-center">{{ $orderProduct->price }}</td>
                                        <td class="text-center">{{ $orderProduct->quantity * $orderProduct->price }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
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