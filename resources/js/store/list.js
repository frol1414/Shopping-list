import Vue from 'vue'
import http from '../http'


import { v4 as uuidv4 } from 'uuid';

export default {
    state: {
        lists: [],
        currentList: ''
    },

    getters: {
        getList: state => state.lists[0].external_id,
        getLists: state => state.lists,
        getListsId: state => state.lists.map(el => el.external_id),
        getCurrentList: state => state.currentList,
        getCurrentListObj: state => state.lists.find(el => el.external_id === state.currentList)
    },

    mutations: {
        setFirstList(state) {
            state.lists.push({external_id: uuidv4(), title: 'Список покупок'});
        },
        setLists(state, value) {
            state.lists = value;
        },
        setNewList(state, list) {
            state.lists.push(list);
        },
        setCurrentList(state, id) {
            state.currentList = id
        },
        setFetchingLists(state, lists) {
            state.lists = lists
        },
        // updateList(state, list) {
        //     state.lists.push(list);
        // },
        setRemoveList(state, id) {
            state.lists = state.lists.filter(el => el.external_id !== id);
        },
        clearList(state, id) {
        },
    },

    actions: {
        addNewList(context, value) {
            http.post('/api/lists', value)
                .catch(error => console.log(error));
        },
        fetchLists({commit}) {
            http.get('/api/lists')
                .then(response => commit('setFetchingLists', response.data.data))
        },
        updateList({commit}, data) {
            commit('updateList', data)
        },
        removeList({commit}, id) {
            http.delete('/api/lists/' + id)
                .catch(error => console.log(error));
        },
    }
}
