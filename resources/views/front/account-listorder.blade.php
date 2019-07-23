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
                <h1>會員中心 - 訂單查詢</h1>
                @if (session('msg'))
                    <div class="alert {{ session()->get('msg')['type'] }}" role="alert">
                        {{ session()->get('msg')['content'] }}
                    </div>
                @endif
                @if (count($orders) <= 0)
                    <div>
                        <div>
                            <p>您沒有任何訂單紀錄!</p>
                        </div>
                    </div>
                @else
                    <div class="orders-page">
                        <div class="orders-data clearfix">
                            <div>
                                <table>
                                    <tr>
                                        <th width="10%" class="text-center">訂單編號</th>
                                        <th width="15%" class="text-center">訂購日期</th>
                                        <th width="15%" class="text-center">收件人姓名</th>
                                        <th width="15%" class="text-center">收件人電話</th>
                                        <th width="20%" class="text-center">收件人地址</th>
                                        <th width="10%" class="text-center">狀態</th>
                                        <th width="15%" class="text-center"></th>
                                    </tr>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td class="text-center">
                                            {{$order->oid}}
                                        </td>
                                        <td class="text-center">
                                            {{ $order->created_at }}
                                        </td>
                                        <td class="text-center">
                                            {{ $order->recipient_name }}
                                        </td>
                                        <td class="text-center">
                                            {{ $order->recipient_tel }}
                                        </td>
                                        <td class="text-center">
                                            {{ $order->recipient_add }}
                                        </td>
                                        <td class="text-center">
                                            @switch($order->status)
                                                @case('pending')
                                                    {{ '處理中' }}
                                                    @break
                                                @case('shipped')
                                                    {{ '已出貨' }}
                                                    @break
                                                @case('cancel')
                                                    {{ '取消' }}
                                                    @break
                                                @default
                                                    {{ '未知' }}
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('account.order.show', $order->oid) }}" class="btn btn-primary">
                                                <span class="text">訂單明細</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
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