@extends('layouts.app')

@section('title', '新規登録')

@section('content')

<!-- Material form register -->
@include('layouts.nav')
<div class="for-backgrounds register-page">

    <div>
       <h1 class="register-prompt">ようこそ。<br>あなただけの本棚を<br>作りましょう。</h1>
    </div> 

    <div class="register-wrapper">
        <h1>新規登録</h1>
            <div class="register-container">

                @include('layouts.error_list')
            
                <!-- Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                <!-- ユーザー名 -->
                    <div class="entry-field">
                        <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}" placeholder="ユーザー名を入力">
                        <small>英数字3〜16文字(登録後の変更はできません)</small>
                    </div>

                <!-- メールアドレス -->
                    <div class="entry-field mt-3">
                        <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="メールアドレスを入力">
                    </div>

                <!-- パスワード -->
                    <div class="entry-field mt-4">
                        <input type="password" id="password" name="password" class="form-control" required placeholder="パスワードを作成">
                    </div>

                <!-- パスワード 再確認-->
                    <div class="entry-field mt-4">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required placeholder="パスワード（確認）">
                    </div>

                <!-- 登録ボタン -->
                    <div class="to-register-wrapper">
                        <button class="btn btn-rounded btn-block my-4 waves-effect z-depth-0 register-button" type="submit">新規登録</button>
                    </div>

                </form>

                <p class="no-account">すでにアカウントをお持ちの方はこちら</p>

                <div class="to-login-wrapper">
                    <a href="{{ route('login') }}" class="btn btn-rounded btn-block waves-effect z-depth-0 login-button">ログイン</a>
                </div>

            </div>

    </div>

</div>
<!-- Material form register -->
@endsection