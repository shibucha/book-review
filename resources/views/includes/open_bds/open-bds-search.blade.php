@foreach($items as $item)

<h2>{{ $item['summary']['title']}}</h2>

<!-- 書籍のイメージ画像 -->
@if(array_key_exists('cover', $item['summary']))
<img src="{{ $item['summary']['cover'] }}" alt="書籍のイメージ"><br>
@endif

<!-- 著者 -->
@if(array_key_exists('author', $item['summary']))
【著者】{{ $item['summary']['author'] }}
@endif

<!-- 発売年月日 -->
@if(array_key_exists('pubdate', $item['summary']))
【発売年月日】{{ $item['summary']['pubdate'] }}<br>
@endif

<!-- ISBNコード -->
@if(array_key_exists('isbn', $item['summary']))
【ISBN】{{ $item['summary']['isbn'] }}<br>
@endif

<!-- 概要 -->
@if(array_key_exists('Text', $item['onix']['CollateralDetail']['TextContent']))
【概要】{{ $item['onix']['CollateralDetail']['TextContent']['Text'] }}<br>
@endif


<!--------------------------- START 認証済みの場合、本の登録可能 --------------------------->
@auth
<!-- Button trigger modal -->
@if(in_array($item['summary']['isbn'], $google_book_ids))
<a href="{{ route('books.show',['book_id'=>$item['summary']['isbn']])}}">
    <button class="btn btn-success">詳細ページへ</button>
</a>
@else
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{ $item['summary']['isbn'] }}">
    本を登録する。
</button>
<a href="{{ route('books.show',['book_id'=>$item['summary']['isbn']])}}">
    <button class="btn btn-success">詳細ページへ</button>
</a>
@endif


<!-- モーダル OpenBDの登録フォーム -->
@include('includes.open_bds.open-bds-register')


@endauth
<!--------------------------- END 認証済みの場合、本の登録可能 --------------------------->
<hr>

@endforeach