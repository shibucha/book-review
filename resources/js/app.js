require("./bootstrap");
import Vue from "vue";
import ReviewLike from "./components/ReviewLike.vue";
import StarRating from "vue-star-rating";

// flatpickerの使用
import { Calender } from "./libs/Calender";
import { Profile } from "./libs/Profile";
import { CountStr } from "./libs/CountStr";

//Vue インスタンスの作成
const app = new Vue({
    el: "#app",
    methods: {
        setRating(rating) {
            this.rating = rating;
        }
    },
    data: {
        rating: 1
    },
    components: {
        ReviewLike,
        StarRating
    }
});

//  flatpickrの使用（Vueインスタンス作成の後に設置する）
new Calender(".reading_date");

// プロフィールアイコン関連
const file = new Profile("icon__input", "new_icon", ".icon__image");
file.getFileName(); //画像の下に新しく登録するファイル名を取得して画面に表示

// 文字カウント
const count = new CountStr(".text-field",".text-length", ".register-btn", ".edit-btn");
count.strCount();
count.editCount();