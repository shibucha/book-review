@if($item)


<!-- 書籍のイメージ画像 -->
<div class="nothing-to-show__flex">

    <div class="nothing-to-show__image mb-10">
        <div class="nothing-to-show__image">
            @if(array_key_exists('imageLinks', $item['volumeInfo']))
            <img src="{{ $item['volumeInfo']['imageLinks']['thumbnail'] }}" alt="書籍のイメージ"><br>
            @else
            <img src="/storage/book/book_noimage.png" alt="書籍のイメージ" width="200px" width="200px">
            @endif
        </div>
    </div>

    <div class="nothing-to-show__left mb-10">
        <!-- 書籍のタイトル -->
        <div class="nothing-to-show__title">
            @if(array_key_exists('title', $item['volumeInfo']))
            <P><span class="font-bold">{{ $item['volumeInfo']['title']}}</span></P>
            @endif
        </div>

        <!-- 著者 -->
        <div class="nothing-to-show__author mb-10">
            @if(array_key_exists('authors', $item['volumeInfo']))
            <span class="font-bold">著者</span>：{{ $item['volumeInfo']['authors'][0] }}
            @endif
        </div>

        <!-- 出版日 -->
        <div class="nothing-to-show__published-date mb-10">
            @if(array_key_exists('publishedDate', $item['volumeInfo']))
            <span class="font-bold">出版日</span>：{{ $item['volumeInfo']['publishedDate'] }}
            @endif
        </div>

        <!-- 概要 -->
        <div class="nothing-to-show__description mb-10">
            @if(array_key_exists('description', $item['volumeInfo']))
            <div class="font-bold">概要</div>
            <p class="fs-m">{{ $item['volumeInfo']['description'] }}</p>
            @endif
        </div>
    </div>
</div>

<hr>

<p>まだ誰もレビューしていません。</p>
<p>読んで気に入ったら、本棚に追加してみませんか？</p>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#a-{{ $item['id'] }}">
    本を登録する。
</button>

@endif

<!-- モーダルの登録フォーム読み込み -->

@include('includes.google_books.google-book-register')