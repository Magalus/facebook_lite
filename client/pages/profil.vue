<template>
    <b-container>
        <PostCard v-for="post in posts" :key="post.id" :post="post" :ownPost="true" @remove-post="removePost"/>
    </b-container>
</template>

<script>

import PostCard from "@/components/Post/postcard"

export default {
    components: {
        PostCard
    },
    methods: {
        removePost(id) {
            this.posts = this.posts.filter(element => element.id != id)
        },
    },
    async asyncData({app, $axios}) {
      let {data} = await $axios.$get('/api/posts')
      return {
          posts: data.filter(element => element.user.id === app.$auth.user.id)
      }
    }
}

</script>