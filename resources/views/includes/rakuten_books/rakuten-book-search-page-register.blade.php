<!-- モーダル グーグルブックの登録フォーム -->
<div class="modal fade" id="{{ 'a-'.$item->isbn }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered" role="document">


        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-book__title" id="exampleModalLongTitle">読んだ本に登録</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- 書籍の詳細 -->
            <div class="modal-book__header">
                <!-- 書籍イメージ -->
                <div class="modal-book__image">
                    <div class="modal-book__book-image">
                        @if(array_key_exists('largeImageUrl', $item))
                        <img src="{{ $item->largeImageUrl}}" alt="書籍のイメージ"><br>
                        @endif
                    </div>
                </div>

                <div class="modal-book__details">
                    <!-- 書籍タイトル -->
                    <p class="modal-book__title">書籍名：{{ $item->title}}</p>

                    <!-- 著者 -->
                    <p class="modal-book__author">
                        @if(array_key_exists('author', $item))
                        {{ $item->author }} / 著
                        @endif
                    </p>
                </div>
            </div>


            <!-- 登録フォーム -->
            <form action="{{ route('search.store',['book_id'=>$item->isbn]) }}" method="POST">
                @csrf

                <div class="modal-body modal-book__body">
                    <div class="modal-book__right">
                        <div class="modal-book__date form-group">
                            <label for="reading_record">読了日:</label>
                            <input type="date" name="reading_date" class="reading_date modal-book__input-field modal-book__date-field">
                        </div>
                        <div class="form-group modal-book__review">
                            <label for="">感想・レビュー:</label>
                            <textarea name="body" placeholder="感想・レビュー" cols="50" rows="10" value="{{ old('body')}}" class="modal-book__input-field"></textarea>
                        </div>
                        <div class="modal-book__option modal-book__private">
                            <input type="checkbox" name="public_private" value="0" class="modal-book__margin-right">非公開にする。
                        </div>
                        <div class="modal-book__option modal-book__netabare">
                            <input type="checkbox" name="netabare" value="on" class="modal-book__margin-right">ネタバレ有り
                        </div>

                        <div class="modal-book__option modal-book__star">
                            <div class="modal-book__margin-right">評価</div>
                            <star-rating v-model="rating" @rating-selected="setRating" v-bind:increment="0.5" v-bind:star-size="20" v-bind:rating="0">
                            </star-rating>
                            <!-- 選択した星の値をhiddenで送信する。「:value="rating"」で値を取得する -->
                            <input type="hidden" name="rating" :value="rating" />
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button> -->
                    <button type="submit" class="btn btn-dark modal-book__btn">登録する。</button>
                </div>
            </form>
            <!-- 登録フォーム -->
        </div>
    </div>
</div>