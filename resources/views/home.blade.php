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


<div class="background">
  <div class="wrapper">
    <div class="j">
      <h1>ジャンル１</h1>
      <div class="books">
        <img src="images/hon-1.jpeg" alt="本" class="book">
        <img src="images/hon-2.jpeg" alt="本" class="book">
        <img src="images/hon-3.jpeg" alt="本" class="book">
        <img src="images/hon-4.jpg" alt="本" class="book">
        <img src="images/hon-5.jpg" alt="本" class="book">
        <img src="images/hon-3.jpeg" alt="本" class="book">
        <img src="images/hon-1.jpeg" alt="本" class="book">
      </div>
      <div class="ita-cover">
        <img src="images/shelf.jpeg" alt="" class="shelves">
      </div>
    </div>
    <div class="j">
      <h1>ジャンル２</h1>
      <div class="books">
        <img src="images/hon-1.jpeg" alt="本" class="book">
        <img src="images/hon-2.jpeg" alt="本" class="book">
        <img src="images/hon-3.jpeg" alt="本" class="book">
        <img src="images/hon-4.jpg" alt="本" class="book">
        <img src="images/hon-5.jpg" alt="本" class="book">
        <img src="images/hon-3.jpeg" alt="本" class="book">
        <img src="images/hon-1.jpeg" alt="本" class="book">
      </div>
      <img src="images/shelf.jpeg" alt="" class="shelves">
      <div>
      </div>
    </div>
    <div class="j">
      <h1>ジャンル３</h1>
      <div class="books">
        <img src="images/hon-1.jpeg" alt="本" class="book">
        <img src="images/hon-2.jpeg" alt="本" class="book">
        <img src="images/hon-3.jpeg" alt="本" class="book">
        <img src="images/hon-4.jpg" alt="本" class="book">
        <img src="images/hon-5.jpg" alt="本" class="book">
        <img src="images/hon-3.jpeg" alt="本" class="book">
        <img src="images/hon-1.jpeg" alt="本" class="book">
      </div>
      <img src="images/shelf.jpeg" alt="" class="shelves">
    </div>
  </div>
</div>
  <!-- ------------------------------------------------- -->

  <div class="r-wrapper">
    <div class="r-j">
      <div>
        <img src="images/hon-1.jpeg" alt="本" class="book">
      </div>
      <div>
        <h3>本のタイトル</h3>
        <p>著者・作者</p>
        <a href="" class="register-book">本を登録する</a>
      </div>
    </div>
    <div class="for-r-j-border"></div>
    <div class="r-j">
      <div>
        <img src="images/hon-2.jpeg" alt="本" class="book">
      </div>
      <div>
        <h3>本のタイトル</h3>
        <p>著者・作者</p>
        <a href="" class="register-book">本を登録する</a>
      </div>
    </div>
    <div class="for-r-j-border"></div>
    <div class="r-j">
      <div>
        <img src="images/hon-3.jpeg" alt="本" class="book">
      </div>
      <div>
        <h3>本のタイトル</h3>
        <p>著者・作者</p>
        <a href="" class="register-book">本を登録する</a>
      </div>
    </div>
    <div class="for-r-j-border"></div>
    <div class="r-j">
      <div>
        <img src="images/hon-4.jpg" alt="本" class="book">
      </div>
      <div>
        <h3>本のタイトル</h3>
        <p>著者・作者</p>
        <a href="" class="register-book">本を登録する</a>
      </div>
    </div>
    <div class="for-r-j-border"></div>
  </div>

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