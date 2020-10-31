@extends('layouts.app')

@section('title', "お問い合わせ内容の確認")

@section('content')

<div class="contact__container container">

    <h1 class="contact__title">確認画面</h1>

    <div class="contact__summary">
        <p>&nbsp;&nbsp;お問い合わせ内容にお間違いはないですか？問題なければ送信ボタンを押してください。</p>
    </div>

    <hr>

    @if(isset($data))
    <form action="{{route('contacts.complete')}}" method="POST" class="contact__form">
        @csrf

        <div class="contact__input">
            <div class="contact__name contact__item"><span class="marker-grey">お名前</span></div>
            <div class="confirm__field">&nbsp;&nbsp;{{$data->name}}</div>
            <input type="hidden" name="name" value="{{$data->name}}">
        </div>

        <div class="contact__input">
            <div class="contact__email contact__item"><span class="marker-grey">メールアドレス</span></div>
            <div class="confirm__field">&nbsp;&nbsp;{{$data->email}}</div>
            <input type="hidden" name="email" value="{{$data->email}}">
        </div>

        <div class="contact__input">
            <div class="contact__message contact__item"><span class="marker-grey">お問い合わせ内容</span></div>
            <div class="confirm__field">&nbsp;&nbsp;{{$data->message}}</div>
            <input type="hidden" name="message" value="{{$data->message}}">
        </div>

        <div class="contact__confirm">
            <button type="submit" class="contact__btn btn-dark">この内容を送信する。</button>
        </div>
    </form>
    @endif

</div>
@endsection