@extends('back.layouts.main')

@section('title', 'Shop Admin')

@section('nav_order', 'active')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTables -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">訂單管理 - 訂單明細</h6>
        </div>
        <div class="card-body">
            <div>
                <h4 class="card-title">訂購人資訊</h4>
                <hr>
                <dl class="row">
                    <dt class="col-3">姓名</dt>
                    <dd class="col-9">
                        <p>{{ $order->orderer_name }}</p>
                    </dd>
                
                    <dt class="col-3">Email</dt>
                    <dd class="col-9">
                        <p>{{ $order->orderer_email }}</p>
                    </dd>
                
                    <dt class="col-3">電話</dt>
                    <dd class="col-9">
                        <p>{{ $order->orderer_tel }}</p>
                    </dd>
                
                    <dt class="col-3">地址</dt>
                    <dd class="col-9">
                        <p>{{ $order->orderer_add }}</p>
                    </dd>
                </dl>
            </div>
            <div>
                <h4 class="card-title">收件人資訊</h4>
                <hr>
                <dl class="row">
                    <dt class="col-3">姓名</dt>
                    <dd class="col-9">
                        <p>{{ $order->recipient_name }}</p>
                    </dd>
                
                    <dt class="col-3">Email</dt>
                    <dd class="col-9">
                        <p>{{ $order->recipient_email }}</p>
                    </dd>
                
                    <dt class="col-3">電話</dt>
                    <dd class="col-9">
                        <p>{{ $order->recipient_tel }}</p>
                    </dd>
                
                    <dt class="col-3">地址</dt>
                    <dd class="col-9">
                        <p>{{ $order->recipient_add }}</p>
                    </dd>
                </dl>
            </div>
            <div>
                <h4 class="card-title">商品列表</h4>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered text-center" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                            <th width="20%">圖片</th>
                            <th width="20%">描述</th>
                            <th width="20%">數量</th>
                            <th width="10%">單價</th>
                            <th width="20%">小計</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderProducts as $orderProduct)
                                @php
                                    $arr_msg = explode(',', $orderProduct->product->image)
                                @endphp
                            <tr>
                                <td><img src="{{ asset($orderProduct->product->path.'/'.$arr_msg[0]) }}" alt="{{ $orderProduct->product->name }}" class="img-thumbnail"></td>
                                <td>
                                    {{ $orderProduct->product->name }}
                                    <br>
                                    {{ $orderProduct->specification->specification }}
                                    <br>
                                    {{ $orderProduct->product->description }}
                                </td>
                                <td>{{ $orderProduct->quantity }}</td>
                                <td>{{ $orderProduct->price }}</td>
                                <td>{{ $orderProduct->quantity * $orderProduct->price }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <div class="row float-right">
                <div class="col">
                    <a href="{{ route('admin.order') }}" class="btn btn-primary"><span class="text">回上一頁</span></a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection