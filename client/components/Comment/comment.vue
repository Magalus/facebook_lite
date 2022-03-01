<template>
    <div>
        <div class="comment">
            <span class="name">{{ comment.user.name }}</span>
            <span class="message">{{ comment.message }}</span>
            <div v-if="comment.like_count > 0" @mouseover="hovered = true" @mouseleave="hovered = false" class="commentLikes">
                <b-icon v-if="!isCommentLike" icon="heart"></b-icon>
                <b-icon v-else icon="heart-fill"></b-icon>
                {{ comment.like_count}}
            </div>
             <div v-if="commentLikeUserName.length > 0 && hovered" class="showName">
                <div v-for="(name, index) in commentLikeUserName" :key="index"> {{name}} </div>
            </div>
        </div>
        <div class="like">
            <span @click="likeComment(comment.id); isCommentLike ? comment.like_count -= 1 : comment.like_count += 1" :class="{isLike : isCommentLike}">J'aime</span>
             - 
            <span>{{comment.created_at.slice(7)}}</span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        comment: Object,
        postId : Number,
    },
    data() {
        return {
            isCommentLike: this.comment.likes_user_id.includes(this.$auth.user.id),
            commentLikeUserName: this.comment.likes_user_name.filter(element => element != this.$auth.user.name),
            hovered: false,
        }
    },
    methods: {
        async likeComment(id) {
            try {
                await this.$axios.$post(`/api/posts/${this.postId}/comments/${id}/likes`);
                this.isCommentLike = !this.isCommentLike
            } catch(e) {
                console.log(e.response.data)
            }
        },
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
    position: relative;

    span {
        display: block;

        &:first-of-type {
            font-weight: bold;
        }
    }

    .commentLikes {
        position: absolute;
        background-color: #3D4145;
        padding: 1px 6px 0px 6px;
        border-radius: 10px;
        font-size: 11px;
        right: -27px;
        bottom: 0px;

        &:hover {
            cursor: pointer;
        }

        .bi-heart-fill {
            color: red;
        }
    }

    .showName {
        position: absolute;
        padding: 5px 13px;
        background-color: rgba(255, 255, 255, 0.6);
        font-size: 12px;
        border-radius: 10px;
        color: black;
        text-transform: capitalize;
        right: -47px;
        top: 62px;
        z-index: 99;
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
    }
}

</style>