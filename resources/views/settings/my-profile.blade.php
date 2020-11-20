@extends('layouts.app')

@section('title', '設定')

@section('content')

<div class="my-profile__container">
    <!-- 設定一覧 -->
    @include('includes.setting')

    <!-- マイプロフィール設定フォーム -->
    <div class="my-profile__block">
        <h1 class="my-profile__title setting__title">プロフィールの設定</h1>

        <div class="my-profile__summary">
            <p>自己紹介や、お気に入りの本を登録出来ます。</p>
        </div>
        <!-- 更新時のフラッシュメッセージ -->
        @if(session('flash_message'))
        <div class="my-profile__flash-message">
            {{session('flash_message')}}
        </div>
        @endif

        @include('includes.error_list')
        <form action="{{route('settings.my_profile_update',['user_id' => $user->id])}}" method="POST">
            @csrf
            @method('PATCH')

            <div class="nickname my-profile__item">
                <div><span class="marker-grey">ニックネーム</span></div>
                <input class="nickname__input my-profile__input-field" type="text" name="nickname" value="{{ $my_profile->nickname??old('nickname')}}">
                <div class="count-length">
                    20文字以内
                </div>
            </div>

            <div class="self-introduction my-profile__item">
                <div><span class="marker-grey">自己紹介</span></div>
                <textarea class="self-introduction__body my-profile__input-field text-field" name="self_introduction" id="" cols="30" rows="8">{{$my_profile->self_introduction??old('self-introduction')}}</textarea>
                <div class="count-length">
                    現在の文字数：<span class="text-length">0</span>/255文字
                </div>
            </div>

            <div class="my-favorite">
                <div class="my-profile__item">
                    <div><span class="favorite-marker-red">お気に入り1</span></div>
                    <input type="text" class="my-favorite__title my-profile__input-field" name="my_favorite_01" value="{{$my_favorite->my_favorite_01??old('my_favorite_01')}}" placeholder="タイトル">
                    <!-- お気に入りの理由 -->
                    <input type="text" class="my-favorite__reason my-profile__input-field" name="my_favorite_reason_01" value="{{$my_favorite->my_favorite_reason_01 ?? old('my_favorite_reason_01')}}" placeholder="理由">
                    <!-- ISBN -->
                    <input type="text" class="my-favorite__isbn my-profile__input-field" name="my_favorite_isbn_01" value="{{$my_favorite->my_favorite_isbn_01 ?? old('my_favorite_isbn_01')}}" placeholder="13桁のISBNコード">
                </div>

                <div class="my-profile__item">
                    <div><span class="favorite-marker-yellow">お気に入り2</span></div>
                    <input type="text" class="my-favorite__title my-profile__input-field" name="my_favorite02" value="{{$my_favorite->my_favorite_02??old('my_favorite_02')}}" placeholder="タイトル">
                    <!-- お気に入りの理由 -->
                    <input type="text" class="my-favorite__reason my-profile__input-field" name="my_favorite_reason_02" value="{{$my_favorite->my_favorite_reason_02 ?? old('my_favorite_reason_02')}}" placeholder="理由">
                    <!-- ISBN -->
                    <input type="text" class="my-favorite__isbn my-profile__input-field" name="my_favorite_isbn_02" value="{{$my_favorite->my_favorite_isbn_02 ?? old('my_favorite_isbn_02')}}" placeholder="13桁のISBNコード">
                </div>

                <div class="my-profile__item">
                    <div><span class="favorite-marker-green">お気に入り3</span></div>
                    <input type="text" class="my-favorite__title my-profile__input-field" name="my_favorite03" value="{{$my_favorite->my_favorite_03??old('my_favorite_03')}}" placeholder="タイトル">
                    <!-- お気に入りの理由 -->
                    <input type="text" class="my-favorite__reason my-profile__input-field" name="my_favorite_reason_03" value="{{$my_favorite->my_favorite_reason_03 ?? old('my_favorite_reason_03')}}" placeholder="理由">
                    <!-- ISBN -->
                    <input type="text" class="my-favorite__isbn my-profile__input-field" name="my_favorite_isbn_03" value="{{$my_favorite->my_favorite_isbn_03 ?? old('my_favorite_isbn_03')}}" placeholder="13桁のISBNコード">
                </div>
            </div>

            <div class="my-profile__btn">
                <button type="submit" class="">更新する</button>
            </div>
        </form>

    </div>
</div>

@endsection