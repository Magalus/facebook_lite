<template>
    <b-navbar toggleable="lg" type="dark" :variant="$auth.loggedIn ? 'dark' : 'primary'">
        <b-navbar-brand to="/">Facebook Lite</b-navbar-brand>
        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav class="ml-auto">
                <template v-if="$auth.loggedIn">
                        <b-nav-item to="/">Accueil</b-nav-item>
                        <b-nav-item to="/profil" class="profil">{{ $auth.user.name }}</b-nav-item>
                        <b-nav-item to="/message">Messages</b-nav-item>
                        <b-nav-item to="/friend">Amis</b-nav-item>
                        <b-nav-item>Notifications</b-nav-item>

                        <b-nav-item @click.prevent="logout()">Déconnexion</b-nav-item>
                </template>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
export default {
    methods: {
        async logout() {
            try {
                await this.$auth.logout()
            } catch (error) {
                console.log(error)
            }
        }
    }
}
</script>

<style lang="scss" scoped>

.profil {
    text-transform: capitalize;
}

</style>
