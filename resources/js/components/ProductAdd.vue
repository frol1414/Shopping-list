<template>
    <form @submit.prevent="onSubmit" class="product-add-form" v-if="showForm">
        <div class="form-block">
            <input type="text" v-model="title" class="form-control form__input" placeholder="Товар : количество" ref="inputFocus"
                   :class="{invalid: !$v.title.maxLength}">
            <img :src="'../images/plus.svg'" alt="enter" class="form-block__img">
            <small class="helper-text invalid"
                   v-if="!$v.title.maxLength"
            >Слишком длинное название</small>

<!--            <button type="submit" class="form__btn"><img :src="'../images/enter.svg'" alt="enter"></button>-->
        </div>

        <ul class="groups">
            <li v-for="color in colors" :key="color.external_id" class="groups__item"
                :style="{backgroundColor: color.color}" @click="choiceGroup(color)"
                :class="{item_color: colorId === color.external_id}">

            </li>
        </ul>
    </form>
</template>

<script>
    import { mapGetters, mapMutations } from 'vuex'
    import { v4 as uuidv4 } from 'uuid';
    import { maxLength } from 'vuelidate/lib/validators'
    export default {
        name: "ProductAdd.vue",
        props: ['showForm'],
        data: () => ({
            title: '',
            colors: [],
            color: '',
            colorId: '',
        }),
        validations: {
            title: {maxLength: maxLength(35)}
        },
        mounted() {
            this.colors = this.getProductGroups()
        },

        updated() {
            if(this.$refs.inputFocus) {
                this.$refs.inputFocus.focus()
            }

            if(!this.showForm) {
                this.color = ''
                this.colorId = ''
            }
        },
        destroyed() {

        },
        methods: {
            ...mapGetters(['getProductGroups', 'getListsId']),
            ...mapMutations(['setProduct']),
            choiceGroup({color, external_id}) {
                this.color = color
                this.colorId = external_id
                this.$refs.inputFocus.focus()
            },
            onSubmit() {
                if (this.$v.$invalid) {
                    this.$v.$touch()
                    return
                }
                const product = {
                    external_id: uuidv4(),
                    title: this.title,
                    unit: '',
                    marked: false,
                    color: this.color,
                    list_id: this.$route.params.id,
                    product_group_id: this.colorId,
                    product_group: {color: this.color, external_id: this.colorId},
                }

                if(this.title.trim()) {
                    if(!this.$auth.check() && this.getListsId().includes(this.$route.params.id)) {
                        product.type = 'noAuth'
                    }
                    this.$store.dispatch('addProduct', product)
                    this.setProduct(product)
                }
                this.title = ''
                this.color = ''
                this.colorId = ''
            },
        }
    }
</script>

<style scoped>
    .product-add-form {
        position: fixed;
        height: 130px;
        bottom: 0;
        background-color: #FFFFFF;
        width: 100%;
    }
    .form-block {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        margin-top: 20px;
    }
    .form__input {
        width: 100%;
        height: 40px;
        border-radius: 10px;
        margin: 0 30px;
        padding-left: 50px;
    }
    .form__input::placeholder {
        font-size: 15px;
        line-height: 17px;
        color: #CACACA;

    }
    .form-block__img {
        position: absolute;
        left: 50px;
    }
    .form__btn {
        padding: 0;
        border: none;
        font: inherit;
        color: inherit;
        background-color: transparent;
        cursor: pointer;
    }
    .form__btn:focus {
        outline: none;
    }
    .groups {
        display: flex;
        align-items: center;
        justify-content: center;
        list-style-type: none;
        margin: 15px 0 30px 0;
    }
    .groups__item {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        margin: 0 7px;
        border-radius: 20px;
    }
    .item_color {
        width: 60px;
    }
</style>
