@extends('layouts.app')

@section('title', '設定')

@section('content')

<div class="my-profile__container">
    <!-- 設定一覧 -->
    @include('includes.setting')

    <!-- マイプロフィール設定フォーム -->
    <div class="my-profile__block">
        <div class="my-profile__title setting__title">プロフィールの設定</div>

        <form action="{{route('settings.my_profile_update',['user_id' => $user->id])}}" method="POST">
            @csrf
            @method('PATCH')
            <div class="nickname">
                <div>ニックネーム</div>
                <input class="nickname__input my-profile__input-field" type="text" name="nickname" value="{{ old('nickname')}}">
                <small>20文字以内</small>
            </div>

            <div class="self-introduction">
                <div>自己紹介</div>
                <textarea class="self-introduction__body my-profile__input-field" name="self_introduction" id="" cols="30" rows="8">{{old('self-introduction')}}</textarea>
                <small>255文字以内</small>
            </div>

            <div class="my-favorite">
                <div>お気に入り1</div>
                <input type="text" class="my-favorite__title my-profile__input-field" name="my_favorite_01">
                <div>理由</div>
                <input type="text" class="my-favorite__reason my-profile__input-field" name="my_favorite_reason_01">
                <div>ISBNコード</div>
                <input type="text" class="my-favorite__isbn my-profile__input-field" name="my_favorite_isbn_01">

                <div>お気に入り2</div>
                <input type="text" class="my-favorite__title my-profile__input-field" name="my_favorite02">
                <div>理由</div>
                <input type="text" class="my-favorite__reason my-profile__input-field" name="my_favorite_reason_02">
                <div>ISBNコード</div>
                <input type="text" class="my-favorite__isbn my-profile__input-field" name="my_favorite_isbn_02">

                <div>お気に入り3</div>
                <input type="text" class="my-favorite__title my-profile__input-field" name="my_favorite03">
                <div>理由</div>
                <input type="text" class="my-favorite__reason my-profile__input-field" name="my_favorite_reason_03">
                <div>ISBNコード</div>
                <input type="text" class="my-favorite__isbn my-profile__input-field" name="my_favorite_isbn_03">
            </div>

            <button type="submit" class="btn btn-primary">更新する</button>
        </form>

    </div>
</div>

@endsection