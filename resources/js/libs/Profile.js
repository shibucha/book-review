export class Profile {
    constructor(input, new_icon, img_src) {
        this.inputFile = document.getElementById(input);
        this.newIconName = document.getElementById(new_icon);
        this.profileImage = document.querySelector(img_src);
    }

    // 登録する画像のファイル名取得
    getFileName() {
        this.inputFile.addEventListener("change", () => {
            const target = event.target;
            const files = target.files;
            const file = files[0];
            this.newIconName.textContent = file.name;

            // 画像のプレビュー表示
            const prof = this;
            const reader = new FileReader();
            reader.readAsDataURL(file);
           
            reader.onload = ()=>{
                prof.profileImage.src = reader.result;
                // console.log(reader.result);   
            };
        });
    }

}
