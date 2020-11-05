export class CountStr {
    constructor(input_str, count_str, register_btn, edit_btn) {
        this.input_str = document.querySelectorAll(input_str);
        this.count_str = document.querySelectorAll(count_str);
        this.register_btn = document.querySelectorAll(register_btn);
        this.edit_btn = document.querySelectorAll(edit_btn);
        this.count = null;
    }

    // 文字カウント
    strCount() {
        // ページ更新を行わずに別の検索結果をクリックした場合、他の検索結果で入力した文字カウントに影響を受けないように設定
        this._resetCount();
        
        // 入力更新カウント
        this._updateCount();
    }

    // 編集フォームの文字カウント
    editCount() {
        this.edit_btn.forEach(btn => {
            btn.addEventListener(
                "click",
                function() {
                    this.input_str.forEach(input => {
                        if (input.value) {
                            this.count_str.forEach(count => {
                                count.innerText = input.value.length;
                            });
                        } else {
                            this.count_str.forEach(count => {
                                count.innerText = 0;
                            });
                        }
                    });
                }.bind(this)
            );
        });

        // 編集フォームの文字カウント後の、入力更新カウント
        this._updateCount();
    }

    // 違うフォームを開いた時に、文字数をリセットする。
    _resetCount() {
        this.register_btn.forEach(btn => {
            btn.addEventListener(
                "click",
                function() {
                    this.count_str.forEach(count => {
                        count.innerText = 0;
                    });
                }.bind(this)
            );
        });
    }

    // 文字数のアップデートカウント
    _updateCount() {
        this.input_str.forEach(input => {
            input.addEventListener(
                "keyup",
                function() {
                    this.count = input.value.length;

                    this.count_str.forEach(count => {
                        count.innerText = this.count;
                    });
                }.bind(this)
            );
        });
    }
}
