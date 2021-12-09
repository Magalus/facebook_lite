<template>
    <b-container>
        <Postcreate @add-post="addNewPost"/>
        <PostCard v-for="post in posts" :key="post.id" :post="post"/>
    </b-container>
</template>

<script>

import Postcreate from "@/components/Post/postcreate"
import PostCard from "@/components/Post/postcard"

export default {
    components: {
        Postcreate,
        PostCard
    },
    methods: {
        addNewPost(post) {
            this.posts.unshift(post)
        },
    },
    async asyncData({$axios}) {
        let {data} = await $axios.$get('/api/posts')
        return {
            posts: data
        }
    }
}

</script>

