@if($items)

@foreach($items as $item)
<!-- 書籍のイメージ画像 -->
<div class="nothing-to-show__flex">

    <div class="nothing-to-show__image mb-10">
        <div class="nothing-to-show__image">
            @if(isset($item->Item->largeImageUrl))
            <img src="{{ $item->Item->largeImageUrl }}" alt="書籍のイメージ"><br>
            @else
            <img src="https://book-review-shibucha.s3-ap-northeast-1.amazonaws.com/books/book_noimage.png" alt="書籍のイメージなし" width="200px" width="200px">
            @endif
        </div>
    </div>

    <div class="nothing-to-show__left mb-10">
        <!-- 書籍のタイトル -->
        <div class="nothing-to-show__title">
            @if(isset($item->Item->title))
            <P><span class="font-bold">{{ $item->Item->title}}</span></P>
            @endif
        </div>

        <!-- 著者 -->
        <div class="nothing-to-show__author mb-10">
            @if(isset($item->Item->author))
            <span class="font-bold">著者</span>：{{ $item->Item->author }}
            @endif
        </div>

        <!-- 出版日 -->
        <div class="nothing-to-show__published-date mb-10">
            @if(array_key_exists('salesDate', $item->Item))
            <span class="font-bold">出版日</span>：{{ $item->Item->salesDate }}
            @endif
        </div>

        <!-- ISBN -->
        <div class="nothing-to-show__isbn mb-10">
            @if(array_key_exists('isbn', $item->Item))
            <span class="font-bold">ISBN</span>：{{ $item->Item->isbn }}
            @endif
        </div>

        <!-- 概要 -->
        <div class="nothing-to-show__description mb-10">
            @if(array_key_exists('itemCaption', $item->Item))
            <div class="font-bold">概要</div>
            <p class="fs-m">{{ $item->Item->itemCaption }}</p>
            @endif
        </div>
    </div>
</div>

<hr>

<p>まだ誰もレビューしていません。</p>
<p>読んで気に入ったら、本棚に追加してみませんか？</p>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#a-{{ $item->Item->isbn }}">
    本を登録する。
</button>

@endforeach
@endif

<!-- モーダルの登録フォーム読み込み -->

@include('includes.rakuten_books.rakuten-book-register')