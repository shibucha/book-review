@extends('layouts.app')

@section('title', 'ログイン')

@section('content')

<div class="for-backgrounds">
    <div class="login-wrapper">
        <h1>ログイン</h1>
        <div class="login-container">

            @include('includes.error_list')

            <!-- FORM -->
            <form action="{{ route('login') }}" method="post">
                @csrf
                <!-- メールアドレス -->
                <div class="entry-field">
                    <input type="text" id="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="メールアドレスを入力" style="height: 46px; border-radius:8px;">
                </div>

                <!-- パスワード -->
                <div class="entry-field password-field">
                    <input type="password" id="password" name="password" class="form-control" required placeholder="パスワードを入力" style="height: 46px; border-radius:8px;">
                </div>

                <!-- リメンバートークン -->
                <input type="hidden" nama="remember" id="remember" value="on">

                <!-- 登録ボタン -->
                <div class="to-login-wrapper">
                    <button class="btn btn-rounded btn-block my-4 waves-effect z-depth-0 login-btn" type="submit" style="height: 46px;">ログイン</button>
                </div>

            </form>

            <p class="no-account">アカウントをお持ちでない方はこちら</p>

            <div class="to-register-wrapper">
                <a class="btn btn-rounded btn-block waves-effect z-depth-0 register-btn" href="{{ route('register')}}" role="button">新規登録</a>
            </div>

            <p class="to-reset-wrapper"><a href="{{route('password.request')}}">パスワードを忘れた方</a></p>
        </div>
    </div>
</div>

@endsection