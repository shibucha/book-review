@extends('layouts.app')

@section('title', 'book-review | プロフィールの編集')

@section('content')
@include('layouts.nav')

<!--Panel-->
<div class="row">
    @include('layouts.error_list')
    <form action="{{route('books.profile')}}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="card card-body mb-3 col-12">
            <p>プロフィール画像の編集</p>
            <div class="media d-block d-md-flex">               
                <img class="d-flex avatar-2 mb-md-0 mb-3 mx-auto" src="https://mdbootstrap.com/img/Others/documentation/img (31)-mini.jpg" alt="current image">

                <div class="media-body text-center text-md-left ml-md-3 ml-0">
                    <input type="file" name="icon">
                    <button type="submit" class="btn btn-primary btn-md">画像を設定する</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection