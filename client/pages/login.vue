<template>
  <b-container>
        <b-form @submit.prevent="login()">
            <b-form-input
                id="input-1"
                v-model="form.email"
                type="email"
                placeholder="Adresse mail"
                ref="email"
                required
            ></b-form-input>
            <b-form-input
                id="input-2"
                v-model="form.password"
                type="password"
                placeholder="Mot de passe"
                required
            ></b-form-input>
            <b-button type="submit" variant="primary">Se connecter</b-button>
            <b-alert v-if="this.error" show variant="danger">{{ this.error }}</b-alert>
            <a href="#">Mot de passe oublié ?</a>
            <div class="line"></div>
            <b-button class="createAccount" variant="success" to="/register">Créer nouveau compte</b-button>
        </b-form>
  </b-container>
</template>

<script>
export default {
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            error: undefined
        }
    },
    methods: {
        login() {
            this.$auth.loginWith('laravelSanctum', {
                data: this.form
            })
            .catch(error => {
               this.error = "Echec de connexion !"
            })
        },
    },
    mounted() {
        this.$refs.email.focus()
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
        margin-bottom: 15px;
        line-height: 35px;
    }

    a {
        font-size: 14px;
    }

    .line {
        width: 100%;
        margin: 20px 16px;
        border-bottom: solid 1px #dadde1;
    }

    .createAccount {
        font-size: 16px;
        font-weight: bold;
        background-color: #42b72a;
        border-color: #42b72a;
        padding: 0.375rem 1.25rem;
        margin-top: 4px;
        margin-bottom: 9px;
        line-height: 35px;

        &:hover {
            background-color: #36A420;
            border-color: #36A420;
        }
    }

    .alert {
        width: 100%;
        text-align: center;
    }
}

</style>