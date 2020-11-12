<template>
<div class="user-list">
    <form class="user-list-form">

        <div class="search-user">
            <img :src="'../images/find-user.svg'" class="search-user__img" alt="plus">
            <input placeholder="Введите имя, почту" @input="searchUser" ref="userSearch" class="search-user__input" :disabled="!$auth.check()">
        </div>

        <p class="auth-desc" v-if="!$auth.check()">
            Прикрепление пользователей к списку, а также поделиться списком доступно только авторизованным пользователям
        </p>
        <p v-if="searchError">Пользователь не найден</p>
        <ul v-if="results.length > 0 && $refs.userSearch.value" class="user-searched-list">
            <li v-for="result in results" :key="result.id" class="user-searched__item"
                @click="selectUser(result.id)">
                <span class="user__img">
                    <img :src="'../images/default-foto.svg'" alt="default">
                </span>

            <div class="user-title-block">
                <p class="user__title">{{result.name}}</p>
                <p class="user__email">{{'@' + result.email}}</p>
            </div>
            </li>
        </ul>
    </form>
    <section class="cap" v-if="results.length > 0" @click="closeSearchedList"></section>

    <ul>
        <li v-for="user in users" :key="user.id" class="user__item">
            <div class="user-title-block">
                <p class="user__title">{{user.name}}</p>
                <p class="user__email">{{'@' + user.email}}</p>
            </div>
            <span class="user__btn" @click="deleteUser(user.id)"><img :src="'../images/close.svg'" alt="close"></span>
        </li>
    </ul>


</div>
</template>

<script>
    //todo: Lazy on input
    import {mapGetters, mapActions} from 'vuex'
    import http from '../http'
    export default {
        name: "UsersList.vue",
        data() {
            return {
                // keywords: null,
                results: [],
                searchError: false,
            }
        },
        computed: {
            users() {
                return this.getUsers()
            }
        },
        methods: {
            ...mapGetters(['getUsers', 'getCurrentList', 'getLists']),
            ...mapActions(['fetchLists']),
            searchUser(e) {
                console.log(this)
                if(!!e.target.value) {
                    // this.keywords = e.target.value
                    this.fetch();
                } else {
                    this.results = 0
                    this.searchError = false
                }
            },
            deleteUser(id) {
                http.delete('api/user/collaboration', {data: {
                        list_id: this.getCurrentList(),
                        user_id: id
                    }})
                    .then(response => {
                        this.fetchLists()
                    })
            },
            fetch() {
                http.get('api/user/search', { params: {
                    query: this.$refs.userSearch.value,
                    // query: this.keywords,
                    list_id: this.getCurrentList(),
                    } })
                    .then(response => {
                        this.searchError = false
                        this.results = response.data.data
                    })
                    .catch(res => {
                        this.searchError = true
                        this.results = 0
                    });
            },
            selectUser(userId) {
                // this.keywords = ''
                this.results = 0
                this.$refs.userSearch.value = ''
                http.put('api/user/collaboration', {
                    list_id: this.getCurrentList(),
                    user_id: userId
                })
                .then(response => {
                    this.fetchLists()
                })
                .catch(error => console.log(error));

            },
            closeSearchedList() {
                // console.log(111)
                this.results = 0
            }
        }
    }
</script>

<style scoped>
    .cap {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0);
        z-index: 100;
    }
    .search-user {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 3px;
        background: transparent;
        position: relative;
        width: 85vw;
        margin: 0 auto 100px auto;
    }
    .search-user__img {
        position: absolute;
        left: 13px;
    }
    .search-user__input {
        width: 100%;
        height: 40px;
        border-radius: 10px;
        background: #ffffff;
        border: none;
        padding-left: 40px;
    }
    .search-user__input::placeholder {
        font-size: 15px;
        line-height: 40px;
        color: #CACACA;
    }
    .user-list-form {
        position: relative;
    }
    .user-searched-list {
        width: 85vw;
        border: 1px solid #A1A1A1;
        box-sizing: border-box;
        border-radius: 5px;
        height: 250px;
        overflow-y: auto;
        list-style-type: none;
        margin-top: 5px;
        position: absolute;
        top: 40px;
        left: calc(50% - 160px);
        background-color: white;
        z-index: 200;
    }
    .user-searched__item {
        padding: 10px;
        display: flex;
        align-items: center;
        border-bottom: 1px solid #eeeeee;
    }
    .user__item {
        width: 85vw;
        margin: 0 auto 10px auto;
        padding: 9px 20px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        border-bottom: 1px solid #eeeeee;
        height: 55px;
        background: #F4F4F4;
        border-radius: 15px;
    }
    .user__img {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        width: 30px;
        height: 30px;
        background-color: #D4D4D4;
        border-radius: 100%;
    }
    .user__img img {
        width: 20px;
        height: 20px;
    }
    .user__title {
        font-weight: normal;
        font-size: 16px;
        line-height: 18px;
        color: #052137;
        margin-bottom: 3px;
    }
    .user__email {
        font-size: 14px;
        line-height: 16px;
        color: #7D7D7D;
        margin: 0;
    }
    .user__btn {
        margin-left: auto;
        cursor: pointer;
        margin-right: 5px;
    }
    .auth-desc {
        text-align: center;
        font-weight: normal;
        font-size: 12px;
        line-height: 14px;
        color: #A1A1A1;
        margin: 12px 0 14px 0;
    }
</style>
