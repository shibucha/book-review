@extends('layouts.app')

@section('title', "お問い合わせ")

@section('content')
<div class="contact__container  container">


  <h1 class="contact__title"><span>お問い合わせ</span></h1>

  <div class="contact__summary">
    <p>&nbsp;&nbsp;book-reviewに対するご意見やご感想、その他お問い合わせがございましたら下記お問い合わせフォームよりお聞かせください。</p>
  </div>

  <hr>

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
      <input type="text" name="name" value="{{old('name')}}" class="contact__input-field" placeholder="読書 次郎">
    </div>
    <div class="contact__error">
      @if($errors->has('name'))
      <p>※{{$errors->first('name')}}</p>
      @endif
    </div>

    <div class="contact__input">
      <div class="contact__email contact__item"><span class="contact__required">*</span>メールアドレス</div>
      <input type="text" name="email" value="{{old('email')}}" class="contact__input-field" placeholder="book@example.com">
    </div>
    <div class="contact__error">
      @if($errors->has('email'))
      <p>※{{$errors->first('email')}}</p>
      @endif
    </div>

    <div class="contact__input">
      <div class="contact__message contact__item"><span class="contact__required">*</span>お問い合わせ内容</div>
      <textarea name="message" class="contact__input-field contact__text-field" id="text-field">{{old('message')}}</textarea>
    </div>
    <div class="count-length">
      現在の文字数：<span id="text-length">0</span>/1000文字
    </div>
    <div class="contact__error">
      @if($errors->has('message'))
      <p>※{{$errors->first('message')}}</p>
      @endif
    </div>

    <div class="contact__confirm">
      <button type="submit" class="contact__btn btn-dark">内容を確認する</button>
    </div>
  </form>
</div>
@endsection