<div class="show__container">

    <div class="show__info">
        @if(isset($item))

        <!-- 書籍のイメージ画像 -->
        <div class="show__flex">
            <div class="show__image show__left">
                @if(array_key_exists('imageLinks', $item['volumeInfo']))
                <img src="{{ $item['volumeInfo']['imageLinks']['thumbnail'] }}" alt="書籍のイメージ"><br>
                @else
                <img src="https://book-review-shibucha.s3-ap-northeast-1.amazonaws.com/books/book_noimage.png" alt="書籍のイメージなし" width="200px" width="200px">
                @endif
            </div>

            <div class="show__right">
                <!-- 書籍のタイトル -->
                <div class="show__title mb-10">
                    @if(array_key_exists('title', $item['volumeInfo']))
                    <div>{{ $item['volumeInfo']['title']}}</div>
                    @endif
                </div>

                <!-- 著者 -->
                <div class="show__author mb-10">
                    @if(array_key_exists('authors', $item['volumeInfo']))
                    著　者：{{ $item['volumeInfo']['authors'][0] }}
                    @endif
                </div>

                <!-- 出版日 -->
                <div class="show__publish-date mb-10">
                    @if(array_key_exists('publishedDate', $item['volumeInfo']))
                    出版日：{{ $item['volumeInfo']['publishedDate'] }}
                    @endif
                </div>

                <!-- 概要 -->
                <div class="show__description mb-10">
                    @if(array_key_exists('description', $item['volumeInfo']))
                    <p>概要<br>{{ $item['volumeInfo']['description'] }}</p>
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

        @endif
    </div>
    <!---------------------------------- END 書籍のAPI情報 -------------------------------->

    <hr>


    <!---------------------------------- START 自分の感想 -------------------------------->
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
    @if(!$review->body)
    {{$user->name}}さんは、まだレビューしていません。
    @endif

    <p>{{ $review->body }}</p>

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

    @else
    <!-- まだ、読書済みに登録していない。 -->
    @if($user->icon)
    <img src="{{ $user->icon }}" alt="プロフィール画像" width="30px" width="30px">
    @else
    <img src="https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/default.png" alt="プロフィール画像" width="200px" width="200px">
    @endif
    {{$user->name}}
    <p>まだ、あなたの本棚に追加されていません。</p>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{ 'a-'.$item['id'] }}">
        本を登録する。
    </button>

    @include('includes.google_books.google-book-register')

    @endif


    @if($review)
    <div class="show__btn">
        <!-- START もしも、まだ自分の感想が登録されていないならば、編集ボタン・削除ボタンは表示しない。 -->
        <!-- モーダル 感想の編集 -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit">編集</button>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-{{ $review->id }}">削除</button>


    </div>
    @endif



    <hr>


    <!---------------------------------- START 他人の感想 -------------------------------->
    <div class="show__other-review">
        <div><i class="far fa-smile"></i>みんなの感想</div>
        @if($others_reviews->count() > 0)

        @foreach($others_reviews as $other_review)

        <div class="show__user-icon">
            @if($other_review->user->icon)
            <img src="{{$other_review->user->icon}}" alt="ユーザーアイコン" width="30px" height="30px">
            @else
            <img src="https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/default.png" alt="ユーザーアイコン" width="30px" height="30px">
            @endif
            {{ $other_review->user->myProfile->nickname ?? $other_review->user->name }} {{$other_review->dateFormat($other_review->created_at)}}
        </div>

        <div class="netabare__{{ $other_review->netabare}}">
            <p>{{ $other_review->body }}</p>
        </div>

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

        <hr>
        @endforeach
        @else
        <p>まだ他の方の感想がありません。</p>
        @endif
    </div>
</div>


<!-- 編集モーダル -->
@include('includes.edit-book-form')

<!-- 削除モーダル -->
@include('includes.delete-book-form')