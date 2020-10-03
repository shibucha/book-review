export class Profile {
    constructor(input_name, new_icon, img_src) {
        this.inputFile = document.getElementById(input_name);
        this.newIconName = document.getElementById(new_icon);
        this.profileImage = document.querySelector(img_src);
    }

    // 登録する画像のファイル名取得
    getFileName() {
        if (this.inputFile) {
            this.inputFile.addEventListener("change", () => {
                const target = event.target;
                const files = target.files;
                const file = files[0];
                this.newIconName.textContent = file.name;

                // 画像のプレビュー表示
                const prof = this;
                const reader = new FileReader();
                reader.readAsDataURL(file);

                reader.onload = () => {
                    prof.profileImage.src = reader.result;
                };
            });
        }
    }
}
