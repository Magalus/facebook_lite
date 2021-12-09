<template>
  <b-container>
        <b-form @submit.prevent="createPost()">
            <h4>Créer une publication</h4>
            <div class="line"></div>
            <b-form-textarea
                id="textarea"
                v-model="form.message"
                :placeholder="'Quoi de neuf, ' + $auth.user.name + ' ?'"
                rows="1"
                required
            ></b-form-textarea>
            <span class="wrapper">
                <b-button type="submit" variant="primary" :class="{notAllow : this.form.message.length < 1}">Publier</b-button>
            </span>
        </b-form>
  </b-container>
</template>

<script>
export default {
    data() {
        return {
            form: {
                message: '',
            },
            error: undefined
        }
    },
    methods: {
        async createPost() {
            try {
                let {data} = await this.$axios.$post('/api/posts', this.form);
                this.form.message = ''
                this.$emit('add-post', data)
            } catch(e) {
                this.errors = e.response.data.errors
            }
        },
    },
}
</script>

<style lang="scss" scoped>

form {
    display: flex;
    flex-direction: column;
    max-width: 700px;
    margin: auto;
    margin-top: 40px;
    background-color: #343A40;
    padding: 20px 20px;
    border-radius: 10px;

    h4 {
        color: white;
        align-self: center;
    }

    .line {
        margin: 10px 16px 20px 16px;
        border-bottom: solid 1px #505356;
    }

    textarea {
        margin-top: 5px;
        margin-bottom: 20px;
    }

    .wrapper {
        cursor: not-allowed;
    }

    button {
        width: 100%;
    }

    .notAllow {
        background-color: #5D6063;
        border-color: #5D6063;
        color: #9A9CA0;
        pointer-events: none;
    }
}

</style>