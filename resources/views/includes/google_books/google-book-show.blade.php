<!---------------------------------- START 書籍のAPI情報 -------------------------------->
@if(isset($item))

<!-- 書籍のイメージ画像 -->
@if(array_key_exists('imageLinks', $item['volumeInfo']))
<img src="{{ $item['volumeInfo']['imageLinks']['thumbnail'] }}" alt="書籍のイメージ"><br>
@else
<img src="https://book-review-shibucha.s3-ap-northeast-1.amazonaws.com/books/book_noimage.png" alt="書籍のイメージなし" width="200px" width="200px">
@endif

<!-- 書籍のタイトル -->
@if(array_key_exists('title', $item['volumeInfo']))
<P>{{ $item['volumeInfo']['title']}}</P>
@endif

<!-- 著者 -->
@if(array_key_exists('authors', $item['volumeInfo']))
著者：{{ $item['volumeInfo']['authors'][0] }}/
@endif

<!-- 出版日 -->
@if(array_key_exists('publishedDate', $item['volumeInfo']))
出版日：{{ $item['volumeInfo']['publishedDate'] }}
@endif

<!-- 概要 -->
@if(array_key_exists('description', $item['volumeInfo']))
<p>概要<br>{{ $item['volumeInfo']['description'] }}</p>
@endif

<!-- 本の登録者数 -->
@if(isset($review_count))
<div><i class="fas fa-user"></i>本棚登録：{{ $review_count}}人</div>
@else
<div><i class="fas fa-user"></i>本棚登録：0人</div>
@endif

<!-- 評価 -->
@if(isset($rating))
<i class="fas fa-star"></i>{{$rating}}
@else
評価：不明
@endif

@endif
<!---------------------------------- END 書籍のAPI情報 -------------------------------->

<hr>


<!---------------------------------- START 自分の感想 -------------------------------->
@if($review)

<div>
    @if($user->icon)
    <img src="{{ $user->icon }}" alt="プロフィール画像" width="30px" width="30px">
    @else
    <img src="https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/default.png" alt="プロフィール画像" width="200px" width="200px">
    @endif
    {{$user->name}} {{ $review->dateFormat($review->created_at)}}
</div>

<!-- 評価 -->
@if($review->rating)
<i class="fas fa-star"></i>{{$review->rating}}
@endif


@if(!$review->body)
<!-- 読書済みにしているが、レビューはしていない。 -->
{{$user->name}}さんは、まだレビューしていません。
@endif

<p>{{ $review->body }}</p>

<!-- いいねボタン機能(Vueコンポーネント) -->
<review-like :initial-like="@json($review->isLiked($user_id))" :initial-count-likes="@json($review->count_likes)" like-route="{{ route('books.like',['reading_record_id'=>$review->id])}}"></review-like>

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
<!-- START もしも、まだ自分の感想が登録されていないならば、編集ボタン・削除ボタンは表示しない。 -->
<!-- モーダル 感想の編集 -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit">編集</button>
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-{{ $review->id }}">削除</button>

<!-- 編集モーダル -->
@include('includes.edit-book-form')

<!-- 削除モーダル -->
@include('includes.delete-book-form')

<!-- END モーダル-->
@endif
<!-- END もしも、まだ自分の感想が登録されていないならば、編集ボタン・削除ボタンは表示しない。 -->
<!---------------------------------- END 自分の感想 -------------------------------->


<hr>


<!---------------------------------- START 他人の感想 -------------------------------->
<div><i class="far fa-smile"></i>みんなの感想</div>
@if($others_reviews->count() > 0)
@foreach($others_reviews as $other_review)
<div>
    @if($other_review->user->icon)
    <img src="{{$other_review->user->icon}}" alt="ユーザーアイコン" width="30px" height="30px">
    @else
    <img src="https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/default.png" alt="ユーザーアイコン" width="30px" height="30px">
    @endif
    {{ $other_review->user->name }} / {{$other_review->dateFormat($other_review->created_at)}}
</div>

@if($other_review->rating)
<i class="fas fa-star"></i>評価(1~5)：{{$other_review->rating}}
@endif

<div class="netabare__{{ $other_review->netabare}}">
    <p>{{ $other_review->body }}</p>
</div>

<!-- いいねボタン機能(Vueコンポーネント) -->
<review-like :initial-like="@json($other_review->isLiked($user_id))" :initial-count-likes="@json($other_review->count_likes)" like-route="{{ route('books.like',['reading_record_id'=>$other_review->id])}}"></review-like>

<hr>
@endforeach
@else
<p>まだ他の方の感想がありません。</p>
@endif
<!---------------------------------- END 他人の感想 -------------------------------->