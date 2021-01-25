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
            <a href="{{route('books.show',['book_id'=>$book->book->book_id])}}">
                <img src="{{$book->book->image}}" alt="">
                <div class="curious__title">{{$book->book->title}}</div>
            </a>
            @endforeach
        </div>
        @endif
    </div>

</div>
@endsection