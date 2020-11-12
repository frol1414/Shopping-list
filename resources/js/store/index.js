import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import product from "./product";
import list from "./list";
import user from "./user"
import productGroup from "./productGroup";
import discountCards from "./discountCards";

Vue.use(Vuex);

export default new Vuex.Store({
    namespaced: true,
    state: {
        // showComeBackBtn: null,
        showAddProductForm: false,
        // showNavigation: false,
        showSettings: false,
        currentHeader: 'Список покупок',
    },
    getters: {
        // getComeBackBtn: state => state.showComeBackBtn,
        getAddProductForm: state => state.showAddProductForm,
        // getNavigation: state => state.showNavigation,
        getCurrentHeader: state => state.currentHeader,
        getSettings: state => state.showSettings,
        getUsers: state => {
            let lists = state.list.lists.filter(el => el.external_id === state.list.currentList)[0]
            return lists['added_users'] ? lists['added_users'] : []
        }


        // getUsers: state => state.list.currentList
    },
    mutations: {
        // toggleComeBackBtn(state, value) {
        //     state.showComeBackBtn = value
        // },
        toggleAddProductForm(state, value) {
            state.showAddProductForm = value
        },
        // toddleNavigation(state, value) {
        //     state.showNavigation = value
        // },
        setCurrentHeader(state, value) {
            state.currentHeader = value
        },
        toggleSettings(state, value) {
            state.showSettings = value
        },
    },
    actions: {

    },
    modules: {
        list, product, user, productGroup, discountCards
    },
    plugins: [createPersistedState()]
});
