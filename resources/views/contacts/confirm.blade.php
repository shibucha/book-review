@extends('layouts.app')

@section('title', "お問い合わせ内容の確認")

@section('content')

<div class="container">
    <h1>確認画面</h1>

    @if(isset($data))
    <form action="{{route('contacts.complete')}}" method="POST">
        @csrf

        <div class="confirm">
            <div class="confirm__name">
                <p>お名前：{{$data->name}}</p>
                <input type="hidden" name="name" value="{{$data->name}}">
            </div>

            <div class="confirm__email">
                <p>メールアドレス:{{$data->email}}</p>
                <input type="hidden" name="email" value="{{$data->email}}">
            </div>

            <div class="confirm__message">
                <p>お問い合わせ内容:{{$data->message}}</p>
                <input type="hidden" name="message" value="{{$data->message}}">
            </div>
    
            <button type="submit" class="btn btn-dark">この内容を送信する。</button>
        </div>
    </form>

    @endif

</div>
@endsection