
@if($item)

<!-- 書籍のイメージ画像 -->
@if( $item['summary']['cover'])
<img src="{{ $item['summary']['cover'] }}" alt="書籍のイメージ"><br>
@else
<img src="/storage/book/book_noimage.png" alt="書籍のイメージ" width="200px" width="200px">
@endif

<!-- 書籍のタイトル -->
@if(isset($item['summary']['title']))
<P>{{ $item['summary']['title']}}</P>
@else
不明な書籍
@endif

<!-- 著者 -->
@if(isset($item['summary']['author']))
著者：{{ $item['summary']['author'] }}/
@else
著者：不明/
@endif

<!-- 出版日 -->
@if(isset($item['summary']['pubdate']))
出版日：{{ $item['summary']['pubdate'] }}
@else
出版日：不明
@endif

<!-- 概要 -->
@if(isset($item['onix']['CollateralDetail']['TextContent'][0]['Text']))
<p>概要<br>{{ $item['onix']['CollateralDetail']['TextContent'][0]['Text'] }}</p>
@else
<p>概要：なし</p>
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
