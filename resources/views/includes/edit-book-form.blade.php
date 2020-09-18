<!-- 編集モーダル -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered" role="document">


        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal__title" id="exampleModalLongTitle">感想を編集する。</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- 書籍タイトル -->
            <p class="modal__book-title">タイトル：{{ $review->book->title }}</p>

            <!-- 編集・登録フォーム -->
            <form action="{{ route('books.update',['reading_record_id'=>$review->id]) }}" method="POST">
                @csrf
                @method('PATCH')
                @include('includes.error_list')

                <div class="modal-body modal__body">

                    <div class="modal__book-title modal__left">
                        <div class="modal__book-image">
                            @if($review->book->image)
                            <img src="{{ $review->book->image}}" alt="書籍のイメージ"><br>
                            @else
                            <img src="/storage/book/book_noimage.png" alt="書籍のイメージ" width="200px" width="200px">
                            @endif
                        </div>
                    </div>

                    <div class="modal__right">
                        <div class="modal__date form-group">
                            <label for="reading_record">読了日:</label>
                            <input type="date" name="reading_date" class="reading_date modal__input-field modal__date-field" value="{{$review->reading_date ?? old('reading_date')}}">
                        </div>
                        <div class="form-group modal__review">
                            <label for="">感想・レビュー:</label>
                            <textarea name="body" placeholder="感想・レビュー" cols="50" rows="10" class="modal__input-field">{{ $review->body ?? old('body')}}</textarea>
                        </div>
                        <div class="modal__private">
                            @if($review->public_private === 1)
                            <input type="checkbox" name="public_private" value="0">非公開にする。
                            @else
                            <input type="checkbox" name="public_private" value="1">公開する。
                            @endif
                        </div>
                        <div class="modal__netabare">
                        @if($review->netabare === "on")
                            <input type="checkbox" name="netabare" value="off">ネタバレ無し
                            @else
                            <input type="checkbox" name="netabare" value="on">ネタバレ有り
                            @endif
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">編集する。</button>
                </div>
            </form>
            <!-- 編集・登録フォーム -->

        </div>
    </div>
</div>