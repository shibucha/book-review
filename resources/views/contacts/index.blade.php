@extends('layouts.app')

@section('title', "お問い合わせ")

@section('content')

<div class="container">
  <h1>お問い合わせフォーム</h1>

  <!-- 送信完了後のフラッシュメッセージ -->
  @if(session('flash_message'))
  <div class="contact__flash">
    {{session('flash_message')}}
  </div>
  @endif

  <form action="{{route('contacts.confirm')}}" method="POST" class="contact__form">
    @csrf

    <div class="contact__attention">
      *は必須項目です。
    </div>

    <div class="contact__input">
      <div class="contact__name contact__item"><span class="contact__required">*</span>お名前</div>
      <input type="text" name="name" value="{{old('name')}}" class="contact__input-field">
    </div>
    <div class="contact__error">
      @if($errors->has('name'))
      <p>{{$errors->first('name')}}</p>
      @endif
    </div>

    <div class="contact__input">
      <div class="contact__email contact__item"><span class="contact__required">*</span>メールアドレス</div>
      <input type="text" name="email" value="{{old('email')}}" class="contact__input-field">
    </div>
    <div class="contact__error">
      @if($errors->has('email'))
      <p>{{$errors->first('email')}}</p>
      @endif
    </div>

    <div class="contact__input">
      <div class="contact__message contact__item"><span class="contact__required">*</span>お問い合わせ内容</div>
      <textarea name="message" class="contact__input-field contact__text-field">{{old('message')}}</textarea>
    </div>
    <div class="contact__error">
      @if($errors->has('message'))
      <p>{{$errors->first('message')}}</p>
      @endif
    </div>

    <div class="contact__confirm">
      <button type="submit" class="contact__btn btn-dark">内容を確認する</button>
    </div>
  </form>
</div>
@endsection