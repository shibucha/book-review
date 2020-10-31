@if($items)

@foreach($items as $item)
<!-- 書籍のイメージ画像 -->
<div class="nothing-to-show__flex">

    <div class="nothing-to-show__image mb-10">
        <div class="nothing-to-show__image">
            @if(isset($item->Item->largeImageUrl))
            <img src="{{ $item->Item->largeImageUrl }}" alt="書籍のイメージ"><br>
            @else
            <img src="{{$book_image_path}}book_noimage.png" alt="書籍のイメージなし" width="200px" width="200px">
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
            <span class="font-bold">著&nbsp;者</span>&nbsp;：&nbsp;{{ $item->Item->author }}
            @endif
        </div>

        <!-- 出版日 -->
        <div class="nothing-to-show__published-date mb-10">
            @if(isset($item->Item->salesDate))
            <span class="font-bold">出版日</span>&nbsp;：&nbsp;{{ $item->Item->salesDate }}
            @endif
        </div>

        <!-- ISBN -->
        <div class="nothing-to-show__isbn mb-10">
            @if(isset($item->Item->isbn))
            <span class="font-bold">ISBN</span>&nbsp;：&nbsp;{{ $item->Item->isbn }}
            @endif
        </div>

        <!-- 概要 -->
        <div class="nothing-to-show__description mb-10">
            @if(isset($item->Item->itemCaption))
            <div class="font-bold">概&nbsp;要</div>
            <p class="fs-m">{{ $item->Item->itemCaption }}</p>
            @endif
        </div>
    </div>
</div>

<hr>

<p>まだ誰もレビューしていません。</p>

@endforeach
@endif

<!-- モーダルの登録フォーム読み込み -->

@include('includes.rakuten_books.rakuten-book-register')