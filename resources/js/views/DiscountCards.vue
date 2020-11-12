<template>
    <section class="discount-cards header-background" :style="{backgroundImage: 'url(' + image + ')'}">
<!--        <img :src="'../images/header1.png'" class="header__img" alt="plus">-->
        <Header :header="getCurrentHeader()"/>

        <div class="discount-card-container">

            <div class="non-auth">
                <p v-if="!$auth.check()">Чтобы добавить скидочные карты
                    <span class="non-auth__btn" @click="$router.push('/login')">Авторизуйтесь.</span>
                </p>
            </div>

            <ul class="discount-card__list"
                v-touch:swipe="swipeDown"
                v-touch-options="{swipeTolerance: 500, touchHoldTolerance: 500}"
            >
                <div v-for="(card, idx) of discountCards"
                    :key="card.id"
                    @click="moveToDiscountCard(card.id)"
                    :style="{background: card.brand
                    ? `url(../images/discount_card/${card.brand.key}.png)`
                    : card.color,
                     top: idx !== 0 ? idx * 70 + 'px' : 0}"
                    class="discount-card"
                >
                    <p class="discount-card__title" v-if="!card.brand">{{card.title}}</p>
                </div>
            </ul>
        </div>
    </section>
</template>

<script>
    import {mapGetters, mapMutations, mapActions} from 'vuex'
    import Header from "../components/Header";
    import discountCards from "../store/discountCards";
    export default {

        name: "DiscountCards.vue",
        data: function() {
            return {
                image: '../images/header1.png',
                discountCards: [],
            }
        },
        async mounted() {
            await this.setCurrentHeader('Карты')
            if(this.$auth.check()) {
                await this.fetchDiscountCards()
                this.discountCards = await this.getDiscountCards()
            }

        },
        methods: {
            ...mapGetters(['getCurrentHeader', 'getDiscountCards']),
            ...mapMutations(['setCurrentHeader']),
            ...mapActions(['fetchDiscountCards']),
            moveToDiscountCard(id) {
                this.$router.push('/discountCardData/' + id)
            },
            swipeDown(direction) {
                let cards = document.querySelectorAll('.discount-card')
                if(direction == 'bottom') {
                    cards.forEach(el => {
                        el.classList.add('showCards')
                    })
                } else if(direction == 'top') {
                    cards.forEach(el => {
                        el.classList.remove('showCards')
                    })
                }
            }
        },
        components: {Header}
    }
</script>

<style scoped>
    .discount-card-container {
        height: calc(100vh - 50px);
        overflow-y: auto;
        padding-top: 30px;
    }
    .non-auth {
        padding: 20px;
        text-align: center;
    }
    .non-auth__btn {
        font-size: 18px;
        font-weight: bold;
    }
    .discount-card__list {
        display: flex;
        flex-direction: column;
        align-items: center;
        list-style-type: none;
        position: relative;
    }
    .discount-card {
        width: 315px;
        height: 195px;
        background: #334422;
        border-radius: 10px;
        margin: 5px auto 5px auto;
        background-size: cover!important;
        position: absolute;
        box-shadow: 0 -1px 2px;
    }
    .discount-card__title {
        font-weight: normal;
        font-size: 19px;
        line-height: 22px;
        padding: 24px;
        color: #FFFFFF;
    }
    .showCards {
        position: static!important;
        transition: .3s;
    }
    /*.discount-card__item {*/
    /*    min-width: 300px;*/
    /*    min-height: 150px;*/
    /*    border-radius: 5px;*/
    /*    border: 1px solid black;*/
    /*    margin-bottom: 10px;*/
    /*}*/
</style>
