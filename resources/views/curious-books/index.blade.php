@extends('layouts.app')

@section('title', '読みたい本リスト')

@section('content')

<div class="curious__container">

    @include('includes.reading-history')

    <div class="curious__block">
        <h1>読みたい本</h1>

        @if(isset($curious_books))
        <div class="curious__lists">
            @foreach($curious_books as $book)
            <div class="curious__item">
                <a href="{{route('books.show',['book_id'=>$book->book->book_id])}}">
                    <img src="{{$book->book->image}}" alt="">
                    <div class="curious__title">
                        {{$book->book->title}}
                        <form action="{{route('curious.update', ['book_isbn'=>$book->book->book_id])}}" method="post">
                            @csrf
                            <button type="submit">リストから外す</button>
                        </form>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <p>まだ登録はありません。</p>
        @endif
    </div>

</div>
@endsection