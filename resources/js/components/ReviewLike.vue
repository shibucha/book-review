<template>
    <div class="review">
        <button type="submit">            
            <i class="fas fa-heart"
            :class="{'good__done':goodDone}"
            ></i>3
        </button>
    </div>
</template>

<script>
export default{
    props:{
        goodDone:{
            type: Boolean,
            default: false,
        },
    },
    data(){

    }
}
</script>

<style scoped>
.good__done{
    color: red;
}
</style>
