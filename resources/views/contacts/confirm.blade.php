@extends('layouts.app')

@section('title', "お問い合わせ内容の確認")

@section('content')

<div class="container">
    <h1>確認画面</h1>

    @if(isset($data))
    <form action="{{route('contacts.complete')}}" method="POST" class="contact__form">
        @csrf

        <div class="contact__input">
            <div class="contact__name contact__item">お名前</div>
            <div>{{$data->name}}</div>
            <input type="hidden" name="name" value="{{$data->name}}">
        </div>

        <div class="contact__input">
            <div class="contact__email contact__item">メールアドレス</div>
            <div>{{$data->email}}</div>
            <input type="hidden" name="email" value="{{$data->email}}">
        </div>

        <div class="contact__input">
            <div class="contact__message contact__item">お問い合わせ内容</div>
            <div>{{$data->message}}</div>
            <input type="hidden" name="message" value="{{$data->message}}">
        </div>

        <div class="contact__confirm">
            <button type="submit" class="contact__btn btn-dark">この内容を送信する。</button>
        </div>
    </form>
    @endif

</div>
@endsection