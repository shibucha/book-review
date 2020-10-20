<template>
    <div class="review">
        <button type="submit" class="good__btn">
            <i
                class="fas fa-heart good"
                :class="{ good__done: this.isLiked }"
                @click="clickLike"
            ></i
            >{{ this.countLikes }}
        </button>
    </div>
</template>

<script>
export default {
    props: {
        initialLike: {
            type: Boolean,
            default: false
        },
        initialCountLikes: {
            type: Number,
            default: 0
        },
        likeRoute: {
            type: String
        }
    },
    data() {
        return {
            isLiked: this.initialLike,
            countLikes: this.initialCountLikes
        };
    },
    methods: {
        clickLike() {
            this.isLiked ? this.unlike() : this.like();
        },
        async like() {
            const response = await axios.put(this.likeRoute);

            this.isLiked = true;
            this.countLikes = response.data.countLikes;
        },
        async unlike() {
            const response = await axios.delete(this.likeRoute);

            this.isLiked = false;
            this.countLikes = response.data.countLikes;
        }
    }
};
</script>

<style scoped>
.good {
    text-shadow: 0 0 2px #000;
    color: #fafafa;
}
.good__done {
    text-shadow: none;
    color: #ff5722;
}

.good__btn{
    outline: none;
}
</style>
