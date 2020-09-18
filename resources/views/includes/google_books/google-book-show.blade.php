@if(isset($items))
@foreach($items as $item)

<!---------------------------------- START 書籍のAPI情報 -------------------------------->

<!-- 書籍のイメージ画像 -->
@if(array_key_exists('imageLinks', $item['volumeInfo']))
<img src="{{ $item['volumeInfo']['imageLinks']['thumbnail'] }}" alt="書籍のイメージ"><br>
@else
<img src="/storage/book/book_noimage.png" alt="書籍のイメージ" width="200px" width="200px">
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
<div><i class="fas fa-user"></i>本棚登録:{{ $review_count}}人</div>
@else
<div><i class="fas fa-user"></i>本棚登録:0人</div>
@endif

@endforeach
@endif
<!---------------------------------- END 書籍のAPI情報 -------------------------------->

<hr>


<!---------------------------------- START 自分の感想 -------------------------------->
<div>
    @if($user->icon)
    <img src="/storage/icons/{{$user->icon}}" alt="ユーザーアイコン" width="30px" height="30px">
    @else
    <img src="/storage/icons/default.png" alt="ユーザーアイコン" width="30px" height="30px">
    @endif
    {{$user->name}}さんの感想
</div>
@if($review)
<p>{{ $review->body }}</p>

<!-- いいねボタン機能(Vueコンポーネント) -->
<review-like
:initial-like = "@json($review->isLiked($user_id))"
:initial-count-likes = "@json($review->count_likes)"
like-route="{{ route('books.like',['reading_record_id'=>$review->id])}}"
></review-like>

@else
<p>まだ感想は登録されていません。</p>
@endif


@if($review) <!-- START もしも、まだ自分の感想が登録されていないならば、編集ボタン・削除ボタンは表示しない。 -->
<!-- モーダル 感想の編集 -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{ $review->book->google_book_id }}">編集</button>
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-{{ $review->id }}">削除</button>

<!-- 編集モーダル -->
@include('includes.edit-book-form')

<!-- 削除モーダル -->
@include('includes.delete-book-form')

<!-- END モーダル-->
@endif<!-- END もしも、まだ自分の感想が登録されていないならば、編集ボタン・削除ボタンは表示しない。 -->
<!---------------------------------- END 自分の感想 -------------------------------->


<hr>


<!---------------------------------- START 他人の感想 -------------------------------->
<div><i class="far fa-smile"></i>みんなの感想</div>
@if($others_reviews->count() > 0)
@foreach($others_reviews as $other_review)
<div>
    @if($other_review->user->icon)
    <img src="/storage/icons/{{$other_review->user->icon}}" alt="ユーザーアイコン" width="30px" height="30px">
    @else
    <img src="/storage/icons/default.png" alt="ユーザーアイコン" width="30px" height="30px">
    @endif
    {{ $other_review->user->name }}さんの感想
</div>
<div class="netabare__{{ $other_review->netabare}}">
    <p>{{ $other_review->body }}</p>
</div>

<!-- いいねボタン機能(Vueコンポーネント) -->
<review-like
:initial-like = "@json($other_review->isLiked($user_id))"
:initial-count-likes = "@json($other_review->count_likes)"
like-route="{{ route('books.like',['reading_record_id'=>$other_review->id])}}"
></review-like>

<hr>
@endforeach
@else
<p>まだ他の方の感想がありません。</p>
@endif
<!---------------------------------- END 他人の感想 -------------------------------->