<div class="sidebar-products clearfix">
    <h2>熱門商品</h2>
    @foreach ($popular_products as $key => $category_products)
        @foreach ($category_products->getRelation('products') as $product)
            @php
                $arr_img = explode(',', $product->image);
            @endphp
            <div class="item">
                <a href="#"><img src="{{ asset($product->path.'/'.$arr_img[0]) }}" alt="{{ $product->name }}"></a>
                <h3><a href="{{ url('product', [$product->cid, $product->pid]) }}">{{ $product->name }}</a></h3>
                <div class="price">${{ number_format($product->price) }}</div>
            </div>
        @endforeach
    @endforeach
</div>