@extends('layouts.app')

@section('title', 'book-review | プロフィール画像の編集')

@section('content')

<!-- プロフィール画像編集面 -->
<div class="icon icon__container">
  
  <!-- 設定一覧 -->
  @include('includes.setting')

  <div class="icon__wrapper">

    <form class="icon__form" action="{{route('settings.icon',['user_id'=>$user->id]) }}" method="POST" enctype="multipart/form-data">
      @csrf

      <p class="icon__title">プロフィール画像の編集</p>

      <div class="icon__block">
        <div class="icon__icon">
          <!-- プロフィール画像 -->
          @if($user->icon)
          <img class="icon__image" src="{{ $user->icon }}" alt="プロフィール画像">
          <div id="new_icon"></div>
          @else
          <img class="icon__image" src="{{$icon_url}}default.png" alt="プロフィール画像">
          <div id="new_icon"></div>
          @endif
        </div>

        <div class="icon__upload">
          <label for="icon__input" class="btn-dark icon__btn icon__btn-select">
            画像を選ぶ。
            <input type="file" name="icon" id="icon__input">
          </label>

          <!-- プロフィール画像の設定ボタン -->
          <button type="submit" class="btn-info icon__btn icon__btn-set">画像を設定する</button>

          <!-- プロフィール画像の削除ボタン -->
          <a class="" data-toggle="modal" data-target="#modal-delete-{{ $user->id }}">
            <button class="btn-danger icon__btn icon__btn-delete">画像を削除する</button>
          </a>
        </div>
      </div>

      <div class="icon__error">
        @include('includes.error_list')
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
          <form class="modal-delete__form icon-modal-delete__form" method="POST" action="{{ route('settings.icon.destroy', ['user_id'=>$user->id])}}">
            @csrf
            @method('DELETE')
            <div class="modal-delete__body icon-modal-delete__body modal-body">
              プロフィール画像を削除します。よろしいですか？
            </div>
            <div class="modal-footer justify-content-between">

              <a class="btn btn-outline-grey modal-delete__btn icon-modal-delete__btn" data-dismiss="modal">キャンセル</a>
              <button type="submit" class="btn btn-danger modal-delete__btn icon-modal-delete__btn">削除する</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- モーダル -->
  </div>

</div>

@endsection