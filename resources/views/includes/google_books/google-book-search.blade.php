<!-- 検索結果の表示 -->
<div class="search__result">
    @foreach($items as $item)

    <div class="search__item">
        <h2>{{ $item['volumeInfo']['title']}}</h2>

        <!-- 書籍のイメージ画像 -->
        <div class="search__image mb-10">
            @if(array_key_exists('imageLinks', $item['volumeInfo']))
            <img src="{{ $item['volumeInfo']['imageLinks']['thumbnail'] }}" alt="書籍のイメージ"><br>
            @else
            <img src="https://book-review-shibucha.s3-ap-northeast-1.amazonaws.com/books/book_noimage.png" alt="書籍のイメージなし" width="200px" width="200px">
            @endif
        </div>

        <!-- 著者 -->
        <div class="search__author">
            @if(array_key_exists('authors', $item['volumeInfo']))
            【著者】{{ $item['volumeInfo']['authors'][0] }}
            @endif
        </div>

        <!-- 発売年月日 -->
        <div class="search__published-date">
            @if(array_key_exists('publishedDate', $item['volumeInfo']))
            【発売年月日】{{ $item['volumeInfo']['publishedDate'] }}<br>
            @endif
        </div>

        <!-- ISBNコード -->
        <div class="search__isbn">
            @if(array_key_exists('industryIdentifiers', $item['volumeInfo']))
            @foreach($item['volumeInfo']['industryIdentifiers'] as $industryIdentifier)
            【{{ $industryIdentifier['type'] }}】&nbsp;：&nbsp;{{ $industryIdentifier['identifier'] }}<br>
            @endforeach
            @endif
        </div>

        <!-- 概要 -->
        <div class="search__description">
            @if(array_key_exists('description', $item['volumeInfo']))
            【概要】{{ $item['volumeInfo']['description'] }}<br>
            @endif
        </div>


        <!--------------------------- START 認証済みの場合、本の登録可能 --------------------------->
        @auth
        <!-- Button trigger modal -->
        @if(in_array($google_book->getBookId($item), $book_ids))
        <a href="{{ route('books.show',['book_id'=>$item['id']])}}">
            <button class="btn btn-success">詳細ページへ</button>
        </a>
        @else
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{ 'a-'.$item['id'] }}">
            本を登録する。
        </button>
        <a href="{{ route('books.show',['book_id'=>$item['id']])}}">
            <button class="btn btn-success">詳細ページへ</button>
        </a>
        @endif


        <!-- モーダル グーグルブックの登録フォーム -->
        @include('includes.google_books.google-book-register')
    </div>

    @endauth
    <!--------------------------- END 認証済みの場合、本の登録可能 --------------------------->
    <hr>

    @endforeach
</div>