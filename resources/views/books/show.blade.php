@extends('layouts.app')

@section('title', '本の詳細')

@include('layouts.nav')

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

@endforeach
@endif
<!----------------- END 書籍のAPI情報 --------------->

<hr>

<!----------------- START 自分の感想 --------------->
<div><i class="far fa-smile"></i>{{$review->user->name}}さんの感想</div>
@if($review->body)
<p>{{ $review->body }}</p>
@else
<p>まだ感想は登録されていません。</p>
@endif
<!----------------- END 自分の感想 --------------->

<hr>

<!----------------- START 他人の感想 --------------->
<div><i class="far fa-smile"></i>みんなの感想</div>
@if($others_reviews->count() > 0)
@foreach($others_reviews as $other_review)
<div>{{ $other_review->user->name }}さんの感想</div>
<p>{{ $other_review->body }}</p>
<hr>
@endforeach
@else
<p>まだ他の方の感想がありません。</p>
@endif
<!----------------- END 他人の感想 --------------->
@endsection