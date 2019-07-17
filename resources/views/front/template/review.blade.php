@if (isset($reviews) && count($reviews) > 0)
    @foreach($reviews as $review)
        <div class="review-item clearfix">
            <div class="review-item-submitted">
                <strong>{{ $review->user['username'] }}</strong>
                <em>{{ $review['created_at'] }}</em>
            </div>
            <div class="review-item-content">
                <p>{{ $review['review'] }}</p>
            </div>
        </div>
    @endforeach
@else
    <p>此商品暫無評價</p>
@endif