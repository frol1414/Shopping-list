<template>
    <div class="wrapper">

<!--        <aside class="main-navigation" :class="{mainNavigationToggle: !showNavigation}"-->
<!--               v-touch:swipe.left="swipeNavigation"-->
<!--               v-touch-options="{swipeTolerance: 20, touchHoldTolerance: 200}"-->
<!--        >-->
<!--            <div class="content-block">-->
<!--                <div class="auth-block" v-if="!user">-->
<!--                    <router-link to="/login" tag="a">Авторизация</router-link>-->
<!--                </div>-->
<!--                <div class="user-block" v-else>-->
<!--                <span class="user__img">-->
<!--                    <img :src="'../images/default-foto.svg'" alt="default">-->
<!--                </span>-->
<!--                    <div class="user-title-block">-->
<!--                        <p class="user__title">{{user.name}}</p>-->
<!--                        <p class="user__email">{{'@' + user.email}}</p>-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div class="add-list" @click="addNewList">-->
<!--                    <img :src="'../images/plus-b.svg'" alt="plus-b">-->
<!--                    <p>Создать новый список</p>-->
<!--                </div>-->
<!--                <div class="lists-container">-->
<!--                    <ul class="lists">-->
<!--                        <li v-for="list in getLists" :key="list.id" class="list-item" @click="goToRoute(list)"-->
<!--                            :class="{active: $route.params.id === list.external_id}">{{list.title}}</li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="block-for-swipe"-->
<!--                 @click="toddleNavigation(false)"-->
<!--                 v-touch:swipe.right="swipeNavigation"-->
<!--                 v-touch-options="{swipeTolerance: 50, touchHoldTolerance: 200}"-->
<!--            ></div>-->

<!--        </aside>-->

<!--        <section class="cap" v-show="showNavigation" @click="toddleNavigation(false)"></section>-->

        <section class="content">
            <transition name="fade" mode="out-in">
                <router-view :key="$route.path" />
            </transition>
        </section>

    </div>
</template>

<script>
    import {mapGetters, mapMutations} from 'vuex'
    // import { v4 as uuidv4 } from 'uuid';
    export default {
        name: "MainLayout.vue",
        data: () => ({
            lists: [],
            user: {},
        }),

        async mounted() {
            this.user = await this.getUser()
        },
        computed: {
            ...mapGetters(['getLists']),
            // showNavigation() {
            //     return this.getNavigation()
            // }
        },
        methods: {
            ...mapGetters(['getUser']),
            ...mapMutations(['setCurrentHeader', 'setNewList']),
            // addNewList() {
            //     const list = {
            //         external_id: uuidv4(),
            //         title: 'Список продуктов'
            //     }
            //
            //     if(this.$auth.check()) {
            //         this.$store.dispatch('addNewList', list)
            //     }
            //     this.setNewList(list)
            // },

            // goToRoute(list) {
            //     if(list.external_id !== this.$route.params.id) {
            //         this.$router.push({ name: 'list', params: {id: list.external_id} })
            //     }
            //     this.setCurrentHeader(list.title)
            //     // this.toddleNavigation(false)
            // },
            // swipeNavigation (direction) {
            //    if(direction == 'left') {
            //        this.toddleNavigation(false)
            //    } else {
            //        this.toddleNavigation(true)
            //    }
            // },
        },
    }
</script>

<style scoped>
    .wrapper {
        display: flex;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
    }
    .main-navigation {
        min-width: 350px;
        transform: translateX(0);
        transition: .3s;
        position: absolute;
        left: 0;
        top: 0;
        z-index: 1000;
        height: 100%;
        /*background: #EEEEEE;*/
        /*box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);*/
        display: flex;
    }
    .content-block {
        width: 300px;
        background: #EEEEEE;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.25);
    }
    .block-for-swipe {
        position: absolute;
        width: 30px;
        left: 300px;
        height: calc(100vh - 85px);
        top: 50px;
        bottom: 35px;
    }
    .cap {
        background: rgba(0, 0, 0, 0);
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 500;
    }
    .content {
        width: 100%;
    }
    .auth-block {
        height: 100px;
        background-color: #000000;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .auth-block a {
        font-weight: normal;
        font-size: 14px;
        line-height: 16px;
        color: #FFFFFF;
    }
    .user-block {
        height: 100px;
        padding: 20px;
        background-color: #000000;
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }
    .user__img {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 30px;
        background-color: #D4D4D4;
        width: 60px;
        height: 60px;
        border-radius: 100%;
    }
    .user__title {
        font-weight: 500;
        font-size: 14px;
        line-height: 16px;
        color: #FFFFFF;
        margin-bottom: 8px;
    }
    .user__email {
        font-weight: normal;
        font-size: 12px;
        line-height: 14px;
        color: #FFFFFF;
        margin: 0;
    }
    .lists-container {
        height: calc(100vh - 100px);
        overflow-y: auto;
    }
    .lists {
        /*background-color: white;*/

    }
    .list-item,
    .add-list {
        width: 100%;
        height: 50px;
        padding: 0 18px;
        border-bottom: 1px solid #eeeeee;
        display: flex;
        align-items: center;
    }
    .list-item,
    .add-list p {
        font-size: 12px;
        line-height: 14px;
        color: #000000;
        margin: 0;
    }
    .list-item__main {
        background-color: #ffffff;
    }
    .add-list {
        background-color: white;
    }
    .add-list img {
        margin-right: 30px;
    }
    .mainNavigationToggle {
        transform: translateX(-300px);
        min-width: 0;
        /*width: 0;*/
        transition: .3s;
    }
    .active {
        background: #EEEEEE;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .1s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
