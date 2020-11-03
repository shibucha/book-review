<footer>
  <div class=".footer_wrapper sections">
    <divc class="footer__search">
      <p class="footer-sections-p"><span class="marker-grey">本を探す</span></p>
      <ul class="footer-ul">
        <a href="{{route('books.search')}}">
          <li>検索</li>
        </a>
        <a href="">
          <li>ランキング</li>
        </a>
      </ul>
    </divc>

    <div class="footer__about">
      <p class="footer-sections-p"><span class="marker-grey">Your Bookshelfについて</span></p>
      <ul class="footer-ul">
        <a href="{{route('term')}}">
          <li>利用規約</li>
        </a>
      </ul>
    </div>

    <div class="footer__support">
      <p class="footer-sections-p"><span class="marker-grey">サポート</span></p>
      <ul class="footer-ul">
        <a href="{{route('contacts.index')}}">
          <li>お問い合わせ</li>
        </a>
      </ul>
    </div>
  </div>


  <div class="r-footer">
    <ul class="r-footer-info">
      <div class="r-footer-el">コンテンツ</div>
      <li class=""><a href="{{route('books.search')}}">検索</a></li>
      <!-- <li class=""><a href="{{route('contacts.index')}}">ランキング</a></li> -->
    </ul>
    <ul class="r-footer-info">
      <div class="r-footer-el">Your　Bookshelfについて</div>
      <li class=""><a href="{{route('term')}}">利用規約</a></li>
      <li class=""><a href="{{route('contacts.index')}}">お問い合わせ</a></li>
    </ul>
  </div>

</footer>