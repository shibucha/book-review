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
@include('includes.open_bds.open-bd-search-form')


<!-- 検索キーワード有無のチェック -->
@if($items === null)
<p>キーワードを入力してください。</p>
@else
<p>{{ $keyword }}の検索結果</p>

<hr>

<!-- グーグルブックスの検索結果表示 -->
@include('includes.open_bds.open-bd-search')

<!--  ペジネーション機能 -->
{{ $items->appends(request()->input())->links() }}

@endif


@endsection