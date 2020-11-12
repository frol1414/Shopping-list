<template>
    <nav class="header">
        <div class="nav-wrapper">

            <ul id="nav-mobile" class="header-navbar">
                <li class="comeback" v-if="listRoute"><a href="#" @click.prevent="$router.push('/')"><img :src="'../images/comeback.svg'" alt="comeback"></a></li>
                <li class="user" v-else-if="listsRoute"><a href="#" @click.prevent="auth"><img :src="'../images/user.svg'" alt="menu"></a></li>
                <li class="comeback" v-else><a href="#" @click.prevent="comeBack"><img :src="'../images/comeback.svg'" alt="comeback"></a></li>

                <li class="plus" v-show="listRoute"><a href="#" @click.prevent="showdropdown = !showdropdown"><img :src="'../images/dots.svg'" alt="dots"></a></li>
<!--                <li class="collaboration" v-show="listRoute"><a href="#" @click.prevent="goToCollaboration" class="user-group__btn"><img :src="'../images/share.svg'" alt="share"></a></li>-->
<!--                <li class="cards" v-show="listRoute"><a class="settings__btn" @click.prevent="goToCards"><img :src="'../images/cards.svg'" alt="cards"></a></li>-->
                <li class="plus" v-show="listsRoute"><a class="settings__btn" @click.prevent="addNewList"><img :src="'../images/plus-b.svg'" alt="plus"></a></li>
                <li class="plus" v-show="cardsRoute"><a class="settings__btn" @click.prevent="addNewCard"><img :src="'../images/plus-b.svg'" alt="plus"></a></li>
            </ul>

            <div class="dropdown" v-if="showdropdown">
                <span class="dropdown__item border-bottom"><img :src="'../images/edit.svg'" alt="dots">Переименовать</span>
                <span class="dropdown__item border-bottom" @click="deleteList"><img :src="'../images/delete.svg'" alt="dots">Удалить</span>
                <span class="dropdown__item border-bottom" @click="goToCollaboration"><img :src="'../images/share.svg'" alt="dots">Поделиться</span>
                <span class="dropdown__item" @click="clearBought"><img :src="'../images/clear.svg'" alt="dots">Очистить</span>
            </div>

            <span class="header__title">{{header}}</span>

        </div>
    </nav>
</template>

<script>
    import {mapGetters, mapMutations, mapActions} from 'vuex'
    import {v4 as uuidv4} from "uuid";
    export default {

        name: "Header.vue",
        data() {
            return {
                showdropdown: false,
            }
        },
        props: ['header'],
        computed: {
            ...mapGetters(['getComeBackBtn', 'getSettings', 'getLists']),
            listRoute() {
                return this.$route.path == `/list/${this.$route.params.id}`
            },
            listsRoute() {
                return this.$route.path == `/`
            },
            userRoute() {
                return this.$route.path == `/` && this.$auth.check()
            },
            cardsRoute() {
                return this.$route.path == `/discountCards`
            }
        },

        methods: {
            ...mapMutations(['toggleAddProductForm', 'toggleSettings',
            'setCurrentHeader', 'setClearMarkedProductFromList', 'setNewList', 'setRemoveList']),
            ...mapActions(['removeList', 'updateList', 'clearMarkedProductFromList']),

            goToCards() {
                this.$router.push('/discountCards')
            },
            comeBack() {
                this.$router.back()
            },
            goToCollaboration() {
                this.$router.push({name: 'collaboration', params: {listId: this.$route.params.id}})
            },
            auth() {
                if(this.$auth.check()) {
                    this.$router.push('/profile')
                }
                this.$router.push('/login')
            },
            addNewList() {
                const list = {
                    external_id: uuidv4(),
                    title: 'Список продуктов'
                }

                if(this.$auth.check()) {
                    this.$store.dispatch('addNewList', list)
                }
                this.setNewList(list)
            },
            addNewCard() {
                this.$router.push('/discountCardScan')
            },
            // renameList() {
            //     this.updateList(this.$route.params.id)
            //     this.$router.back()
            // },
            deleteList() {
                if(this.$auth.check()) {
                    this.$store.dispatch('removeList', this.$route.params.id)
                }
                this.setRemoveList(this.$route.params.id)
                this.$router.push('/')
            },
            clearBought() {
                if(this.$auth.check()) {
                    this.clearMarkedProductFromList(this.$route.params.id)
                } else {
                    this.setClearMarkedProductFromList(this.$route.params.id)
                }
            }
        },
        mounted() {
            // this.toddleNavigation(false)
            this.toggleSettings(false)
        },
    }
</script>

<style scoped>
    nav {
        background-color: white;
        box-shadow: none;
        position: relative;
    }
    .nav-wrapper {
        width: 100%;
    }
    .header {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80px;
        width: 100%;
        background: transparent;
        padding: 20px 20px 0 20px;
    }
    .header-navbar {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        list-style-type: none;
        margin-bottom: 0;
        width: 100%;
        height: 100%;
    }
    .header__title {
        display: flex;
        align-items: center;
        font-weight: 500;
        font-size: 30px;
        line-height: 34px;
        color: #052137;
        padding: 7px 0 0 10px;
    }
    .user,
    .settings__btn {
        cursor: pointer;
    }
    .plus {
        margin-left: auto;
    }
    .dropdown__item a {
        font-size: 12px;
        line-height: 14px;
        margin-bottom: 12px;
        font-weight: normal;
        color: black;
    }
    .dropdown {
        width: 175px;
        height: 160px;
        position: absolute;
        top: 47px;
        right: 25px;
        background: #FFFFFF;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 35px rgba(0, 0, 0, 0.25);
        z-index: 1;
    }
    .dropdown__item {
        padding: 9px 15px;
        display: flex;
        align-items: center;
        font-size: 15px;
        line-height: 17px;
        color: #052137;
    }
    .dropdown__item img {
        margin-right: 15px;
    }
    .border-bottom {
        border-bottom: 1px solid #E4E4E4;
    }
</style>
