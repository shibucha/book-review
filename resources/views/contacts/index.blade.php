@extends('layouts.app')

@section('title', "お問い合わせ")

@section('content')

<div class="container">
  <h1>お問い合わせフォーム</h1>

  <form action="{{route('contacts.confirm')}}" method="POST">
    @csrf

    <div class="contact__input">
      <div class="contact__name">お名前</div>
      <input type="text" name="name" value="{{old('name')}}">

      <div class="contact__error">
        @if($errors->has('name'))
        <p>{{$errors->first('name')}}</p>
        @endif
      </div>
    </div>

    <div class="contact__input">
      <div class="contact__email">メールアドレス</div>
      <input type="text" name="email" value="{{old('email')}}">

      <div class="contact__error">
        @if($errors->has('email'))
        <p>{{$errors->first('email')}}</p>
        @endif
      </div>
    </div>

    <div class="contact__input">
      <div class="contact__message">お問い合わせ内容</div>
      <textarea name="message">{{old('message')}}</textarea>

      <div class="contact__error">
        @if($errors->has('message'))
        <p>{{$errors->first('message')}}</p>
        @endif
      </div>
    </div>

    <button type="submit" class="btn btn-secondary">内容を確認する</button>
  </form>
</div>
@endsection