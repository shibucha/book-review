@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
@include('layouts.nav')
<div class="container">
    <div class="row">
        <div class="card">

            <h5 class="card-header info-color white-text text-center py-4">
                <strong>ログイン</strong>
            </h5>

            @include('layouts.error_list')
            
            <!--Card content-->
            <div class="card-body px-lg-5 pt-0">

                <!-- Form -->
                <form class="text-center" style="color: #757575;" method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- メールアドレス -->
                    <div class="md-form mt-0">
                        <input type="text"" id=" email" name="email" class="form-control" required value="{{ old('email') }}">
                        <label for="email">メールアドレス</label>
                    </div>

                    <!-- パスワード -->
                    <div class="md-form">
                        <input type="password" id="password"" name=" password" class="form-control" required>
                        <label for="password">パスワード</label>
                    </div>

                    <!-- リメンバートークン -->
                    <input type="hidden" nama="remember" id="remember" value="on">

                    <!-- 登録ボタン -->
                    <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">ログイン</button>

                </form>

                <div class="mt-0">
                    <a href="{{ route('register') }}" class="card-text">ユーザー登録はこちら</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection