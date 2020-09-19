
<!-- 検索フォーム -->
<form method="GET" action="{{ route('books.search') }}">    
    <input type="text" name="isbn" value="{{ $keyword }}" style="border:1px solid black;" placeholder="ISBNコードを入力。">&nbsp;
    <input type="submit" value="検索">
    @include('includes.error_list')
</form>