@extends('layouts.app')

@section('title', 'book-review | プロフィールの編集')

@section('content')
@include('layouts.nav')


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
                </div>
            </div>
        </div>
    </form>
</div>

@endsection