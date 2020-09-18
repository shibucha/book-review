
<!-- 検索フォーム -->
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