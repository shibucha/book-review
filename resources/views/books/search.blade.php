@extends('layouts.app')

@section('title', '書籍検索')


@section('content')
@include('layouts.nav')
<h1>本を探しましょう。</h1>

@if(Auth::check())
<a href="{{route('books.index')}}">マイページに戻る</a>
@else
<a href="{{route('login')}}">ログイン画面へ</a>
@endif

<form method="GET" action="{{ route('books.search') }}">
    <input type="text" name="keyword" value="{{ $keyword }}" style="border:1px solid black;">&nbsp;
    <input type="submit" value="検索">
</form>

@if($items === null)
<p>キーワードを入力してください。</p>
@else($items > 0)
<p>{{ $keyword }}の検索結果</p>
<hr>

@foreach($items as $item)

<h2>{{ $item['volumeInfo']['title']}}</h2>

<!-- 書籍のイメージ画像 -->
@if(array_key_exists('imageLinks', $item['volumeInfo']))
<img src="{{ $item['volumeInfo']['imageLinks']['thumbnail'] }}" alt="書籍のイメージ"><br>
@endif

<!-- 著者 -->
@if(array_key_exists('authors', $item['volumeInfo']))
【著者】{{ $item['volumeInfo']['authors'][0] }}
@endif

<!-- 発売年月日 -->
@if(array_key_exists('publishedDate', $item['volumeInfo']))
【発売年月日】{{ $item['volumeInfo']['publishedDate'] }}<br>
@endif

<!-- ISBNコード -->
@if(array_key_exists('industryIdentifiers', $item['volumeInfo']))
@foreach($item['volumeInfo']['industryIdentifiers'] as $industryIdentifier)
【{{ $industryIdentifier['type'] }}】&nbsp;：&nbsp;{{ $industryIdentifier['identifier'] }}<br>
@endforeach
@endif

<!-- 概要 -->
@if(array_key_exists('description', $item['volumeInfo']))
【概要】{{ $item['volumeInfo']['description'] }}<br>
@endif


<!--------------------------- 認証済みの場合、本の登録可能 --------------------------->
@auth
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{$item['id']}}">
    本を登録する。
</button>

<!-- モーダル -->
<div class="modal fade" id="{{$item['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered" role="document">


        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal__title" id="exampleModalLongTitle">読んだ本に登録</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- 書籍タイトル -->
            <p class="modal__book-title">タイトル：{{ $item['volumeInfo']['title']}}</p>

            <!-- 登録フォーム -->
            <form action="{{ route('search.store',['book_id'=>$item['id']]) }}" method="POST">
                @csrf
                @include('layouts.error_list')

                <div class="modal-body modal__body">

                    <div class="modal__book-title modal__left">
                        <div class="modal__book-image">
                            @if(array_key_exists('imageLinks', $item['volumeInfo']))
                            <img src="{{ $item['volumeInfo']['imageLinks']['thumbnail']}}" alt="書籍のイメージ"><br>
                            @endif
                        </div>
                    </div>

                    <div class="modal__right">
                        <div class="modal__date form-group">
                            <label for="reading_record">読了日:</label>
                            <input type="date" name="reading_date" class="reading_date modal__input-field modal__date-field">
                        </div>
                        <div class="form-group modal__review">
                            <label for="">感想・レビュー:</label>
                            <textarea name="body" placeholder="感想・レビュー" cols="50" rows="10 value=" {{ old('body')}}" class="modal__input-field"></textarea>
                        </div>
                    </div>                  

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">登録する。</button>
                </div>
            </form>
            <!-- 登録フォーム -->
        </div>
    </div>
</div>

@endauth
<!--------------------------- 認証済みの場合、本の登録可能 --------------------------->
<hr>
@endforeach
<!-- $itemsのループ終了 -->
@endif
<!-- キーワードの検索終了 -->
@endsection