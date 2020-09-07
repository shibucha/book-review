require("./bootstrap");
import Vue from "vue";
import ReviewLike from "./components/ReviewLike.vue";

// flatpickerの使用
import {Calender} from "./libs/Calender";


//Vue インスタンスの作成
const app = new Vue({
    el: '#app',
    components:{
        ReviewLike,
    }
});

//  flatpickrの使用（Vueインスタンス作成の後に設置する）
new Calender(".reading_date");




