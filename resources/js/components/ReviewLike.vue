<template>
    <div class="review">
        <button type="submit">            
            <i class="fas fa-heart"
            :class="{'good__done':this.isLiked}"
            ></i>3
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
    },
    data(){
        return{
            isLiked: this.initialGood,
        }
    }
}
</script>

<style scoped>
.good__done{
    color: red;
}
</style>
