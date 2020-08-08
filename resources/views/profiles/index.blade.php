@extends('layouts.app')

@section('title', 'book-review | プロフィールの編集')

@section('content')
@include('layouts.nav')

<!-- プロフィール画像編集面 -->
<div class="row">
    @include('layouts.error_list')
    <form action="{{route('books.profile',['user_id'=>$user->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card card-body mb-3 col-12">
            <p>プロフィール画像の編集</p>
            <div class="media d-block d-md-flex">
                <small>現在のプロフィール画像</small>
                @if($user->icon)
                <img src="/storage/icons/{{ $user->icon }}" alt="プロフィール画像" width="200px" width="200px">
                @else
                <img src="/storage/icons/default.png" alt="プロフィール画像" width="200px" width="200px">
                @endif

                <div class="media-body text-center text-md-left ml-md-3 ml-0">
                    <input type="file" name="icon">
                    <button type="submit" class="btn btn-primary btn-md">画像を設定する</button>

                    <!-- プロフィール画像の削除ボタン -->
                    <a class="text-danger" data-toggle="modal" data-target="#modal-delete-{{ $user->id }}">
                        <button class="btn btn-danger btn-md">画像を削除する</button>
                    </a>
                </div>
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

@endsection