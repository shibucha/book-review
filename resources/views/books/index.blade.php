@extends('layouts.app')

@section('title', 'マイページ')

@section('content')
@include('layouts.nav')

@if(session('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif

<div class="user">
    <div class="user__info">
        <div class="user__name"><i class="fas fa-user-circle"></i> {{ $user->name}} さんのマイページ</div>
        <div class="user__bookCount"><i class="fas fa-book-open"></i> {{ $user->name}} さんがこれまでに読んだ冊数 : ○○冊</div>
    </div>
    <figure class="user__image">
        <a href="{{route('books.profile',['user_id'=>$user->id])}}">
            @if($user->icon)
            <img src="/storage/icons/{{ $user->icon }}" alt="プロフィール画像" width="200px" width="200px">
            @else
            <img src="/storage/icons/default.png" alt="プロフィール画像" width="200px" width="200px">
            @endif
        </a>
    </figure>
</div>

<div class="search">    
    <form action="{{ route('books.search') }}" class="search__form" method="GET">
        <input type="text" name="keyword" placeholder="本を検索する。" style="border:1px solid black;">
        <input type="submit" value="検索">
    </form>
</div>

@endsection