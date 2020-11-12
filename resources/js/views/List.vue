<template>
    <div class="list" :style="{backgroundImage: 'url(' + image + ')'}">
        <Header :header="getCurrentHeader()"/>
        <Loader v-show="loader"/>
        <ProductList v-show="!loader" :products="getProductsByListId(listId)"/>

        <section class="cap" v-show="ShowAddProductForm" @click="closeForm"></section>
        <section class="cap-settings" v-show="getSettings" @click="toggleSettings(false)"></section>

        <ProductAdd :showForm="ShowAddProductForm"/>

        <div class="cards" v-if="!ShowAddProductForm" @click="goToCards"><img :src="'../images/go-to-cards.svg'" alt="cards"></div>

        <div class="show-form__btn" :class="{display: ShowAddProductForm}" @click="showAddForm"><img :src="'../images/add-product.svg'" alt="plus"></div>
    </div>
</template>

<script>

    import {mapMutations, mapGetters} from 'vuex'
    import ProductList from "../components/ProductList";
    import ProductAdd from "../components/ProductAdd";
    import Header from "../components/Header";
    import Loader from "../components/Loader";

    export default {
        name: "List.vue",
        props: ['header'],
        data: function () {
            return {
                image: '../images/header1.png',
                showForm: false,
                listId: this.$route.params.id,
                loader: false
            }
        },
        computed: {
            ...mapGetters(['getSettings', 'getProductsByListId']),
            ShowAddProductForm() {
                return this.getAddProductForm()
            }
        },
        async mounted() {
            this.toggleAddProductForm(false)

            if(!this.$auth.check()) {
                this.setCurrentUserFalse()
            }
            this.loader = true
            this.setCurrentList(this.$route.params.id)
            let lists = this.getLists().filter(el => el.external_id === this.$route.params.id)

            if(!this.$auth.check() && lists.length) {
                this.loader = false

            } else {
                await this.$store.dispatch('getProductByList', this.listId)
                this.loader = false

                this.t = setInterval(() => {
                    this.$store.dispatch('getProductByList', this.listId)
                }, 10000)
            }

            this.setCurrentHeader(lists[0].title)
        },
        destroyed() {
            clearInterval(this.t)
        },
        methods: {
            ...mapMutations(['toggleAddProductForm', 'toggleSettings',
                'setCurrentList', 'setCurrentUserFalse', 'setCurrentHeader']),
            ...mapGetters(['getAddProductForm', 'getCurrentHeader', 'getList', 'getLists']),

            showAddForm() {
                this.toggleAddProductForm(true)
            },
            closeForm() {
                this.toggleAddProductForm(false)
            },
            goToCards() {
                this.$router.push('/discountCards')
            }
        },
        components: {Loader, ProductList, ProductAdd, Header}
    }
</script>

<style scoped>
    .list {
        height: 100vh;
        position: relative;
        background-size: contain;
        background-repeat: no-repeat;
    }
    .show-form__btn {
        position: fixed;
        right: 30px;
        bottom: 40px;
    }
    .cards {
        position: fixed;
        right: 40px;
        bottom: 120px;
    }
    .display {
        display: none;
    }
    .cap,
    .cap-settings {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
    }
    .cap {
        background: rgba(107, 107, 107, 0.3);
        left: 0;
    }
    .cap-settings {
        background: rgba(0, 0, 0, 0);
        left: 50px;
    }
</style>
