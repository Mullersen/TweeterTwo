<template>
    <div class="bg-light">
        <Header/>
        <WelcomeBanner/>
        <Stats />
        <Newest/>
        <Login/>
        <Footer/>
    </div>
</template>

<script>
import Header from './Header.vue';
import WelcomeBanner from './WelcomeBanner.vue';
import Newest from './Newest.vue';
import Stats from './Stats.vue';
import Login from './Login.vue';

    export default {
        name: "Root",
        components : {
            Header,
            WelcomeBanner,
            Newest,
            Stats,
            Login,
        },
    }
</script>
<style>

</style>
