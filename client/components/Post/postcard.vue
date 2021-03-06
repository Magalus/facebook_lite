<template>

    <div class="post">
        
        <div class="header">
            <div>
                <span class="userName">{{myPost.user.name}}</span>
                <span>{{myPost.created_at.slice(7)}}</span>
            </div>
            <div v-if="ownPost" >
                <b-dropdown no-caret text="...">
                    <b-dropdown-item @click='edit = !edit; formEdit.message = myPost.message'>Editer</b-dropdown-item>
                    <b-dropdown-item @click='deletePost(myPost.id)'>Supprimer</b-dropdown-item>
                </b-dropdown>
            </div>
        </div>
        <div class="content">
            <b-card-text v-if="!this.edit">{{ myPost.message }}</b-card-text>
                    
            <b-form v-else @submit.prevent="updatePost(myPost.id)">
                <b-form-textarea
                        id="textarea"
                        v-model="formEdit.message"
                        :placeholder="'Quoi de neuf, ' + $auth.user.name + ' ?'"
                        rows="1"
                        required
                    ></b-form-textarea>
                <span class="cancelEdit">Appuyez sur ÉCHAP pour <span class="cancelLink" @click="edit = false">annuler</span></span>
                <b-button type="submit" variant="primary">Editer</b-button>
            </b-form>
        </div>
        <div class="footer">
            <div @mouseover="hovered = true" @mouseleave="hovered = false">
                <b-icon v-if="!isPostLike" icon="heart"></b-icon>
                <b-icon v-else icon="heart-fill"></b-icon>
                {{ myPost.like_count}}
            </div>
            <div v-if="postLikeUserName.length > 0 && hovered" class="showName">
                <div v-for="(name, index) in postLikeUserName" :key="index"> {{name}} </div>
            </div>
            <div class="comments" @click="commentPart = !commentPart">{{comments.length}} commentaire<span v-if="comments.length > 1">s</span></div>
        </div>
        <div class="line"></div>
        <div class="interaction">
            <span @click="likePost(myPost.id); isPostLike ? myPost.like_count -= 1 : myPost.like_count += 1" :class="{isLike : isPostLike}">J'aime</span>
            <span @click="commentPart = !commentPart">Commenter</span>
            <span>Partager</span>
        </div>
        <div v-if="commentPart" class="line"></div>
        <div v-if="commentPart" class="commentPart">
            <b-form @submit.prevent="createComment(myPost.id)">
                <b-form-input
                    v-model="formComment.message"
                    placeholder="Ecrivez un commentaire..."
                    ref="comment"
                >
                </b-form-input>
            </b-form>
            <Comment v-for="(comment, index) in comments" :key="index" :comment="comment" :postId="myPost.id"/>
        </div>
    </div>
</template>

<script>

import Comment from "@/components/Comment/comment"

export default {
    components: {
        Comment
    },
    props: {
        post: Object,
        ownPost: Boolean,
    },
    data() {
        return {
            myPost: this.post,
            edit: false,
            isPostLike: this.post.likes_user_id.includes(this.$auth.user.id),
            postLikeUserName: this.post.likes_user_name.filter(element => element != this.$auth.user.name),
            comments: this.post.comments,
            commentPart : false,
            hovered: false,
            formEdit: {
                message: this.post.message,
            },
            formComment: {
                message: ""
            }
        }
    },
    methods: {
        async deletePost(id) {
            try {
                await this.$axios.$delete(`/api/posts/${id}`);
                this.$emit('remove-post', id)
            } catch(e) {
                console.log(e.response.data.errors)
            }
        },
        async updatePost(id) {
            try {
                let {data} = await this.$axios.$patch(`/api/posts/${id}`, this.formEdit);
                this.formEdit.message = data.message
                this.myPost = data
                this.edit = false
            } catch(e) {
                console.log(e.response.data.errors)
            }
        },
        async likePost(id) {
            try {
                await this.$axios.$post(`/api/posts/${id}/likes`);
                this.isPostLike = !this.isPostLike
            } catch(e) {
                console.log(e.response.data.errors)
            }
        },
        async createComment(id) {            
            try {
                let {data} = await this.$axios.$post(`/api/posts/${id}/comments`, this.formComment);
                this.comments.push(data)
                this.formComment.message = ""
            } catch(e) {
                    console.log(e.response.data.errors)
            }
        },
    },
    mounted() {
        window.addEventListener('keydown', (e) => {
            if (e.key == 'Escape') {
                this.edit = false;
            }
        });
    }
}
</script>

<style lang="scss" scoped>

.post {
    background-color: #282C31;
    color: white;
    border-radius: 10px;
    width: 700px;
    margin: auto;
    margin-top: 15px;

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px 0px 15px;
        font-weight: bold;

        .userName {
            text-transform: capitalize;
        }

        span {
            display: block;
            
            &:nth-last-of-type(1) {
                font-size: 13px;
                margin-top: -3px;
                color: #9B9B9E;
            }
        }
    }

    .content {
        display: flex;
        padding: 15px;
        padding-bottom: 0px;

        form {
            width: 100%;

        textarea {
            border-radius: 20px;
            border: none;

            &:focus {
                box-shadow: none;
            }
    }

            button {
                width: 100%;
                margin-top: 15px;
                border-radius: 20px;
            }

            .cancelEdit {
                font-size: 12px;
                margin-left: 5px;
                color: #D0D1D2;

                .cancelLink {
                    color: #0069D9;
                    cursor: pointer;
                    font-weight: bold;
                    text-decoration: underline;
                }
            }
        }
    }

    .footer {
        display: flex;
        justify-content: space-between;
        margin: 15px;
        font-size: 14px;
        color: #CACACC;

        .bi-heart-fill {
            color: red;
        }

        div {
            cursor: pointer;
        }

        .showName {
            position: absolute;
            margin-top: 30px;
            padding: 5px 13px;
            background-color: rgba(255, 255, 255, 0.6);
            font-size: 13px;
            border-radius: 10px;
            color: black;
            text-transform: capitalize;
            z-index: 99;
        }

        .comments {
            &:hover {
                text-decoration: underline;
            }
        }
    }

    .line {
        border-bottom: 1px solid #575758;
        margin: 0px 15px;
    }

    .interaction {
        display: flex;
        justify-content: space-around;
        color: #CACACC;
        font-size: 15px;
        font-weight: bold;

        span {
            width: 100%;
            text-align: center;
            padding: 5px 15px;
            margin: 5px 10px;
            border-radius: 5px;

            &:hover {
                cursor: pointer;
                background-color: #3D4145;
                color: #B5B5B8;
            }
        }

        .isLike {
            color: #0069D9;

            &:hover {
                color: #0069D9;
            }
        }
    }

    .commentPart {
        margin-top: 15px;
        padding-bottom: 10px;

        form {
            margin: 0px 15px 15px 15px;

            input {
                border-radius: 20px;
                border: none;
                padding: 0px 15px;
                background-color: #3D4145;
                color: white;

                &:focus {
                    box-shadow: none;
                }

                &::placeholder {
                    color: #9B9B9E;
                }
            }
        }
    }
}

</style>