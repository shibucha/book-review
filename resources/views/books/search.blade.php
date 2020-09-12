@extends('layouts.app')

@section('title', '書籍検索')


@section('content')

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
@if(in_array($item['id'], $google_book_ids))
<a href="{{ route('books.show',['book_id'=>$item['id']])}}">
    <button class="btn btn-success">詳細ページへ</button>
</a>
@else
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{ $item['id'] }}">
    本を登録する。
</button>
<a href="{{ route('books.show',['book_id'=>$item['id']])}}">
    <button class="btn btn-success">詳細ページへ</button>
</a>
@endif


<!-- モーダル 本の登録 -->
@include('includes.read-register')

@endauth
<!--------------------------- 認証済みの場合、本の登録可能 --------------------------->
<hr>
@endforeach
<!-- $itemsのループ終了 -->
@endif
<!-- キーワードの検索終了 -->
@endsection