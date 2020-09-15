@extends('layouts.app')

@section('title', 'アカウントの削除')

@section('content')
<p>Book Yourshelfを退会しますか？</p>

<form action="{{route('setting.resign')}}" method="post">
    @method('DELETE')
    @csrf
    <button type="submit" class="btn btn-danger">
        退会します。
    </button>
</form>

@endsection