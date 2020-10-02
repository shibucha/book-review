export class Profile {
    constructor(input, new_icon) {
        this.inputFile = document.getElementById(input);
        this.newIconName = document.getElementById(new_icon);
    }

    // 登録する画像のファイル名取得
    getFileName() {
        this.inputFile.addEventListener("change", () => {
            const target = event.target;
            const files = target.files;
            const file = files[0];
            this.newIconName.textContent = file.name;
        });
    }

}
