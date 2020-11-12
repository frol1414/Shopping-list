import { v4 as uuidv4 } from 'uuid';
import http from '../http'
import {newProducts} from "../app";
export default {
    state: {
        products: [],
    },

    getters: {
        getProductsTypeNoAuth: state => state.products.filter(el => el.type === 'noAuth'),

        getProductsByListId: state => id => {
            return state.products.filter(el => el.list_id === id)
        }
    },

    mutations: {
        setFirstProducts(state, value) {
            value.map(el => state.products.push(el))
        },
        setProduct(state, product) {
            state.products.unshift(product);
        },
        setProducts(state, value) {
            state.products = value;
        },
        deleteProduct(state, id) {
            state.products = state.products.filter(el => el.external_id !== id)
        },
        setMarkedProduct(state, id) {
            const product = state.products.find(el => el.external_id === id)
        },
        setClearMarkedProductFromList(state, id) {
            let productsToDelete = this.state.product.products.filter(el => el.marked && el.list_id === id)
            productsToDelete.map(p => {
                let index = state.products.indexOf(p);
                if (index > -1) {
                    state.products.splice(index, 1);
                }
            })

        },
         setLoadedProducts(state, value) {
            if(value.length) {
                let currentListProducts = state.products.filter(el => el.list_id == value[0].list_id)

                if(currentListProducts.length !== value.length) {
                    newProducts()
                }

                let listId = value[0].list_id
                let otherListProducts = state.products.filter(el => el.list_id !== listId)
                state.products.splice(0, state.products.length)
                state.products = [...otherListProducts, ...value]
            }
        }
    },

    actions: {
        async getProductByList({commit}, id) {
            const res = await http.get('/api/lists/' + id)
            const products = await res.data.data.products
            await commit('setLoadedProducts', products)
            return res.data.data.discount_card
            // .catch(error => console.log(error));
        },
        addProduct(context, data) {
            http.post('/api/product', data)
                .catch(error => console.log(error));
        },
        deleteProduct({commit}, id) {
            http.delete('/api/product/' + id)
            commit('deleteProduct', id)
        },
        toggleMarkedProduct(context, {external_id, marked}) {
            http.put('/api/product/' + external_id, {marked: marked})
                // .then(res => console.log(res))
                .catch(error => console.log(error));
        },
        clearMarkedProductFromList({commit}, id) {
            let productsToDelete = this.state.product.products.filter(el => el.marked && el.list_id === id)
            http.delete('/api/product/delete', {data: productsToDelete})
                .then(commit('setClearMarkedProductFromList'))
                .catch(error => console.log(error));
        }
    }
}
