<template>
    <section class="lists" :style="{backgroundImage: 'url(' + image + ')'}">
        <div class="logo" :class="{'visible-logo': !logo}">
            <img :src="'../images/logo.svg'" alt="logo">
        </div>
        <template>
<!--            <img :src="'../images/header2.png'" class="header__img" alt="plus">-->
            <Header :header="getCurrentHeader()"/>

            <div class="form-group">
                <img :src="'../images/search.svg'" class="form-group__img" alt="user">
                <input type="text" class="form-group__input" placeholder="Поиск" v-model="search">
            </div>

            <div class="lists-container">
                <ul class="lists">
                    <li v-for="list in lists" :key="list.id" class="list-item" @click="goToRoute(list.external_id)"
                        :class="{active: $route.params.id === list.external_id}">
                        <p class="list-item__title">{{list.title}}</p>
                    </li>

                </ul>
            </div>
        </template>
    </section>
</template>

<script>
    import Header from "../components/Header"
    import {mapGetters, mapMutations} from "vuex"
    import {v4 as uuidv4} from "uuid";

    export default {
        name: "Lists.vue",
        data() {
            return {
                image: '../images/header2.png',
                search: '',
                logo: true,
            }
        },
        async mounted() {
            if(!this.$auth.check()) {
                this.setCurrentUserFalse()
            }
            if(!this.getLists().length) {

                await this.setFirstList()
                const listId = await this.getList()
                const products = [
                    {external_id: uuidv4(), title: 'Булочки с повидлом', 'list_id': listId, product_group_id: 'cb2eaa85-9232-4c25-b3ba-9472317ce28a', unit: '4 шт.', marked: false, product_group: {color: '#61F2CF'}, type: 'noAuth'},
                    {external_id: uuidv4(), title: 'Молоко', 'list_id': listId, product_group_id: '692b46bd-bdbc-4841-ae50-c8e85ea36f64', unit: '2 л.', marked: false, product_group: {color: '#AFEF98'}, type: 'noAuth'},
                    {external_id: uuidv4(), title: 'Хлеб Бородинский', 'list_id': listId, product_group_id: 'cb2eaa85-9232-4c25-b3ba-9472317ce28a', unit: '1 шт.', marked: true, product_group: {color: '#61F2CF'}, type: 'noAuth'},
                    {external_id: uuidv4(), title: 'Огурцы', 'list_id': listId, product_group_id: '5133b9e0-f27b-4b07-964c-00d2babaafb7', unit: '500 гр.', marked: false, product_group: {color: '#EC89E8'}, type: 'noAuth'},
                    {external_id: uuidv4(), title: 'Кефир', 'list_id': listId, product_group_id: '692b46bd-bdbc-4841-ae50-c8e85ea36f64', unit: '1 л.', marked: true, product_group: {color: '#AFEF98'}, type: 'noAuth'},
                    {external_id: uuidv4(), title: 'Шоколад "Аленка"', 'list_id': listId, product_group_id: '', unit: '1 шт.', marked: false, product_group: {color: ''}, type: 'noAuth'}
                ]

                await this.setFirstProducts(products)
            } else {
                let fetchingData = await this.$auth.user()
                if(fetchingData) {
                    await this.setCurrentUser(fetchingData.user)
                    await this.setLists(fetchingData.list)
                }
            }

            setTimeout(() => {
                this.logo = false
            }, 500);

            this.setCurrentHeader('Списки')
        },
        computed: {
            lists() {
                return this.getLists()
            }
        },
        methods: {
            ...mapGetters(['getCurrentHeader', 'getLists', 'getList']),
            ...mapMutations(['setCurrentHeader', 'setNewList', 'setCurrentUserFalse', 'setCurrentUser', 'setLists',
                'setFirstProducts', 'setFirstList']),

            goToRoute(id) {
                this.$router.push({ name: 'list', params: {id} })

            },
        },
        components: {Header}
    }
</script>

<style scoped>
    .lists {
        position: relative;
        background-repeat: no-repeat;
        background-size: contain;
    }
    .logo {
        position: absolute;
        z-index: 3;
        top: 0;
        left: 0;
        right: 0;
        height: 100vh;
        background: var(--yellow-color);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 1;
    }
    .logo img {
        width: 200px;
    }
    .visible-logo {
        opacity: 0;
        transition: .3s;
        z-index: -5;
    }
    .form-group {
        margin: 10px auto 60px auto;
    }
    .form-group__input {
        height: 40px;
    }
    .lists-container {
        height: 100vh;
        overflow-y: auto;
        width: 92.5%;
        margin-left: 30px;
    }
    .list-item {
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        background: rgba(255, 215, 80, 0.5);
        border-radius: 18px 0 0 18px;
        margin-bottom: 15px;
    }
    .list-item__title {
        font-size: 16px;
        line-height: 18px;
        color: #052137;
    }
</style>
