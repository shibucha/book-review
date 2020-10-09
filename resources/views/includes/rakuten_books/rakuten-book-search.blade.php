<!-- 検索結果の表示 -->
<div class="search__result">
    @foreach($items as $item)

    <div class="search__item">
        <h2>{{ $item->Item->title}}</h2>

        <div class="search__flex">
            <div class="search__left">
                <!-- 書籍のイメージ画像 -->
                <div class="search__image mb-10">
                    @if(array_key_exists('largeImageUrl', $item->Item))
                    <img src="{{ $item->Item->largeImageUrl }}" alt="書籍のイメージ"><br>
                    @else
                    <img src="https://book-review-shibucha.s3-ap-northeast-1.amazonaws.com/books/book_noimage.png" alt="書籍のイメージなし" width="200px" width="200px">
                    @endif
                </div>
            </div>

            <div class="search__right">
                <!-- 著者 -->
                <div class="search__author mb-10">
                    @if(array_key_exists('author', $item->Item))
                    {{ $item->Item->author }} / 著
                    @endif
                </div>

                <!-- 発売年月日 -->
                <div class="search__published-date mb-10">
                    @if(array_key_exists('salesDate', $item->Item))
                    出版日&nbsp;：&nbsp;{{ $item->Item->salesDate }}
                    @endif
                </div>

                <!-- ISBNコード -->
                <div class="search__isbn mb-10">
                    @if(array_key_exists('isbn', $item->Item))
                    ISBN(NO_13): {{$item->Item->isbn}}
                    @endif
                </div>

                <!-- 概要 -->
                <div class="search__description mb-10">
                    @if(array_key_exists('itemCaption', $item->Item))
                    <div>【概要】</div>
                    <span class="fs-m">{{ $item->Item->itemCaption }}</span><br>
                    @endif
                </div>
            </div>
        </div>


        <!--------------------------- START 認証済みの場合、本の登録可能 --------------------------->
        @auth
        <!-- Button trigger modal -->
        @if(in_array($item->Item->isbn, $book_ids))
        <a href="{{ route('books.show',['book_id'=>$item->Item->isbn])}}">
            <button class="btn btn-success">詳細ページへ</button>
        </a>
        @else
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{ 'a-'.$item->Item->isbn }}">
            本を登録する。
        </button>
        <a href="{{ route('books.show',['book_id'=>$item->Item->isbn])}}">
            <button class="btn btn-success">詳細ページへ</button>
        </a>
        @endif


        <!-- モーダル グーグルブックの登録フォーム -->
        @include('includes.rakuten_books.rakuten-book-register')
    </div>

    @endauth
    <!--------------------------- END 認証済みの場合、本の登録可能 --------------------------->
    <hr>

    @endforeach
</div>