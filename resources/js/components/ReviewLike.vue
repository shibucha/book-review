<template>
    <div class="review">
        <button type="submit">            
            <i class="fas fa-heart"
            :class="{'good__done':this.isLiked}"
            ></i>{{ this.countLikes }}
        </button>
    </div>
</template>

<script>
export default{
    props:{
        initialGood:{
            type: Boolean,
            default: false,
        },
        initialCountLikes:{
            type:Number,
            default:0,
        },
    },
    data(){
        return{
            isLiked: this.initialGood,
            countLikes: this.initialCountLikes,
        }
    }
}
</script>

<style scoped>
.good__done{
    color: red;
}
</style>


initialCountLikes