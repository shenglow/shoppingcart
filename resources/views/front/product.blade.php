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
                            <div class="review">
                                <input type="range" value="4" step="0.25" id="backing4">
                                <div class="rateit" data-rateit-backingfld="#backing4" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5">
                                </div>
                                <a href="javascript:;">7 reviews</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:;">Write a review</a>
                            </div>
                        </div>

                        <div class="product-page-content">
                            <ul id="myTab" class="nav nav-tabs">
                                <li><a href="#Description" data-toggle="tab">Description</a></li>
                                <li class="active"><a href="#Reviews" data-toggle="tab">Reviews (1)</a></li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade" id="Description">
                                    <p>{!! nl2br($product->detail) !!}</p>
                                </div>
                                <div class="tab-pane fade" id="Information">
                                    <table class="datasheet">
                                        <tr>
                                            <th colspan="2">Additional features</th>
                                        </tr>
                                        <tr>
                                            <td class="datasheet-features-type">Value 1</td>
                                            <td>21 cm</td>
                                        </tr>
                                        <tr>
                                            <td class="datasheet-features-type">Value 2</td>
                                            <td>700 gr.</td>
                                        </tr>
                                        <tr>
                                            <td class="datasheet-features-type">Value 3</td>
                                            <td>10 person</td>
                                        </tr>
                                        <tr>
                                            <td class="datasheet-features-type">Value 4</td>
                                            <td>14 cm</td>
                                        </tr>
                                        <tr>
                                            <td class="datasheet-features-type">Value 5</td>
                                            <td>plastic</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane fade in active" id="Reviews">
                                    <!--<p>There are no reviews for this product.</p>-->
                                    <div class="review-item clearfix">
                                        <div class="review-item-submitted">
                                            <strong>Bob</strong>
                                            <em>30/12/2013 - 07:37</em>
                                            <div class="rateit" data-rateit-value="5" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                        </div>                                              
                                        <div class="review-item-content">
                                            <p>Sed velit quam, auctor id semper a, hendrerit eget justo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis vel arcu pulvinar dolor tempus feugiat id in orci. Phasellus sed erat leo. Donec luctus, justo eget ultricies tristique, enim mauris bibendum orci, a sodales lectus purus ut lorem.</p>
                                        </div>
                                    </div>

                                    <!-- BEGIN FORM-->
                                    <form action="#" class="reviews-form" role="form">
                                        <h2>Write a review</h2>
                                        <div class="form-group">
                                            <label for="name">Name <span class="require">*</span></label>
                                            <input type="text" class="form-control" id="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" id="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="review">Review <span class="require">*</span></label>
                                            <textarea class="form-control" rows="8" id="review"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Rating</label>
                                            <input type="range" value="4" step="0.25" id="backing5">
                                        <div class="rateit" data-rateit-backingfld="#backing5" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5">
                                        </div>
                                        </div>
                                        <div class="padding-top-20">                  
                                            <button type="submit" class="btn btn-primary">Send</button>
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
    });
</script>
<!-- END PAGE LEVEL JAVASCRIPTS -->
@endsection