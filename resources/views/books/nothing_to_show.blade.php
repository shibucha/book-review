@extends('layouts.app')

@section('title', '表示できるレビューはありません。')


@section('content')
@include('layouts.nav')
<h1>表示出来る結果はありません。</h1>

@if($item)

<!-- 書籍のイメージ画像 -->
@if(array_key_exists('imageLinks', $item['volumeInfo']))
<img src="{{ $item['volumeInfo']['imageLinks']['thumbnail'] }}" alt="書籍のイメージ"><br>
@else
<img src="/storage/book/book_noimage.png" alt="書籍のイメージ" width="200px" width="200px">
@endif

<!-- 書籍のタイトル -->
@if(array_key_exists('title', $item['volumeInfo']))
<P>{{ $item['volumeInfo']['title']}}</P>
@endif

<!-- 著者 -->
@if(array_key_exists('authors', $item['volumeInfo']))
著者：{{ $item['volumeInfo']['authors'][0] }}/
@endif

<!-- 出版日 -->
@if(array_key_exists('publishedDate', $item['volumeInfo']))
出版日：{{ $item['volumeInfo']['publishedDate'] }}
@endif

<!-- 概要 -->
@if(array_key_exists('description', $item['volumeInfo']))
<p>概要<br>{{ $item['volumeInfo']['description'] }}</p>
@endif

@endif

<hr>
<p>まだ誰もレビューしていません。</p>
<p>読んで気に入ったら、本棚に追加してみませんか？</p>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{ $item['id'] }}">
    本を登録する。
</button>

<div class="modal fade" id="{{ $item['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered" role="document">


        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal__title" id="exampleModalLongTitle">読んだ本に登録</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- 書籍タイトル -->
            <p class="modal__book-title">タイトル：{{ $item['volumeInfo']['title']}}</p>

            <!-- 登録フォーム -->
            <form action="{{ route('search.store',['book_id'=>$item['id']]) }}" method="POST">
                @csrf
                @include('layouts.error_list')

                <div class="modal-body modal__body">

                    <div class="modal__book-title modal__left">
                        <div class="modal__book-image">
                            @if(array_key_exists('imageLinks', $item['volumeInfo']))
                            <img src="{{ $item['volumeInfo']['imageLinks']['thumbnail']}}" alt="書籍のイメージ"><br>
                            @endif
                        </div>
                    </div>

                    <div class="modal__right">
                        <div class="modal__date form-group">
                            <label for="reading_record">読了日:</label>
                            <input type="date" name="reading_date" class="reading_date modal__input-field modal__date-field">
                        </div>
                        <div class="form-group modal__review">
                            <label for="">感想・レビュー:</label>
                            <textarea name="body" placeholder="感想・レビュー" cols="50" rows="10" value="{{ old('body')}}" class="modal__input-field"></textarea>
                        </div>
                        <div class="modal__private">
                            <input type="checkbox" name="public_private" value="0">非公開にする。
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">登録する。</button>
                </div>
            </form>
            <!-- 登録フォーム -->
        </div>
    </div>
</div>
@endsection
