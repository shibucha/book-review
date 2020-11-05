<!-- 編集モーダル -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered" role="document">


        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal__title" id="exampleModalLongTitle">読んだ本を編集する。</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-book__header">
                <!-- 書籍イメージ -->
                <div class="modal-book__image">
                    <div class="modal-book__book-image">
                        @if($review->book->image)
                        <img src="{{ $review->book->image}}" alt="書籍のイメージ"><br>
                        @else
                        <img src="https://book-review-shibucha.s3-ap-northeast-1.amazonaws.com/books/book_noimage.png" alt="書籍のイメージ" width="200px" width="200px">
                        @endif
                    </div>
                </div>

                <div class="modal-book__details">
                    <!-- 書籍タイトル -->
                    <p class="modal-book__title">書籍名：{{ $review->book->title}}</p>

                    <!-- 著者 -->
                    <p class="modal-book__author">
                        @if($review->book->author)
                        著　者：{{ $review->book->author->author }}
                        @endif
                    </p>
                </div>
            </div>

            <!-- 編集・登録フォーム -->
            <form action="{{ route('books.update',['reading_record_id'=>$review->id]) }}" method="POST">
                @csrf
                @method('PATCH')


                <div class="modal-body modal-book__body">
                    <div class="modal-book__right">
                        <div class="modal-book__date form-group">
                            <label for="reading_record">読了日:</label>
                            <input type="date" name="reading_date" class="reading_date modal-book__input-field modal-book__date-field" value="{{$review->reading_date ?? old('reading_date')}}">
                        </div>
                        <div class="form-group modal-book__review">
                            <label for="">感想・レビュー:</label>
                            <textarea name="body" placeholder="感想・レビュー" cols="50" rows="10" class="modal-book__input-field text-field">{{ $review->body ?? old('body')}}</textarea>
                        </div>
                        <div class="count-length">
                            現在の文字数：<span class="text-length">{{mb_strlen($review->body ?? "0")}}</span>/500文字
                        </div>
                        <div class="modal-book__option modal-book__private">
                            @if($review->public_private === 1)
                            <input type="checkbox" name="public_private" value="0" class="modal-book__margin-right">非公開にする
                            @else
                            <input type="checkbox" name="public_private" value="1" class="modal-book__margin-right">公開する。
                            @endif
                        </div>
                        <div class="modal-book__option modal-book__netabare">
                            @if($review->netabare === "on")
                            <input type="checkbox" name="netabare" value="off" class="modal-book__margin-right">ネタバレ無し
                            @else
                            <input type="checkbox" name="netabare" value="on" class="modal-book__margin-right">ネタバレ有り
                            @endif
                        </div>

                        <div class="modal-book__option modal-book__star">
                            <!-- 選択した星の値をhiddenで送信する。「:value="rating"」で値を取得する -->
                            <div class="modal-book__star-rating">
                                <input type="radio" name="rating" :value="rating" class="modal-book__margin-right">再評価
                                <star-rating v-model="rating" @rating-selected="setRating" v-bind:increment="0.5" v-bind:star-size="20" v-bind:rating="0"></star-rating>
                            </div>
                            <div class="modal-book__star-not-rating">
                                <input type="radio" name="rating" value="{{ $review->rating }}" class="modal-book__margin-right" checked>再評価しない
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark modal-book__btn">編集する。</button>
                </div>
            </form>
            <!-- 編集・登録フォーム -->

        </div>
    </div>
</div>