require("./bootstrap");
import Vue from "vue"
import ReviewLike from "./components/ReviewLike.vue"

// flatpickerの使用
import { Calender } from "./libs/Calender.js"



//  flatpickrの使用
new Calender(".reading_date");

const app = new Vue({
    el: '#app',
    components: {
      ReviewLike,
    }
  })

