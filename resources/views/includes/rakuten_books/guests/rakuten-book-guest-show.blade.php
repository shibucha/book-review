<div class="show__container">

    <div class="show__info">
        @if(isset($items))
        @foreach($items as $item)
        <!-- 書籍のイメージ画像 -->
        <div class="show__flex">
            <div class="show__image show__left">
                @if(isset($item->Item->largeImageUrl))
                <img src="{{ $item->Item->largeImageUrl }}" alt="書籍のイメージ"><br>
                @else
                <img src="{{$book_image_path}}book_noimage.png" alt="書籍のイメージなし" width="200px" width="200px">
                @endif
            </div>

            <div class="show__right">
                <!-- 書籍のタイトル -->
                <div class="show__title mb-10">
                    @if(isset($item->Item->title))
                    <div>{{ $item->Item->title }}</div>
                    @endif
                </div>

                <!-- 著者 -->
                <div class="show__author mb-10">
                    @if(isset($item->Item->author))
                    <span class="font-bold">著&nbsp;者</span>：{{ $item->Item->author }}
                    @endif
                </div>

                <!-- 出版日 -->
                <div class="show__publish-date mb-10">
                    @if(isset($item->Item->salesDate))
                    <span class="font-bold">出版日</span>：{{ $item->Item->salesDate }}
                    @endif
                </div>

                <div class="show__isbn mb-10">
                    @if(isset($item->Item->isbn))
                    <span class="font-bold">ISBN</span>&nbsp;：&nbsp;{{ $item->Item->isbn }}
                    @endif
                </div>

                <!-- 概要 -->
                <div class="show__description mb-10">
                    @if(isset($item->Item->itemCaption))
                    <div class="font-bold">概&nbsp;要&nbsp;：&nbsp;</div>
                    <p class="fs-m">{{ $item->Item->itemCaption }}</p>
                    @endif
                </div>
            </div>
        </div>


        <!-- 本の登録者数 -->
        <div class="show__options">
            <div class="show__reviewer">
                @if(isset($review_count))
                <div><i class="fas fa-user"></i>本棚登録：{{ $review_count}}人</div>
                @else
                <div><i class="fas fa-user"></i>本棚登録：0人</div>
                @endif
            </div>

            <!-- 評価 -->
            <div class="show__rating">
                @if(isset($rating))
                <i class="fas fa-star c-rating"></i>{{$rating}}
                @else
                評価：不明
                @endif
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <!---------------------------------- END 書籍のAPI情報 -------------------------------->

    
    <hr>


    <!---------------------------------- START 他人の感想 -------------------------------->
    <div class="show__subtitle"><i class="far fa-smile"></i>みんなのレビュー</div>
    @if($others_reviews->count() > 0)

    @foreach($others_reviews as $other_review)
    <div class="show__other-review">
        <div class="show__user-icon">
            <a href="{{route('books.index',['user_id'=>$other_review->user->id])}}">
                @if($other_review->user->icon)
                <img src="{{$other_review->user->icon}}" alt="ユーザーアイコン" width="30px" height="30px">
                @else
                <img src="https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/default.png" alt="ユーザーアイコン" width="30px" height="30px">
                @endif
            </a>
            {{ $other_review->user->myProfile->nickname ?? $other_review->user->name }} {{$other_review->dateFormat($other_review->created_at)}}
        </div>

        <!-- ネタバレマーク -->
        <div class="netabare__{{$other_review->netabare}}-mark"></div>

        <div class="netabare__{{ $other_review->netabare}}">
            @if(mb_strlen($other_review->body) < 100) <p class="show__comment">{{ $other_review->body }}</p>
                @else
                <div class="grad-wrap">
                    <input id="trigger{{$other_review->id}}" class="grad-trigger" type="checkbox">
                    <p class="show__comment grad-item">{{ $other_review->body }}</p>
                    <label class="grad-btn" for="trigger{{$other_review->id }}"></label>
                </div>
                @endif
        </div>

        <div class="show__options">           
            <!-- 星評価 -->
            @if($other_review->rating)
            <div class="show__rating">
                <i class="fas fa-star c-rating"></i>{{$other_review->rating}}
            </div>
            @endif
        </div>
    </div>
    @endforeach

    @else
    <p class="show__no-review">まだ他の方のレビューがありません。</p>
    @endif

    <!-- レビューのペジネーション -->
    {{$others_reviews->links()}}
</div>