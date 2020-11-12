import http from "../http";

export default {
    state: {
        currentUser: '',
        users: [],
    },

    getters: {
        getUser: state => state.currentUser,
    },

    mutations: {
        setCurrentUser(state, value) {
            state.currentUser = value
        },
        setCurrentUserFalse(state) {
            state.currentUser = ''
        },
        deleteUser(state, id) {
            state.users = state.users.filter(el => el.id !== id);
        },
    },
}
