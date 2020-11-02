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


    <!---------------------------------- START 自分の感想 -------------------------------->
    <div class="show__subtitle"><i class="far fa-smile"></i>あなたのレビュー</div>
    <div class="show__my-review">
        @if($review)
        <div class="show__user-icon">
            @if($user->icon)
            <img src="{{ $user->icon }}" alt="プロフィール画像">
            @else
            <img src="https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/default.png" alt="プロフィール画像">
            @endif
            {{$user->myProfile->nickname ?? $user->name}} {{ $review->dateFormat($review->created_at)}}
        </div>


        <!-- 読書済みにしているが、レビューはしていない。 -->
        <div class="show__no-review">
            @if(!$review->body)
            {{$user->myProfile->nickname ?? $user->name}}さんは、まだレビューしていません。
            @endif
        </div>

        @if(substr_count($review->body, "\n") < 5) <p class="show__comment">{{ $review->body }}</p>
            @else
            <div class="grad-wrap">
                <input id="trigger1" class="grad-trigger" type="checkbox">
                <p class="show__comment grad-item">{{ $review->body }}</p>
                <label class="grad-btn" for="trigger1"></label>
            </div>
            @endif

            <div class="show__my-flex">
                <div class="show__options">
                    <!-- いいねボタン機能(Vueコンポーネント) -->
                    <review-like :initial-like="@json($review->isLiked($user_id))" :initial-count-likes="@json($review->count_likes)" like-route="{{ route('books.like',['reading_record_id'=>$review->id])}}"></review-like>

                    <!-- 評価 -->
                    @if($review->rating)
                    <div class="show__rating">
                        <i class="fas fa-star c-rating"></i>{{$review->rating}}
                    </div>

                    @endif
                </div>

                <div class="show__btn">
                    <!-- START もしも、まだ自分の感想が登録されていないならば、編集ボタン・削除ボタンは表示しない。 -->
                    <!-- モーダル 感想の編集 -->
                    <button type="button" class="btn btn-dark letter-white" data-toggle="modal" data-target="#edit">編集</button>
                    <button type="button" class="btn btn-danger letter-white" data-toggle="modal" data-target="#delete-{{ $review->id }}">削除</button>

                    <!-- 編集モーダル -->
                    @include('includes.edit-book-form')

                    <!-- 削除モーダル -->
                    @include('includes.delete-book-form')
                </div>
            </div>

            @else

            <!------------------- まだ、読書済みに登録していない。 ---------------------->
            <div class="show__user-icon">
                @if($user->icon)
                <img src="{{ $user->icon }}" alt="プロフィール画像" width="30px" width="30px">
                @else
                <img src="https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/default.png" alt="プロフィール画像" width="200px" width="200px">
                @endif
                {{$user->myProfile->nickname ?? $user->name}}
            </div>


            <p class="show__no-register">まだ、あなたの本棚に追加されていません。</p>

            <div class="show__no-register-btn">
                <button type="button" class="" data-toggle="modal" data-target="#{{ 'a-'.$item->Item->isbn }}">
                    本を登録する。
                </button>
            </div>

            @include('includes.rakuten_books.rakuten-book-register')

            @endif
    </div>

    <!---------------------------------- END 自分の感想 -------------------------------->


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

        <!-- 読書済み、かつレビュー登録済みの場合　 -->
        @if($other_review->body)

        <!-- ネタバレマーク -->
        <div class="netabare__{{$other_review->netabare}}-mark"></div>

        <div class="netabare__{{ $other_review->netabare}}">
            @if(substr_count($other_review->body, "\n") < 5) <p class="show__comment">{{ $other_review->body }}</p>
                @else
                <div class="grad-wrap">
                    <input id="trigger{{$other_review->id}}" class="grad-trigger" type="checkbox">
                    <p class="show__comment grad-item">{{ $other_review->body }}</p>
                    <label class="grad-btn" for="trigger{{$other_review->id }}"></label>
                </div>
                @endif
        </div>

        <!-- 読書済みにしているが、レビューはしていない場合　 -->
        @else
        <div class="show__no-review">
            {{$other_review->user->myProfile->nickname ?? $other_review->user->name}}さんは、まだレビューしていません。
        </div>
        @endif

        <!-- いいね、書籍評価 -->
        <div class="show__options">
            <!-- いいねボタン機能(Vueコンポーネント) -->
            <review-like :initial-like="@json($other_review->isLiked($user_id))" :initial-count-likes="@json($other_review->count_likes)" like-route="{{ route('books.like',['reading_record_id'=>$other_review->id])}}"></review-like>

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
    <p class="show__no-review">まだレビューがありません。</p>
    @endif

    <!-- レビューのペジネーション -->
    {{$others_reviews->links()}}
</div>