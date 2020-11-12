<template>
    <section>
        <img :src="'../images/header3.png'" class="header__img" alt="plus">
        <Header :header="getCurrentHeader()"/>
        <form @submit.prevent="addDiscountCard" method="post" autocomplete="off" class="discount-card-add__form">
            <div class="form-group card__title">
                <input type="text" id="title" class="form-control" placeholder="Магазин" @input="searchBrand" ref="brandSearch" required
                       :class="{invalid: !$v.title.maxLength}">
                <small class="helper-text invalid" v-if="!$v.title.maxLength">Слишком длинное название</small>

                <ul v-if="brandResults.length > 0 && $refs.brandSearch.value" class="user-searched-list">
                    <li v-for="result in brandResults" :key="result.id" class="user-searched__item"
                        @click="selectBrand(result.id, result.title)"
                    >
                        <span class="user__img">
                            <img :src="'../images/discount_card/' + result.key + '.png'" alt="default">
                        </span>

                        <div class="user-title-block">
                            <p class="user__title">{{result.title}}</p>
                        </div>
                    </li>
                </ul>

            </div>
            <div class="form-group">
                <input type="text" id="barcode" class="form-control" placeholder="Номер карты" v-model="barcode" required
                       :class="{invalid: !$v.barcode.maxLength}">
                <small class="helper-text invalid" v-if="!$v.barcode.maxLength">Слишком много цифр</small>
            </div>

                <button type="submit" class="discount-card-add__btn">Добавить карту</button>
        </form>
    </section>
</template>

<script>
    import {mapGetters, mapActions, mapMutations} from "vuex";
    import Header from "../components/Header";
    import {maxLength} from "vuelidate/lib/validators";

    export default {
        name: "DiscountCardAdd.vue",
        data: function () {
            return {
                title: '',
                barcode: '',
                brands: [],
                brandResults: []
            }
        },
        validations: {
            title: {maxLength: maxLength(30)},
            barcode: {maxLength: maxLength(30)}
        },

        async mounted() {
            await this.fetchDiscountCardsBrands()
            this.brands = await this.getDiscountCardsBrands()
            if(this.$route.params.barcode) {
                this.barcode = this.$route.params.barcode
            }
            this.setCurrentHeader('Добавить карту')
        },
        methods: {
            ...mapGetters(['getDiscountCards', 'getDiscountCardsBrands', 'getCurrentHeader']),
            ...mapActions(['fetchDiscountCardsBrands']),
            ...mapMutations(['setCurrentHeader']),
            searchBrand(e) {
                if(!!e.target.value) {
                    this.brandResults = this.brands.filter(item => item.title.toLowerCase().indexOf(e.target.value.toLocaleLowerCase()) !== -1)
                } else {
                    this.brandResults = []
                }

            },
            addDiscountCard() {
                if (this.$v.$invalid) {
                    this.$v.$touch()
                    return
                }
                const colors = ['#F70909', '#41F489', '#6633F9', '#FF3AC8', '#FCF554', '#0088CC', ]
                if(!this.$refs.brandSearch.value || !this.barcode) {
                    return
                }
                let discountCard = {
                    brand_id: this.brandId,
                    title: this.$refs.brandSearch.value,
                    barcode: this.barcode,
                    color: colors[Math.floor(Math.random() * colors.length)]
                }
                const addDiscountCards = this.$store.dispatch('addDiscountCards', discountCard)
                addDiscountCards.then(r => r ? this.$router.push('/discountCards') : '')
            },
            selectBrand(id, title) {
                this.brandId = id
                this.$refs.brandSearch.value = title
                this.brandResults = 0;
            }
        },
        components: {Header}
    }
</script>

<style scoped>
    .discount-card-add__form {
        margin: 25px auto 0 auto;
        padding: 0 18px;
    }
    .form-control {
        height: 40px;
        padding: 13px 18px;
        border-radius: 10px;
        width: 85vw;
    }
    .form-control::placeholder {
        font-size: 15px;
        line-height: 17px;
        color: #CACACA;
    }
    .card__title {
        margin-bottom: 20px;
    }
    .user-searched-list {
        width: calc(100% - 36px);
        border: 1px solid #A1A1A1;
        box-sizing: border-box;
        border-radius: 5px;
        /*height: 250px;*/
        overflow-y: auto;
        list-style-type: none;
        margin-top: 5px;
        position: absolute;
        background-color: white;
    }

    .user-searched__item {
        padding: 10px;
        display: flex;
        align-items: center;
        border-bottom: 1px solid #eeeeee;
    }

    .user__item {
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        border-bottom: 1px solid #eeeeee;
        height: 50px;
    }

    .user__img {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        width: 80px;
        height: 40px;
        background-color: #D4D4D4;
    }

    .user__img img {
        width: 80px;
        height: 40px;
    }

    .user__title {
        font-size: 12px;
        line-height: 14px;
        color: #000000;
        margin-bottom: 3px;
    }
    .discount-card-add__btn {
        display: block;
        width: 250px;
        height: 50px;
        background: #052137;
        border-radius: 30px;
        color: #fff;
        border: none;
        margin: 35px auto 0 auto;
    }
</style>
