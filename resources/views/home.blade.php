@extends('layouts.app')

@section('title', 'book-review | トップページ ')


@section('content')
@include('layouts.nav')


<div id="home">
  <!-- 未ログインでも本の検索が出来るように実装 -->
  <h1>読んだ本を記録しよう。</h1>
  <form method="get" action="{{ route('books.search') }}" class="search_container">
    <input type="text" size="25" placeholder="  本を探す" name="keyword"><input type="submit" value="&#xf002">
  </form>

</div>


<div class="background">
  <div class="wrapper">
    <div class="j-1 j">
      <h1>ジャンル１</h1>
      <div class="books">
        <img src="images/hon-a.jpeg" alt="本" class="book">
        <img src="images/hon-2.jpeg" alt="本" class="book">
        <img src="images/hon-3.jpeg" alt="本" class="book">
        <img src="images/hon-4.jpg" alt="本" class="book">
        <img src="images/hon-5.jpg" alt="本" class="book">
        <img src="images/hon-3.jpeg" alt="本" class="book">
        <img src="images/hon-a.jpeg" alt="本" class="book">
      </div>
      <div class="ita-cover">
        <img src="images/shelf.jpeg" alt="" class="shelves">
      </div>
    </div>
    <div class="j">
      <h1>ジャンル２</h1>
      <div class="books">
        <img src="images/hon-a.jpeg" alt="本" class="book">
        <img src="images/hon-2.jpeg" alt="本" class="book">
        <img src="images/hon-3.jpeg" alt="本" class="book">
        <img src="images/hon-4.jpg" alt="本" class="book">
        <img src="images/hon-5.jpg" alt="本" class="book">
        <img src="images/hon-3.jpeg" alt="本" class="book">
        <img src="images/hon-a.jpeg" alt="本" class="book">
      </div>
      <img src="images/shelf.jpeg" alt="" class="shelves">
      <div>
      </div>
    </div>
    <div class="j">
      <h1>ジャンル３</h1>
      <div class="books">
        <img src="images/hon-a.jpeg" alt="本" class="book">
        <img src="images/hon-2.jpeg" alt="本" class="book">
        <img src="images/hon-3.jpeg" alt="本" class="book">
        <img src="images/hon-4.jpg" alt="本" class="book">
        <img src="images/hon-5.jpg" alt="本" class="book">
        <img src="images/hon-3.jpeg" alt="本" class="book">
        <img src="images/hon-a.jpeg" alt="本" class="book">
      </div>
      <img src="images/shelf.jpeg" alt="" class="shelves">
    </div>
  </div>
</div>

<footer>
  <div class="wrapper sections">
    <div>
      <p class="footer-sections-p">機能1</p>
      <ul class="footer-ul">
        <a href="">
          <li>要素1</li>
        </a>
        <a href="">
          <li>要素2</li>
        </a>
        <a href="">
          <li>要素3</li>
        </a>
        <a href="">
          <li>要素4</li>
        </a>
        <a href="">
          <li>要素5</li>
        </a>
      </ul>
    </div>
    <div>
      <p class="footer-sections-p">book-reviewについて</p>
      <ul class="footer-ul">
        <a href="">
          <li>要素1</li>
        </a>
        <a href="">
          <li>要素2</li>
        </a>
        <a href="">
          <li>要素3</li>
        </a>
        <a href="">
          <li>要素4</li>
        </a>
        <a href="">
          <li>要素5</li>
        </a>
      </ul>
    </div>
    <div>
      <p class="footer-sections-p">サポート</p>
      <ul class="footer-ul">
        <a href="">
          <li>要素1</li>
        </a>
        <a href="">
          <li>要素2</li>
        </a>
        <a href="">
          <li>要素3</li>
        </a>
        <a href="">
          <li>要素4</li>
        </a>
        <a href="">
          <li>要素5</li>
        </a>
      </ul>
    </div>
  </div>

</footer>

@endsection