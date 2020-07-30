@extends('layouts.app')

@section('title', 'マイページ')

@section('content')
@include('layouts.nav')
<p>マイページの予定です！</p>

@if(session('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif

@if($is_icon ?? '')
<figure>
    <img src="" width="100px" heigh="100px" alt="プロフィール画像">ï
</figure>
@endif
@endsection