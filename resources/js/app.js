require("./bootstrap");
import Vue from "vue";
import ReviewLike from "./components/ReviewLike.vue";
import StarRating from 'vue-star-rating';


// flatpickerの使用
import {Calender} from "./libs/Calender";


//Vue インスタンスの作成
const app = new Vue({
    el: '#app',
    methods:{
        setRating(rating){  
            this.rating = rating;    
        },        
    },
    data:{
        rating: 1,
    },
    components:{
        ReviewLike,
        StarRating,   
    }
});

//  flatpickrの使用（Vueインスタンス作成の後に設置する）
new Calender(".reading_date");




