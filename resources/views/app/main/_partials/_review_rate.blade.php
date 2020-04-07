<div class="user-rating-rate-values">
    <div class="rating-type">
        <div class="rating-type-item">
            <svg class="star">
                <use xlink:href="{{ asset('images/sprite-inline.svg#star') }}"></use>
            </svg>
            <strong>{{ $review->quality }}</strong>
            <span>Качество</span>
        </div>

        <div class="rating-type-item">
            <svg class="star">
                <use xlink:href="{{ asset('images/sprite-inline.svg#star') }}"></use>
            </svg>
            <strong>{{ $review->professionalism }}</strong>
            <span>Профессионализм</span>
        </div>

        <div class="rating-type-item">
            <svg class="star">
                <use xlink:href="{{ asset('images/sprite-inline.svg#star') }}"></use>
            </svg>
            <strong>{{ $review->punctuality }}</strong>
            <span>Пунктуальность и вежливость</span>
        </div>
    </div>
</div>
