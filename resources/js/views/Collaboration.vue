<template>
<section class="collaboration header-background" :style="{backgroundImage: 'url(' + image + ')'}">
<!--    <img :src="'../images/header4.png'" class="collaboration__img" alt="plus">-->
    <Header  :header="getCurrentHeader()"/>

    <ShareForm />
    <UsersList />
</section>
</template>

<script>
    import ShareForm from '../components/ShareForm'
    import UsersList from "../components/UsersList";
    import Header from "../components/Header"
    import {mapGetters, mapMutations} from "vuex"
    export default {
        name: "Collaboration.vue",
        data() {
            return {
                image: '../images/header4.svg',
            }
        },
        components: {ShareForm, UsersList, Header},
        mounted() {
            this.setCurrentHeader('Поделиться')
        },
        methods: {
            ...mapGetters(['getCurrentHeader']),
            ...mapMutations(['setCurrentHeader'])
        }
    }
</script>

<style scoped>
    .collaboration__img {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: -1;
    }
</style>
