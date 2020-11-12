<template>
    <div>
        <img :src="'../images/header1.png'" class="attach-cards__img" alt="plus">
        <Header :header="getCurrentHeader()"/>
    </div>
</template>

<script>
    import {mapGetters, mapMutations} from "vuex";
    import Header from "../components/Header";

    export default {
    name: "AttachCards.vue",
        mounted() {
            this.setCurrentHeader('Прикрепить карты')
        },
        methods: {
            ...mapGetters(['getCurrentHeader']),
            ...mapMutations(['setCurrentHeader'])
        },
        components: {Header}
  }
</script>

<style scoped>
    .attach-cards__img {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: -1;
    }
</style>
