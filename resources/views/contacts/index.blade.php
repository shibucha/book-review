@extends('layouts.app')

@section('title', "お問い合わせ")

@section('content')
<h1>お問い合わせフォーム</h1>

<form action="{{route('contacts.confirm')}}" method="GET">
  @csrf

  
</form>
@endsection