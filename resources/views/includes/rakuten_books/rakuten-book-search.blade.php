<!-- 検索結果の表示 -->
<div class="search__result">
    @foreach($items as $item)

    <div class="search__item">
        <h2>{{ $item->Item->title}}</h2>

        <div class="search__flex">
            <div class="search__left">
                <!-- 書籍のイメージ画像 -->
                <div class="search__image mb-10">
                    @if(isset($item->Item->largeImageUrl))
                    <img src="{{ $item->Item->largeImageUrl }}" alt="書籍のイメージ"><br>
                    @else
                    <img src="{{$book_image_path}}book_noimage.png" alt="書籍のイメージなし" width="200px" width="200px">
                    @endif
                </div>
            </div>

            <div class="search__right">
                <!-- 著者 -->
                <div class="search__author mb-10">
                    @if(isset($item->Item->author))
                    {{ $item->Item->author }} / 著
                    @endif
                </div>

                <!-- 発売年月日 -->
                <div class="search__published-date mb-10">
                    @if(isset($item->Item->salesDate))
                    出版日&nbsp;：&nbsp;{{ $item->Item->salesDate }}
                    @endif
                </div>

                <!-- ISBNコード -->
                <div class="search__isbn mb-10">
                    @if(isset($item->Item->isbn))
                    ISBN&nbsp;：&nbsp;{{$item->Item->isbn}}
                    @endif
                </div>

                <!-- 概要 -->
                <div class="search__description mb-10">
                    @if(isset($item->Item->itemCaption))
                    <div>【概要】</div>
                    <span class="fs-m">{{ $item->Item->itemCaption }}</span><br>
                    @endif
                </div>
            </div>
        </div>


        <!--------------------------- START 認証済みの場合、本の登録可能 --------------------------->
        @auth
        <div class="search__result-btn">
            <!-- Button trigger modal -->
            @if(in_array($item->Item->isbn, $book_ids))
            <a href="{{ route('books.show',['book_id'=>$item->Item->isbn])}}">
                <button class="btn letter-dark border-dark">詳細ページへ</button>
            </a>
            @else
            <button type="button" class="btn btn-dark letter-white register-btn" data-toggle="modal" data-target="#{{ 'a-'.$item->Item->isbn }}">
                本を登録する。
            </button>
            <a href="{{ route('books.show',['book_id'=>$item->Item->isbn])}}">
                <button class="btn letter-dark border-dark">詳細ページへ</button>
            </a>
            @endif
        </div>
        <!-- モーダル グーグルブックの登録フォーム -->
        @include('includes.rakuten_books.rakuten-book-register')

        @endauth
        <!--------------------------- END 認証済みの場合、本の登録可能 --------------------------->


        
        <!-- Start ゲストの場合は、詳細ボタンのみ -->
        @guest
        <div class="search__result-btn">
            <a href="{{ route('guest.show',['book_id'=>$item->Item->isbn])}}">
                <button class="btn letter-dark border-dark">詳細ページへ</button>
            </a>
        </div>
        @endguest
        <!-- End ゲストの場合は、詳細ボタンのみ -->

    </div>

    @endforeach
</div>