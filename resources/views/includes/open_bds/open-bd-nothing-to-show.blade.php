
@if($items)

<!-- 書籍のイメージ画像 -->
@if( $items['summary']['cover'])
<img src="{{ $items['summary']['cover'] }}" alt="書籍のイメージ"><br>
@else
<img src="/storage/book/book_noimage.png" alt="書籍のイメージ" width="200px" width="200px">
@endif

<!-- 書籍のタイトル -->
@if($items['summary']['title'])
<P>{{ $items['summary']['title']}}</P>
@endif

<!-- 著者 -->
@if($items['summary']['author'])
著者：{{ $items['summary']['author'] }}/
@endif

<!-- 出版日 -->
@if($items['summary']['pubdate'])
出版日：{{ $items['summary']['pubdate'] }}
@endif

<!-- 概要 -->
@if($items['onix']['CollateralDetail']['TextContent'][0]['Text'])
<p>概要<br>{{ $items['onix']['CollateralDetail']['TextContent'][0]['Text'] }}</p>
@endif

@endif

<hr>
<p>まだ誰もレビューしていません。</p>
<p>読んで気に入ったら、本棚に追加してみませんか？</p>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#register-book">
    本を登録する。
</button>

<!-- モーダルの登録フォーム読み込み -->
@include('includes.open_bds.open-bd-register')