@extends('app')

@section('title', 'ユーザー登録')

@section('content')

<!-- Material form register -->
<div class="container">
    <div class="row">
        <div class="card">

            <h5 class="card-header info-color white-text text-center py-4">
                <strong>ユーザー登録</strong>
            </h5>

            <!--Card content-->
            <div class="card-body px-lg-5 pt-0">

                <!-- Form -->
                <form class="text-center" style="color: #757575;" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-row">
                        <div class="col">
                            <!-- ユーザー名 -->
                            <div class="md-form">
                                <input type="text" id="name" class="form-control" required value="{{ old('name') }}">
                                <label for="name">ユーザー名</label>
                                <small>英数字3〜16文字(登録後の変更はできません)</small>
                            </div>
                        </div>
                    </div>

                    <!-- メールアドレス -->
                    <div class="md-form mt-0">
                        <input type="email" id="email" class="form-control" required value="{{ old('email') }}">
                        <label for="email">メールアドレス</label>
                    </div>

                    <!-- パスワード -->
                    <div class="md-form">
                        <input type="password" id="password"" name=" password" class=" form-control" required>
                        <label for="password">パスワード</label>
                    </div>

                    <!-- パスワード 再確認-->
                    <div class="md-form">
                        <input type="password" id="password_confirmation" name="password_confirmation" class=" form-control" required>
                        <label for="password_confirmation">パスワード（確認）</label>
                    </div>


                    <!-- 登録ボタン -->
                    <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">ユーザー登録</button>

                </form>

                <div class="mt-0">
                    <a href="{{ route('login') }}" class="card-text">ログインはこちら</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Material form register -->
@endsection