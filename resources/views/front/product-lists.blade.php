@extends('front.layouts.main')

@section('title', 'Shop UI')

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
                        <div class="col-md-10 col-sm-10">
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
                                <select class="form-control input-sm">
                                    <option value="#?sort=p.sort_order&amp;order=ASC" selected="selected">Default</option>
                                    <option value="#?sort=pd.name&amp;order=ASC">Name (A - Z)</option>
                                    <option value="#?sort=pd.name&amp;order=DESC">Name (Z - A)</option>
                                    <option value="#?sort=p.price&amp;order=ASC">Price (Low &gt; High)</option>
                                    <option value="#?sort=p.price&amp;order=DESC">Price (High &gt; Low)</option>
                                    <option value="#?sort=rating&amp;order=DESC">Rating (Highest)</option>
                                    <option value="#?sort=rating&amp;order=ASC">Rating (Lowest)</option>
                                    <option value="#?sort=p.model&amp;order=ASC">Model (A - Z)</option>
                                    <option value="#?sort=p.model&amp;order=DESC">Model (Z - A)</option>
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
                                    <a href="{{ asset($product->path.'/'.$arr_img[0]) }}" class="btn btn-default fancybox-button">Zoom</a>
                                    <a href="#product-pop-up" class="btn btn-default fancybox-fast-view">View</a>
                                </div>
                            </div>
                            <h3><a href="#">{{ $product->name }}</a></h3>
                            <div class="pi-price">${{ number_format($product->price) }}</div>
                            <a href="javascript:;" class="btn btn-default add2cart">Add to cart</a>
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
$('#page').on('change', function(e){
    var select = $(this);
    var form = select.closest('form');
    var action = select.closest('form').attr('action');
    form.attr('action', action + '/' + select.val());
    form.submit();
});
@endsection