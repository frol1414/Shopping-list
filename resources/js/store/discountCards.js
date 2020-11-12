import { v4 as uuidv4 } from 'uuid';
import http from '../http'
import {newProducts} from "../app";
export default {
    state: {
        discountCards: [],
        discountCardsBrands: [],
        attachedCardsToList: []
    },

    getters: {
        getDiscountCards: state => state.discountCards,
        getDiscountCardsBrands: state => state.discountCardsBrands,
        getAttachedCardsToList: (state, getters) => state.attachedCardsToList.filter(el => el.list_id == getters.getCurrentList),
        // getAttachedCardsToList: (state, getters) => console.log(state),
    },

    mutations: {
        setDiscountCards(state, value) {
            state.discountCards = value
        },
        setDiscountCardsBrands(state, value) {
            state.discountCardsBrands = value
        },
        setAddedDiscountCards(state, value) {
            state.discountCards.push(value)
        },
        setDiscountCardsToList(state, value) {
            state.attachedCardsToList.push(value)
        },
        deleteDiscountCardsToList(state, id) {
            state.attachedCardsToList = state.attachedCardsToList.filter(el => el.id != id)
        },
    },

    actions: {
        async fetchDiscountCards({commit}) {
            try {
                await http.get('/api/discount-card')
                    .then(res => commit('setDiscountCards',res.data.data))
                    .catch(error => console.log(error));
            } catch (e) {}
        },
        async fetchDiscountCardsBrands({commit}) {
            try {
                await http.get('/api/discount-card/brands')
                    .then(res => commit('setDiscountCardsBrands', res.data.data))
                    .catch(error => console.log(error));
            } catch (e) {}
        },
        async addDiscountCards({commit}, data) {
            try {
                await http.post('/api/discount-card', data)
                    .then(res => commit('setAddedDiscountCards', res.data.data))
                    .catch(error => console.log(error));
                return true
            } catch (e) {
                return false
            }
        },
        async attachDiscountCardsToList({commit}, payload) {
            let data = {
                ...payload,
                list_id: this.state.list.currentList,
            }
            try {
                await http.post('/api/lists/discount-card', {discount_card_id: data.id, list_id: data.list_id})
                    .then(res => commit('setDiscountCardsToList', data))
            } catch (e) {}
        },
        async detachDiscountCardsToList({commit}, payload) {
            let data = {
                list_id: this.state.list.currentList,
                discount_card_id: payload
            }
            try {
                await http.delete('/api/lists/discount-card', {data: data})
                    .then(res => commit('deleteDiscountCardsToList', payload))
            } catch (e) {}
        },

    }
}
