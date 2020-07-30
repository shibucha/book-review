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

@if($is_icon)
<figure>
    <a href="{{ route('books.profile') }}">
        <img src="storage/icons/{{ Auth::id()}}.jpg" width="100px" heigh="100px" alt="プロフィール画像">        
    </a>
</figure>
@endif
@endsection