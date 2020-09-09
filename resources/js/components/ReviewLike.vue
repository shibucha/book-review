<template>
    <div class="review">
        <button type="submit">            
            <i class="fas fa-heart"
            :class="{'good__done':this.isLiked}"
            ></i>{{ this.likesCount }}
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
        initialLikesCount:{
            type:Number,
            default:0,
        },
    },
    data(){
        return{
            isLiked: this.initialGood,
            likesCount: this.initialLikesCount,
        }
    }
}
</script>

<style scoped>
.good__done{
    color: red;
}
</style>
