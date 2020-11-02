@extends('layouts.app')

@section('title', 'book-review | トップページ ')


@section('content')


<div id="home">
  <!-- 未ログインでも本の検索が出来るように実装 -->
  <h1>読んだ本を記録しよう。</h1>
  <form method="get" action="{{ route('books.search') }}" class="search_container">
    <input type="text" size="25" placeholder="本を探す" name="keyword" class="search_box"><input type="submit" value="&#xf002">
  </form>

</div>

@if($data)
<!-- PC画面用 -->
<div class="background">
  <div class="home__wrapper wrapper">
    <div class="j">
      <h1 class="home__osusume">今週のおすすめ</h1>
      <div class="books">
        @foreach($data as $book)
        @if(Auth::check())
        <a href="{{route('books.show',['book_id'=>$book->book_id])}}">
          <img src="{{$book->image}}" alt="本" class="book">
        </a>
        @else
        <a href="{{route('guest.show',['book_id'=>$book->book_id])}}">
          <img src="{{$book->image}}" alt="本" class="book">
        </a>
        @endif
        @endforeach
      </div>
      <div class="ita-cover">
        <img src="images/shelf.jpeg" alt="" class="shelves">
      </div>
    </div>
  </div>
</div>

<!-- ------------------------------------------------- -->

<!-- レスポンシブ -->
<div class="r-wrapper">
  @foreach($data as $book)
  <div class="r-j">
    <div>
      @if(Auth::check())
      <a href="{{route('books.show',['book_id'=>$book->book_id])}}">
        <img src="{{$book->image}}" alt="本" class="book">
      </a>
      @else
      <a href="{{route('guest.show',['book_id'=>$book->book_id])}}">
        <img src="{{$book->image}}" alt="本" class="book">
      </a>
      @endif
    </div>
    <div>
      <h3 class="r-book__title">{{$book->title}}</h3>
      <p class="r-book__author">{{$book->author->author}}/著</p>
    </div>
  </div>
  <div class="for-r-j-border"></div>
  @endforeach
</div>

@else

<div class="home__no-book">
  <p>ただいま準備中です。少々お待ちください。</p>
</div>

@endif
<div class="r-sign-wrapper">

  <p class="no-account">読んだ本を記録しよう！</p>

  <div class="to-register-wrapper">
    <a class="btn btn-rounded btn-block waves-effect z-depth-0 register-button" href="{{ route('register')}}" role="button">新規登録</a>
  </div>

  <p class="no-account">すでにアカウントをお持ちの方はこちら</p>

  <div class="to-login-wrapper">
    <a href="{{ route('login') }}" class="btn btn-rounded btn-block waves-effect z-depth-0 login-button">ログイン</a>
  </div>

</div>

<!-- --------------------------------------------------- -->



@endsection