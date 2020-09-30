@extends('layouts.app')

@section('title', 'マイページ')

@section('content')

<div class="container">
    <div class="mypage__inner">
        @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
        @endif

        <div class="user mypage__section">
            <div class="user__inner">
                <figure class="user__image">
                    <div class="user__name"><i class="fas fa-user-circle"></i> {{ $user->name}} さんのマイページ</div>
                    <a href="{{route('books.profile',['user_id'=>$user->id])}}">
                        @if($user->icon)
                        <img class="user__image-circle" src="{{ $user->icon }}" alt="プロフィール画像">
                        @else
                        <img class="user__image-circle" src="https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/default.png">
                        @endif
                    </a>
                </figure>
                <div class="user__info">
                    <div class="user__bookCount"><i class="fas fa-book-open"></i> 読書数 : {{ $number_of_readings }}冊</div>
                    <div class="user__reviewCount"><i class="fas fa-pencil-alt"></i> レビュー数 : {{ $reviews_count }}冊</div>
                </div>
            </div>
        </div>

        <div class="search mypage__section">
            @include('includes.error_list')
            <form action="{{ route('books.search') }}" class="search__form" method="GET">
                <div class="search__box">
                    <input class="search__field" type="text" name="keyword" placeholder="キーワードで検索。">
                    <button class="search_btn" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>

        <!-- 登録したレビュー一覧 -->
        <div class="review mypage__section">
            @if($reviews_count > 0)
            @foreach($reviews as $review)
            <a class="review__show" href="{{ route('books.show', ['book_id' => $review->book->book_id])}}">
                <div class="review__book">
                    @if($review->book->image)
                    <img src="{{$review->book->image}}" alt="登録した本のイメージ" class="reading-book_img">
                    @else
                    <img src="/storage.book/book_noimage.png" alt="画像はありません" class="reading-book_img">
                    @endif

                    <div class="review__title">
                        書籍名：{{ $review->book->title }}｜
                        <!-- レビューを登録しているかどうか<div class=""></div> -->
                        @if($review->body)
                        <div class="review__title-done">
                            <i class="fas fa-pencil-alt"></i>レビュー済
                        </div>
                        @endif
                    </div>
                    <div class="review__date">読了日：{{ $review->reading_date }}</div>
                </div>
            </a>
            @endforeach

            <!--  ペジネーション機能 -->
            {{$reviews->links()}}

            @else
            <p>まだ本は登録されていません。</p>
            @endif
        </div>
    </div>
</div>
@endsection