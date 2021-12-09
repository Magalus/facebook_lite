<template>
      <b-card  text-variant="white" :header="myPost.user.name + ' : ' + myPost.created_at">

        <b-card-text v-if="!this.edit">{{ myPost.message }}</b-card-text>
        
        <b-form v-else @submit.prevent="updatePost(myPost.id)">
            <b-form-textarea
                    id="textarea"
                    v-model="form.message"
                    :placeholder="'Quoi de neuf, ' + $auth.user.name + ' ?'"
                    rows="1"
                    required
                ></b-form-textarea>
            <b-button type="submit" variant="primary">Editer</b-button>
        </b-form>

        <div v-if="ownPost" >
              <b-dropdown text="...">
                <b-dropdown-item @click='edit = !edit; form.message = myPost.message'>Editer</b-dropdown-item>
                <b-dropdown-item @click='deletePost(myPost.id)'>Supprimer</b-dropdown-item>
            </b-dropdown>
        </div>

      </b-card>
</template>

<script>

export default {
    props: {
        post: Object,
        ownPost: Boolean,
    },
    data() {
        return {
            myPost: this.post,
            edit: false,
            form: {
                message: this.post.message,
            },
        }
    },
    methods: {
        async deletePost(id) {
            try {
                await this.$axios.$delete(`/api/posts/${id}`);
                this.$emit('remove-post', id)
            } catch(e) {
                this.errors = e.response.data.errors
                console.log(e.response.data.message)
            }
        },
        async updatePost(id) {
            try {
                let {data} = await this.$axios.$patch(`/api/posts/${id}`, this.form);
                this.form.message = data.message
                this.myPost = data
                this.edit = false
            } catch(e) {
                this.errors = e.response.data.errors
            }
        },
    }
}
</script>

<style lang="scss" scoped>

.card {
    background-color: #282C31;
    border-radius: 10px;
    width: 700px;
    margin: auto;
    margin-top: 15px;

    .card-header {
         text-transform: capitalize;
         font-weight: bold;
    }

    textarea {
        margin-bottom: 20px;
    }

    button {
        width: 100%;
    }
}

</style>