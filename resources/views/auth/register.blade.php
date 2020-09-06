@extends('layouts.app')

@section('title', '新規登録')

@section('content')

<!-- Material form register -->
@include('layouts.nav')
<div class="for-backgrounds register-page">

    <div class="r-register-prompt">
       <h1 class="register-prompt for-youkoso">ようこそ。<br>あなただけの本棚を<br>作りましょう。</h1>
       <h1 class="register-prompt for-ipad-youkoso">ようこそ。<br>あなただけの本棚を作りましょう。</h1>
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
                        <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}" placeholder="ユーザー名を入力" style="height: 46px; border-radius:8px;">
                        <small>英数字3〜16文字(登録後の変更はできません)</small>
                    </div>

                <!-- メールアドレス -->
                    <div class="entry-field mt-3">
                        <input type="email" id="email" name="email" class="form-control input-lg" required value="{{ old('email') }}" placeholder="メールアドレスを入力" style="height: 46px; border-radius:8px;">
                    </div>

                <!-- パスワード -->
                    <div class="entry-field mt-4">
                        <input type="password" id="password" name="password" class="form-control" required placeholder="パスワードを作成" style="height: 46px; border-radius:8px;">
                    </div>

                <!-- パスワード 再確認-->
                    <div class="entry-field mt-4">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required placeholder="パスワードを入力（確認）" style="height: 46px; border-radius:8px;">
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