@extends('layouts.app')

@section('title', '書籍検索')


@section('content')

<h1>本を探しましょう。</h1>

@if(Auth::check())
<a href="{{route('books.index')}}">マイページに戻る</a>
@else
<a href="{{route('login')}}">ログイン画面へ</a>
@endif

<form method="GET" action="{{ route('books.search') }}">
    <input type="text" name="keyword" value="{{ $keyword }}" style="border:1px solid black;" placeholder="キーワードを入力。">&nbsp;
    <input type="text" name="isbn" value="{{ $isbn }}" style="border:1px solid black;" placeholder="ISBNコードを入力。">&nbsp;
    <input type="submit" value="検索">
    @include('includes.error_list')
</form>

@if(count($items) === 0)
<p>キーワードを入力してください。</p>
@else($items > 0)
<p>{{ isset($keyword) ? $keyword : $isbn }}の検索結果</p>
<hr>

<!-- 検索結果表示 -->

@include('includes.open_bds.open-bd-search')

{{ $items->appends(request()->input())->links() }}
<!-- ↑ ペジネーション機能 -->

@endif
<!-- ↑ キーワードの検索終了 -->

@endsection