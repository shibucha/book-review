@extends('layouts.app')

@section('title', '設定')

@section('content')

<div class="my-profile__container">
    <!-- 設定一覧 -->
    @include('includes.setting')

    <!-- マイプロフィール設定フォーム -->
    <div class="my-profile__block">
        <div class="my-profile__title setting__title">プロフィールの設定</div>

        <div class="nickname">
            <div>ニックネーム</div>
            <input class="nickname__input" type="text" name="nickname" value="{{ old('nickname')}}">
        </div>

        <div class="self-introduction">
            <div>自己紹介</div>
            <textarea class="self-introduction__body" name="self-introduction" id="" cols="30" rows="8">{{old('self-introduction')}}</textarea>
        </div>

        <div class="my-favorite">
            <div>お気に入り1</div>
            <input type="text" class="my-favorite__title" name="my-favorite1">
            <div>理由</div>
            <input type="text" class="my-favorite__reason" name="my-favorite-reason1">
            <div>ISBNコード</div>
            <input type="text" class="my-favorite__isbn" name="my-favorite-isbn1">

            <div>お気に入り2</div>
            <input type="text" class="my-favorite__title" name="my-favorite2">
            <div>理由</div>
            <input type="text" class="my-favorite__reason" name="my-favorite-reason2">
            <div>ISBNコード</div>
            <input type="text" class="my-favorite__isbn" name="my-favorite-isbn2">

            <div>お気に入り3</div>
            <input type="text" class="my-favorite__title" name="my-favorite3">
            <div>理由</div>
            <input type="text" class="my-favorite__reason" name="my-favorite-reason3">
            <div>ISBNコード</div>
            <input type="text" class="my-favorite__isbn" name="my-favorite-isbn3">
        </div>
    </div>
</div>

@endsection