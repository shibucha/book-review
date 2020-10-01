@extends('layouts.app')

@section('title', 'book-review | プロフィールの編集')

@section('content')

<!-- プロフィール画像編集面 -->
<div class="profile profile__container">

  <div class="profile__inner">
    @include('includes.error_list')
    <form class="profile__form" action="{{route('books.profile',['user_id'=>$user->id]) }}" method="POST" enctype="multipart/form-data">
      @csrf

      <p class="profile__title">プロフィール画像の編集</p>

      <div class="profile__block">
        <div class="profile__icon">
          <!-- プロフィール画像 -->
          @if($user->icon)
          <img class="profile__image" src="{{ $user->icon }}" alt="プロフィール画像">
          @else
          <img class="profile__image" src="https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/default.png" alt="プロフィール画像">
          @endif
        </div>

        <div class="profile__upload">
          <label for="profile__input" class="profile__btn profile__btn-select">
            画像を選ぶ。
            <input type="file" name="icon" id="profile__input">
          </label>

          <!-- プロフィール画像の設定ボタン -->
          <button type="submit" class="profile__btn profile__btn-set">画像を設定する</button>

          <!-- プロフィール画像の削除ボタン -->
          <a class="" data-toggle="modal" data-target="#modal-delete-{{ $user->id }}">
            <button class="profile__btn profile__btn-delete">画像を削除する</button>
          </a>
        </div>
      </div>


    </form>

    <!-- モーダル -->
    <div id="modal-delete-{{ $user->id }}" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="{{ route('books.profile.destroy', ['user_id'=>$user->id])}}">
            @csrf
            @method('DELETE')
            <div class="modal-body">
              プロフィール画像を削除します。よろしいですか？
            </div>
            <div class="modal-footer justify-content-between">
              <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
              <button type="submit" class="btn btn-danger">削除する</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- モーダル -->
  </div>

</div>

@endsection