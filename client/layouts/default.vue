<template>
    <div class="page" :class="[{isLog: $auth.loggedIn}, {isNotLog : !$auth.loggedIn}]">
        <Navbar/>
        <Nuxt/>
    </div>
</template>

<script>

import Navbar from "@/components/Navbar/navbar"

export default {
    components: {
        Navbar
    },
}
</script>

<style lang="scss" scoped>

.page {
    min-height: 100vh;
    padding-bottom: 20px;
}

.isLog {
    background-color: #18191A;
}

.isNotLog {
    background-color: #F0F2F5;
}

</style>