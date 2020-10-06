@extends('layouts.app')

@section('title', 'マイページ')

@section('content')

<div class="mypage__container">
    <div class="mypage__inner">

        <!-- マイプロフィール -->
        <div class="user mypage__section">
            <div class="user__inner">
                <figure class="user__image">
                    <a href="{{route('settings.icon',['user_id'=>$user->id])}}">
                        @if($user->icon)
                        <img class="user__image-circle" src="{{ $user->icon }}" alt="プロフィール画像">
                        @else
                        <img class="user__image-circle" src="https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/default.png">
                        @endif
                    </a>
                    <div class="user__name"><span class="user__name-bold">{{ $user->myProfile->nickname ?? $user->name }}</span> さんのマイページ</div>
                </figure>

                <div class="user__info">
                    <!-- レビューに関する情報 -->
                    <div class="user__review-info user__info-common">
                        <div class="user__bookCount"><i class="fas fa-book-open"></i> 読書数 : {{ $number_of_readings }} 冊</div>
                        <div class="user__reviewCount"><i class="fas fa-pencil-alt"></i> レビュー数 : {{ $reviews_count }} 冊</div>
                    </div>

                    <!-- 自己紹介文 -->
                    <div class="user__introduction user__info-common">
                        <div class="user__subtitle">自己紹介</div>
                        <div class="user__introduction-body">{{ $user->myProfile->self_introduction ?? ''}}</div>
                    </div>

                    <!-- お気に入りベスト３ -->
                    <div class="user__favorite user__info-common">
                        <div class="user__subtitle">お気に入りベスト３</div>
                        <div class="user__favorite user__favorite-1">
                            <div>
                                1位 ： {{$user->myFavorite->my_favorite_01 ?? '登録がありません'}}
                            </div>
                            <div>
                                ISBN : {{$user->myFavorite->my_favorite_isbn_01 ?? '登録がありません' }}
                            </div>
                        </div>
                        <div class="user__favorite user__favorite-2">
                            <div>
                                2位 ： {{$user->myFavorite->my_favorite_02 ?? '登録がありません'}}
                            </div>
                            <div>
                                ISBN : {{$user->myFavorite->my_favorite_isbn_02 ?? '登録がありません' }}
                            </div>
                        </div>
                        <div class="user__favorite user__favorite-3">
                            <div>
                                3位 ： {{$user->myFavorite->my_favorite_03 ?? '登録がありません'}}
                            </div>
                            <div>
                                ISBN : {{$user->myFavorite->my_favorite_isbn_03 ?? '登録がありません' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- エラーメッセージ -->
        <div class="search mypage__section">
            @include('includes.error_list')
            <form action="{{ route('books.search') }}" class="search__form" method="GET">
                <div class="search__box">
                    <input class="search__field" type="text" name="keyword" placeholder="キーワードで検索。">
                    <button class="search__btn" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>

        <!-- 登録したレビュー一覧 -->
        <div class="review mypage__section">
            @if($reviews->count() > 0)
            @foreach($reviews as $review)
            <a class="review__show" href="{{ route('books.show', ['book_id' => $review->book->book_id])}}">
                <div class="review__book">
                    @if($review->book->image)
                    <img src="{{$review->book->image}}" alt="登録した本のイメージ" class="review__book-img">
                    @else
                    <img src="/storage.book/book_noimage.png" alt="画像はありません" class="review__book-img">
                    @endif

                    <div class="review__title">
                        {{ $review->book->title }} /
                        <!-- レビューを登録しているかどうか -->
                        @if($review->body)
                        <span class="review__title-done">
                            <i class="fas fa-pencil-alt"></i>レビュー済
                        </span>
                        @endif
                    </div>
                    <div class="review__date">読了日：{{ $review->reading_date }}</div>
                </div>
            </a>
            @endforeach

            <!--  ペジネーション機能 -->
            <div class="pagenate">
                {{$reviews->links()}}
            </div>

            @else
            <p>まだ本は登録されていません。</p>
            @endif
        </div>
    </div>
</div>
@endsection