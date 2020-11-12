<template>
    <section>
        <ul class="filters" v-show="this.products.length" >
            <li>
                <a href="#/all" class="filter__link" :class="{selected: visibility == 'all'}" @click="visibility = 'all'">Все</a>
            </li>
            <li>
                <a href="#/active" class="filter__link" :class="{selected: visibility == 'active'}"
                   @click="visibility = 'active'">Активные</a>
            </li>
            <li>
                <a href="#/completed" class="filter__link" :class="{selected: visibility == 'completed'}"
                   @click="visibility = 'completed'">Завершенные</a>
            </li>
        </ul>

        <div class="product-list-container">
            <div class="product-list">
                <transition-group name="fade">
                    <div class="product-list__item" v-for="product of filteredProducts" :key="product.external_id"
                         @click="markDone(product)"
                         v-touch:swipe="swipeLeft(product.external_id)"
                         v-touch-options="{swipeTolerance: 20, touchHoldTolerance: 200}"
                    >
                        <div class="item__visible-part" :class="{swiped: product.external_id == currentProductId}">
                            <input class="product-list__input">
                            <img :src="'../images/check.svg'" v-if="product.marked" class="product-list__input-check" alt="check">
                            <div class="product-list__wrapper">
                                <span :style="{backgroundColor: product.product_group ? product.product_group.color : ''}"></span>
                                <p class="item__title" :class="{done: product.marked}">{{product.title}}</p>
                                <p class="item__unit">{{product.unit}}</p>
                            </div>
                        </div>
                        <div class="item__hide-part" :class="{swiped: product.external_id == currentProductId}">
                            <span class="edit"><img :src="'../images/edit.svg'" alt="edit"></span>
                            <span class="delete" @click="deleteProduct(product.external_id)"><img :src="'../images/delete.svg'" alt="delete"></span>
                        </div>
                    </div>
                </transition-group>
            </div>
        </div>
    </section>
</template>

<script>
    import {mapGetters, mapMutations} from 'vuex'
    import product from "../store/product";
    let filters = {
        all: products => products,
        active: products => products.filter(el => !el.marked),
        completed: products => products.filter(el => el.marked),
    };

    export default {
        name: "ProductList.vue",
        props: ['products'],
        data: () => ({
            visibility: 'active',
            productGroups: [],
            currentProductId: null
        }),

        computed: {
            filteredProducts: function () {
                return filters[this.visibility](this.sortingProducts(this.products));
            },
        },

        async mounted() {
            this.productGroups = this.getProductGroups()
        },

        methods: {
            ...mapMutations(['setMarkedProduct']),
            ...mapGetters(['getProductGroups']),
            swipeLeft (param) {
                return (direction, event) =>{
                    if(direction == 'left') {
                        this.currentProductId = param
                    } else {
                        this.currentProductId = null
                    }
                }
            },
            sortingProducts(products) {
                return products.sort((a, b) => a.product_group_id > b.product_group_id ? 1 : -1);
            },
            markDone(product) {
                const currentProduct = this.filteredProducts.filter(el => el.external_id === product.external_id)
                if(currentProduct[0]) {
                    currentProduct[0].marked = !currentProduct[0].marked
                    this.$store.dispatch('toggleMarkedProduct', product)
                    this.setMarkedProduct(product.external_id)
                }
            },
            deleteProduct(id) {
                this.$store.dispatch('deleteProduct', id)
            }
        }
    }
</script>

<style scoped>
    .product-list-container {
        position: relative;
        /*height: calc(100vh - 50px);*/
        /*overflow-y: auto;*/
        animation: opacity .3s;
        padding: 0 20px;
    }
    .product-list {
        overflow-x: hidden;
        overflow-y: auto;
        height: calc(100vh - 190px);
    }
    .product-list__item {
        display: flex;
        align-items: center;
        height: 40px;
        position: relative;
        margin-bottom: 20px;
    }
    .product-list__input {
        width: 22px;
        height: 22px;
        border: 3px solid #FFD64A;
        border-radius: 100%;
        margin: 0 15px 0 25px;
    }
    .product-list__input-check {
        position: absolute;
        left: 29px;
    }
    .item__visible-part {
        width: 100%;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        padding: 10px 0;
        cursor: pointer;
        transform: translateX(0);
        transition: .2s;
    }
    .product-list__wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #F5F7FA;
        border-radius: 15px;
        width: 100%;
    }
    .product-list__wrapper span {
        border-radius: 15px 0 0 15px;
        width: 15px;
        height: 40px;
        margin-right: 12px;
    }
    .item__title,
    .item__unit {
        font-size: 16px;
        line-height: 18px;
        color: #052137;
        margin: 0;
    }
    .item__unit {
        margin: 0 15px 0 auto;
    }
    .item__hide-part {
        width: 140px;
        transform: translateX(140px);
        transition: .2s;
        position: absolute;
        right: 0;
        display: flex;
    }
    .item__visible-part.swiped {
        transform: translateX(-140px);
        transition: .2s;
    }
    .item__hide-part.swiped {
        transform: translateX(0);
        transition: .2s;
    }
    .edit, .delete {
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
    .edit {
        margin: 0 20px 0 12px;
    }
    .done {
        text-decoration: line-through;
        color: #7D7D7D;
    }
    .filters {
        display: flex;
        justify-content: space-around;
        align-items: center;
        height: 30px;
        list-style-type: none;
        background-color: transparent;
        width: 100%;
        margin: 55px 0 25px 0;
        padding: 0 20px;
    }
    .filter__link {
        font-size: 13px;
        line-height: 15px;
        color: #7D7D7D;
        padding: 6px 8px;
        margin: 0 6px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #FFEBA7;
        border-radius: 20px;
        width: 105px;
    }
    .filter__link.selected {
        background-color: #FFD64A;
        text-decoration: none;
        color: #052137;
    }
    .active {
        background: #EEEEEE;
    }
    .fade-enter-active {
        transition: all .3s ease;
    }
    .fade-leave-active {
        transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .fade-enter, .fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateX(30px);
        opacity: 0;
    }
</style>
