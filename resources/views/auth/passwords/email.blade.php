@extends('layouts.app')

@section('title', 'パスワード再設定')

@section('content')
<div class="reset__container">
    <div class="reset__title">
        <h2>パスワードの再設定</h2>
    </div>
</div>

@include('includes.error_list')

<div class="session">
    @if(session('status'))
    <div class="session__message">
        {{session('status')}}
    </div>
    @endif
</div>

<div class="reset__form">
    <form action="{{route('password.email')}}" method="post">
        @csrf
        <div class="reset__input">
            <div class="email">メールアドレス</div>
            <input type="text" name="email" id="email" class="input" required>
        </div>
        <button class="reset__btn">メール送信</button>
    </form>
</div>
@endsection