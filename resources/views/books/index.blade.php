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
                        <img class="user__image-circle" src="{{ $icon_url }}default.png">                        
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
                            <div class="user__favorite-title">
                                <span class="best best-1">1位</span> ： <button type="button" class="best-btn best-1__btn" data-toggle="modal" data-target="#my_favorite_01">{{$user->myFavorite->my_favorite_01 ?? '登録がありません'}}</button>
                            </div>
                            <div class="user__favorite-isbn">
                                @if(isset($user->myFavorite->my_favorite_isbn_01))
                                <a href="{{route('books.show',['book_id'=> $user->myFavorite->my_favorite_isbn_01])}}" class="user__favorite-link">
                                    ISBN : <span class="hover-bold">{{$user->myFavorite->my_favorite_isbn_01}}</span>
                                </a>
                                @else
                                ISBN : 登録がありません
                                @endif
                            </div>
                        </div>
                        <div class="user__favorite user__favorite-2">
                            <div class="user__favorite-title">
                                <span class="best best-2">2位</span> ： <button type="button" class="best-btn best-2__btn" data-toggle="modal" data-target="#my_favorite_02">{{$user->myFavorite->my_favorite_02 ?? '登録がありません'}}</button>
                            </div>
                            <div class="user__favorite-isbn">
                                @if(isset($user->myFavorite->my_favorite_isbn_02))
                                <a href="{{route('books.show',['book_id'=> $user->myFavorite->my_favorite_isbn_02])}}" class="user__favorite-link">
                                    ISBN : <span class="hover-bold">{{$user->myFavorite->my_favorite_isbn_02 }}</span>
                                </a>
                                @else
                                ISBN : 登録がありません
                                @endif
                            </div>
                        </div>
                        <div class="user__favorite user__favorite-3">
                            <div class="user__favorite-title">
                                <span class="best best-3">3位</span> ：<button type="button" class="best-btn best-3__btn" data-toggle="modal" data-target="#my_favorite_03">{{$user->myFavorite->my_favorite_03 ?? '登録がありません'}}</button>
                            </div>
                            <div class="user__favorite-isbn">
                                @if(isset($user->myFavorite->my_favorite_isbn_03))
                                <a href="{{route('books.show',['book_id'=> $user->myFavorite->my_favorite_isbn_03])}}" class="user__favorite-link">
                                    ISBN : <span class="hover-bold">{{$user->myFavorite->my_favorite_isbn_03 }}</span>
                                </a>
                                @else
                                ISBN : 登録がありません
                                @endif
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


    <!-- モーダル グーグルブックの登録フォーム -->
    <!-- お気に入り1 -->
    <div class="modal fade" id="my_favorite_01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title modal-book__title modal__favorite-title" id="exampleModalLongTitle">{{$user->myFavorite->my_favorite_01 ?? '未登録'}}</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal__favorite-reason">お気に入りの理由</div>
                    <div class="modal__favorite-body">
                        {{$user->myFavorite->my_favorite_reason_01 ?? '登録がありません。'}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- お気に入り2 -->
    <div class="modal fade" id="my_favorite_02" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title modal-book__title modal__favorite-title" id="exampleModalLongTitle">{{$user->myFavorite->my_favorite_02 ?? '未登録'}}</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal__favorite-reason">お気に入りの理由</div>
                    <div class="modal__favorite-body">
                        {{$user->myFavorite->my_favorite_reason_02 ?? ''}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- お気に入り3 -->
    <div class="modal fade" id="my_favorite_03" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title modal-book__title modal__favorite-title" id="exampleModalLongTitle">{{$user->myFavorite->my_favorite_03 ?? '未登録'}}</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal__favorite-reason">お気に入りの理由</div>
                    <div class="modal__favorite-body">
                        {{$user->myFavorite->my_favorite_reason_03 ?? ''}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection