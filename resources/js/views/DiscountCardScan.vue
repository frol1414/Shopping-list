<template>
    <section>
        <img :src="'../images/header1.png'" class="header__img" alt="plus">
        <Header header="Сканировать карту"/>

        <div class="discount-card-scan">
                <StreamBarcodeReader
                    @decode="onDecode"
                    @loaded="onLoaded"
                ></StreamBarcodeReader>
            <div class="card-scan__btn">
                <button type="button" class="fill-title__btn" @click="moveToDiscountCardAdd">Ввести номер карты вручную</button>
            </div>
        </div>
    </section>
</template>

<script>
    import Header from "../components/Header";
    import {mapGetters} from "vuex";
    import StreamBarcodeReader from '../components/StreamBarcodeReader'

    export default {
        name: "stream-barcode-reader",
        data: function() {
          return {
              barcode: '',
          }
        },

        methods: {
            ...mapGetters(['getDiscountCards']),
            moveToDiscountCardAdd() {
                this.$router.push('/discountCardAdd')
            },
            onDecode (result) {
                if(result) {
                    this.barcode = result
                    this.$router.push({name: 'discountCardAdd', params: {barcode: this.barcode}})
                }
            },
            onLoaded() {}
        },

        components: {Header, StreamBarcodeReader}
    }
</script>

<style scoped>
    .discount-card-scan {
        display: flex;
        flex-direction: column;
        height: 100vh;
    }
    .card-scan__btn {
        position: fixed;
        bottom: 50px;
        left: calc(50% - 42vw);
        width: 100%;
    }
    .fill-title__btn {
        width: 84vw;
        height: 50px;
        background: #052137;
        border-radius: 30px;
        font-weight: 500;
        font-size: 18px;
        line-height: 21px;
        color: #ffffff;
        z-index: 10;
        outline: none;
        border: none;
    }
</style>
