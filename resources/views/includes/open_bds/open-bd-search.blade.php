
<!-- 検索結果の表示 -->
<h2>{{ $items['summary']['title']}}</h2>

<!-- 書籍のイメージ画像 -->
@if(isset($items['summary']['cover']))
<img src="{{ $items['summary']['cover'] }}" alt="書籍のイメージ"><br>
@endif

<!-- 著者 -->
@if(isset($items['summary']['author']))
【著者】{{ $items['summary']['author'] }}
@endif

<!-- 発売年月日 -->
@if(isset($items['summary']['pubdate']))
【発売年月日】{{ $items['summary']['pubdate'] }}<br>
@endif

<!-- ISBNコード -->
@if(isset($items['summary']['isbn']))
【ISBN】{{ $items['summary']['isbn'] }}<br>
@endif

<!-- 概要 -->
@if(isset($items['onix']['CollateralDetail']['TextContent'][0]['Text']))
【概要】{{ $items['onix']['CollateralDetail']['TextContent'][0]['Text'] }}<br>
@else
【概要】なし<br>
@endif


<!--------------------------- START 認証済みの場合、本の登録可能 --------------------------->
@auth
<!-- Button trigger modal -->
@if(in_array($items['summary']['isbn'], $book_ids))
<a href="{{ route('books.show',['book_id'=>$items['summary']['isbn']])}}">
    <button class="btn btn-success">詳細ページへ</button>
</a>
@else
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#register-book">
    本を登録する。
</button>
<a href="{{route('books.show',['book_id'=>$items['summary']['isbn']])}}">
    <button class="btn btn-success">詳細ページへ</button>
</a>
@endif


<!-- モーダル OpenBDの登録フォーム -->
@include('includes.open_bds.open-bd-register')



@endauth
<!--------------------------- END 認証済みの場合、本の登録可能 --------------------------->
<hr>