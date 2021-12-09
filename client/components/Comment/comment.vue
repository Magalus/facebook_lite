<template>
    <div>
        <div class="comment">
            <span class="name">{{ name }}</span>
            <span class="message">{{ message }}</span>
        </div>
        <div class="like"><span @click="isCommentLike = !isCommentLike" :class="{isLike : isCommentLike}">J'aime</span> - <span>10h</span></div>
    </div>
</template>

<script>
export default {
    props: {
        name: String,
        message: String,
    },
    data() {
        return {
            isCommentLike: false,
        }
    }
}
</script>

<style lang="scss" scoped>

.comment {
    width: fit-content;
    background-color: #3D4145;
    margin: 5px 15px 0px 15px;
    font-size: 14px;
    padding: 5px 15px;
    border-radius: 20px;

    span {
        display: block;

        &:first-of-type {
            font-weight: bold;
        }
    }
}

.like {
    margin-left: 30px;
    font-size: 13px;
    color: #CACACC;

    span {
        &:first-child {
            font-weight: bold;

            &:hover {
                cursor: pointer;
                text-decoration: underline;
            }
        }
    }

    .isLike {
        color: #0069D9;
        text-decoration: underline;
    }
}

</style>