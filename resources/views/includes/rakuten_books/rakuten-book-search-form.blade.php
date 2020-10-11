<!-- 検索フォーム -->
@include('includes.error_list')
<form method="GET" action="{{ route('books.search') }}" class="search__form">
    <input type="text" name="keyword" value="{{ $keyword }}" placeholder="キーワードを入力。" class="search__input-field">&nbsp;    
    <input type="text" name="isbn" value="{{ $keyword }}" placeholder="ISBNコードを入力。" class="search__input-field">&nbsp;    
    <input type="submit" value="検索" class="search__input-btn">    
</form>