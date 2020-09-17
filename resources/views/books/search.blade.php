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
    <input type="text" name="keyword" value="{{ $keyword }}" style="border:1px solid black;">&nbsp;
    <input type="submit" value="検索">
</form>

@if($items === null)
<p>キーワードを入力してください。</p>
@else($items > 0)
<p>{{ $keyword }}の検索結果</p>
<hr>

<!-- グーグルブックスの検索結果表示 -->
@include('includes.open_bds.open-bd-search')



@endif
<!-- ↑ キーワードの検索終了 -->

{{ $items->appends(request()->input())->links() }}
<!-- ↑ ペジネーション機能 -->

@endsection