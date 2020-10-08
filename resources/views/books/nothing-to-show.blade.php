@extends('layouts.app')

@section('title', '表示できるレビューはありません。')


@section('content')

<div class="nothing-to-show__container">
<h1>まだレビューがありません。</h1>


@include('includes.google_books.google-book-nothing-to-show')
</div>

@endsection
