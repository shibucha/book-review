@extends('layouts.app')

@section('title', '書籍検索')


@section('content')

<h1>本を探しましょう。</h1>

@if(Auth::check())
<a href="{{route('books.index')}}">マイページに戻る</a>
@else
<a href="{{route('login')}}">ログイン画面へ</a>
@endif

<!-- 検索フォーム -->
@include('includes.google_books.google-book-search-form')

<!-- 検索結果表示 -->
@include('includes.google_books.google-book-search')

<!--  ペジネーション機能 -->
{{ $items->appends(request()->input())->links() }}


<!-- ↑ キーワードの検索終了 -->

@endsection