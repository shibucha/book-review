@extends('layouts.app')

@section('title', '書籍検索')


@section('content')
<div class="search__container">

    <!-- 検索フォーム -->
    @include('includes.rakuten_books.rakuten-book-search-form')

    @if($items === null)
    <div class="search__keyword">
        <p>キーワード、またはISBNコードを入力してください。</p>

    </div>

    @else
    <div class="search__form-flex">
        <!-- 検索キーワード有無のチェック -->
        <div class="search__keyword">
            <p><span class="search__keyword-bold">{{ $keyword }}</span>の検索結果</p>
        </div>

        <div>
            @if(Auth::check())
            <a href="{{route('books.index')}}">マイページに戻る</a>
            @else
            <a href="{{route('login')}}">ログイン画面へ</a>
            @endif
        </div>
    </div>

    <hr>

    <!-- グーグルブックスの検索結果表示 -->
    @include('includes.rakuten_books.rakuten-book-search')

    <!--  ペジネーション機能 -->
    {{ $items->appends(request()->input())->links() }}

    @endif
</div>
@endsection