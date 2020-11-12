<template>
    <div class="discount-card-data header-background" :style="{backgroundImage: 'url(' + image + ')'}">
        <Header :header="discountCard.title"/>
        <div
             :style="{background: this.discountCard.brand
                ? `url(../images/discount_card/${this.discountCard.brand.key}.png)`
                : this.discountCard.color}"
             class="discount-card"
        >
            <p class="discount-card__title" v-if="!this.discountCard.brand">{{discountCard.title}}</p>
        </div>
        <div class="barcode-container">
            <svg id="barcode" class="barcode"></svg>
        </div>

        <p class="card-number__title">Номер карты:</p>
        <p class="card-number__num">{{discountCard.barcode}}</p>
        <p class="card-status__title">Статус карты:</p>
        <p class="card-number__desc">Начисление баллов</p>

    </div>
</template>

<script>
    import Header from "../components/Header";
    import {mapGetters} from "vuex";
    import JsBarcode from 'jsbarcode'

    export default {
        name: "DiscountCardData.vue",
        data: function() {
            return {
                image: '../images/header1.png',
                discountCard: {}
            }
        },
        async mounted() {
            this.discountCard = await this.getDiscountCards().find(el => el.id == this.$route.params.id)
            await JsBarcode("#barcode", this.discountCard.barcode, {
                // format: "ean13",
                lineColor: "#000",
                width:4,
                height:100,
                displayValue: false,
                background: "transparent"
            });
        },
        methods: {
            ...mapGetters([ 'getDiscountCards']),
        },
        components: {Header},
    }
</script>

<style scoped>
    .discount-card {
        width: 84vw;
        height: 180px;
        background: #334422;
        border-radius: 20px;
        margin: 60px auto 30px auto;
        background-size: cover!important;
    }
    .discount-card__title {
        font-weight: normal;
        font-size: 19px;
        line-height: 22px;
        padding: 24px;
        color: #FFFFFF;
    }
    .barcode-container {
        display: flex;
        justify-content: center;
        margin-bottom: 25px;
    }
    .barcode {
        width: 100%;
        height: 65px;
    }
    .card-number__title,
    .card-status__title {
        font-weight: 500;
        font-size: 20px;
        line-height: 23px;
        color: #052137;
        margin: 0 0 20px 30px;
    }
    .card-number__num,
    .card-number__desc {
        font-weight: normal;
        font-size: 16px;
        line-height: 18px;
        color: #7D7D7D;
        margin-left: 50px;
    }
    .card-number__num {
        margin-bottom: 35px;
    }
</style>
