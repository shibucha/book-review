@extends('layouts.app')

@section('title', 'アカウントの削除')

@section('content')
@include('layouts.setting')

<p>
    Your Bookshelfを退会すると、これまで記録したデータが全て削除されます。<br>
    このまま退会してもよろしいですか？
</p>

<button type="button" class="btn btn-danger modal-delete__btn" data-toggle="modal" data-target="#resign">退会する</button>

<!-- 退会モーダル -->
<div id="resign" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('settings.resign')}}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-body modal-delete__body">
                    <span class="app__resign-name">Your Bookshelf<span>を退会しますか？
                </div>
                <div class="modal-footer justify-content-between">
                    <a class="btn btn-outline-grey modal-delete__btn" data-dismiss="modal">キャンセル</a>
                    <button type="submit" class="btn btn-danger modal-delete__btn">退会する</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
