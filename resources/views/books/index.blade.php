@extends('layouts.app')

@section('title', 'マイページ')

@section('content')
@include('layouts.nav')

@if(session('success'))
<div class="alert alert-success">
    {{session('success')}}
</div>
@endif

<p>
    {{ $user->name }}{{ $user->id }}
</p>

<a href="{{route('books.profile',['user_id'=>$user->id])}}">
    @if($user->icon)
    <img src="/storage/icons/{{ $user->icon }}" alt="プロフィール画像" width="200px" width="200px">
    @else
    <img src="/storage/icons/default.png" alt="プロフィール画像" width="200px" width="200px">
    @endif
</a>

@endsection