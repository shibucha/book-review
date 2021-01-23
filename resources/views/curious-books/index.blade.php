@extends('layouts.app')

@section('title', '読みたい本リスト')

@section('content')

<div class="curious__container">

    @include('includes.reading-history')

    <div class="curious__block">
        読みたい本リスト
    </div>

</div>
@endsection