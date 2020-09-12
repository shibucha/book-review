@extends('layouts.app')

@section('title', '本の詳細')


@section('content')
<h1>本の詳細ページ</h1>

@if(isset($items))
@foreach($items as $item)

<!----------------- START 書籍のAPI情報 --------------->

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
<!----------------- END 書籍のAPI情報 --------------->

<hr>

<!----------------- START 自分の感想 --------------->
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
<div class="modal fade" id="{{ $review->book->google_book_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered" role="document">


        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal__title" id="exampleModalLongTitle">感想を編集する。</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- 書籍タイトル -->
            <p class="modal__book-title">タイトル：{{ $review->book->title }}</p>

            <!-- 編集・登録フォーム -->
            <form action="{{ route('books.update',['reading_record_id'=>$review->id]) }}" method="POST">
                @csrf
                @method('PATCH')
                @include('includes.error_list')

                <div class="modal-body modal__body">

                    <div class="modal__book-title modal__left">
                        <div class="modal__book-image">
                            @if($review->book->image)
                            <img src="{{ $review->book->image}}" alt="書籍のイメージ"><br>
                            @else
                            <img src="/storage/book/book_noimage.png" alt="書籍のイメージ" width="200px" width="200px">
                            @endif
                        </div>
                    </div>

                    <div class="modal__right">
                        <div class="modal__date form-group">
                            <label for="reading_record">読了日:</label>
                            <input type="date" name="reading_date" class="reading_date modal__input-field modal__date-field" value="{{$review->reading_date ?? old('reading_date')}}">
                        </div>
                        <div class="form-group modal__review">
                            <label for="">感想・レビュー:</label>
                            <textarea name="body" placeholder="感想・レビュー" cols="50" rows="10" class="modal__input-field">{{ $review->body ?? old('body')}}</textarea>
                        </div>
                        <div class="modal__private">
                            @if($review->public_private === 1)
                            <input type="checkbox" name="public_private" value="0">非公開にする。
                            @else
                            <input type="checkbox" name="public_private" value="1">公開する。
                            @endif
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">編集する。</button>
                </div>
            </form>
            <!-- 編集・登録フォーム -->

        </div>
    </div>
</div>

<!-- 削除モーダル -->
<div id="delete-{{ $review->id }}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('books.delete', ['reading_record_id'=>$review->id])}}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    この本を本棚から削除します。よろしいですか？
                </div>
                <div class="modal-footer justify-content-between">
                    <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                    <button type="submit" class="btn btn-danger">削除する</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END モーダル-->
@endif<!-- END もしも、まだ自分の感想が登録されていないならば、編集ボタン・削除ボタンは表示しない。 -->
<!----------------- END 自分の感想 --------------->

<hr>

<!----------------- START 他人の感想 --------------->
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
<p>{{ $other_review->body }}</p>

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
<!----------------- END 他人の感想 --------------->
@endsection