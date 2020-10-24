export class Profile {
    constructor(input_name, new_icon, img_src) {
        this.inputFile = document.getElementById(input_name); //<input type="file"> ファイルアップロードを行う部分
        this.newIconName = document.getElementById(new_icon); //新しく設定する画像のデータ名を表示する部分
        this.profileImage = document.querySelector(img_src); //現在のアイコンのimg-src
    }

    // 登録する画像のファイル名取得
    getFileName() {
        if (this.inputFile) {
            this.inputFile.addEventListener("change", () => {
                const target = event.target;
                const files = target.files;
                const file = files[0];

                //アップロード画像のデータ名
                this.newIconName.textContent = file.name;

                // 画像のプレビュー表示
                const prof = this;
                const reader = new FileReader(); //引数なし
                reader.readAsDataURL(file); //データを base64 データurl にエンコード

                //fileの読み込みがエラーなく完了したら発火
                reader.onload = () => {
                    prof.profileImage.src = reader.result; //現在のアイコンイメージソースを一時的に上書き
                };
            });
        }
    }
}
