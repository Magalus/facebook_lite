<template>
      <b-container>
        <b-form @submit.prevent="register()">
            <b-form-input
                id="input-1"
                v-model="form.name"
                type="text"
                placeholder="Nom"
                ref="name"
                required
            ></b-form-input>
            <div class="error">
                <span v-for="(name, index) in this.errors.name" :key="index">{{name}}</span>
            </div>
            <b-form-input
                id="input-2"
                v-model="form.email"
                type="email"
                placeholder="Adresse mail"
                required
            ></b-form-input>
            <div class="error">
                <span v-for="(email, index) in this.errors.email" :key="index">{{email}}</span>
            </div>
            <b-form-input
                id="input-3"
                v-model="form.password"
                type="password"
                placeholder="Mot de passe"
                required
            ></b-form-input>
            <b-form-input
                id="input-4"
                v-model="form.password_confirmation"
                type="password"
                placeholder="Confirmation du mot de passe"
                required
            ></b-form-input>
            <div class="error">
                <span v-for="(password, index) in this.errors.password" :key="index">{{password}}</span>
            </div>
            <b-button type="submit" variant="primary">S'inscrire</b-button>
            <nuxt-link to="/login">Déjà un compte ?</nuxt-link>
        </b-form>
  </b-container>
</template>

<script>
export default {
    auth: false,
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            errors: ''
        }
    },
    methods: {
        async register() {
            try {
                await this.$axios.get('/sanctum/csrf-cookie')
                await this.$axios.post('/api/register', this.form)
                await this.$auth.loginWith('laravelSanctum', {
                    data: {
                        email: this.form.email,
                        password: this.form.password
                    }
                })
                this.$router.push('/');
            } catch(e) {
                this.errors = e.response.data.errors
            }
        }
    },
    mounted() {
        this.$refs.name.focus()
    }
}
</script>

<style lang="scss" scoped>

form {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: auto;
    margin-top: 100px;
    width: 400px;
    background-color: white;
    padding: 20px 16px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgb(0 0 0 / 10%), 0 8px 16px rgb(0 0 0 / 10%);

    input {
        margin-bottom: 15px;
        padding: 22px 23px;
    }

    button {
        font-size: 20px;
        font-weight: bold;
        width: 100%;
        margin-top: 10px;
        margin-bottom: 20px;
        line-height: 35px;
    }

    a {
        font-size: 14px;
    }

    .error {
        display: inline-block;
        align-self: flex-start;
        color: red;
        font-size: 14px;
        margin-top: -10px;
        margin-bottom: 10px;
        margin-left: 5px;

        span {
            display: block;
        }
    }
}

</style>