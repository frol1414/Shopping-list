<template>
    <section class="auth-container">

        <div class="profile__header">
            <img :src="'../images/comeback.svg'" @click="$router.back()" alt="comeback">
        </div>

        <div class="user-container">
            <img :src="'../images/default-foto.svg'" class="" alt="user">
            <div>
                <p class="user__title">Нефедов Никита</p>
                <p class="user__nickname">@nefedov300</p>
            </div>
        </div>

        <form @submit.prevent="register" v-if="!success" method="post">
            <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.name }">
                <label for="name">Имя</label>
                <img :src="'../images/user.svg'" class="form-group__img" alt="user">
                <input type="text" id="name" class="form-group__input" placeholder="Иванов Иван" v-model="name">
                <span class="help-block" v-if="has_error && errors.name">{{ errors.name }}</span>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.nickname }">
                <label for="nickname">Логин</label>
                <img :src="'../images/at.svg'" class="form-group__img" alt="user">
                <input type="text" id="nickname" class="form-group__input" placeholder="user" v-model="nickname">
                <span class="help-block" v-if="has_error && errors.nickname">{{ errors.nickname }}</span>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.email }">
                <label for="email">Почта</label>
                <img :src="'../images/find-user.svg'" class="form-group__img" alt="user">
                <input type="email" id="email" class="form-group__input" placeholder="example@email.com" v-model="email">
                <span class="help-block" v-if="has_error && errors.email">{{ errors.email }}</span>
            </div>

            <div class="form-group form-group__password" v-bind:class="{ 'has-error': has_error && errors.old_password }">
                <label for="old_password">Старый пароль</label>
                <img :src="'../images/password.svg'" class="form-group__img" alt="user">
                <input type="password" id="old_password" class="form-group__input" placeholder="Пароль" v-model="old_password">
                <span class="help-block" v-if="has_error && errors.old_password">{{ errors.old_password }}</span>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.new_password }">
                <label for="new_password">Новый пароль</label>
                <img :src="'../images/password.svg'" class="form-group__img" alt="user">
                <input type="password" id="new_password" class="form-group__input" placeholder="Пароль"
                       v-model="new_password">
            </div>

            <button type="submit" class="auth-btn">Сохранить</button>
        </form>
    </section>
</template>


<script>

    // import {mapMutations, mapGetters} from 'vuex';
    import {maxLength} from "vuelidate/lib/validators";

    export default {
        name: "Profile.vue",
        data() {
            return {
                name: '',
                nickname: '',
                email: '',
                old_password: '',
                new_password: '',
                has_error: false,
                error: '',
                errors: {},
                success: false
            }
        },
        validations: {
            title: {maxLength: maxLength(35)}
        },
        methods: {

        },
    }
</script>

<style scoped>
    .auth-container {
        background-color: var(--yellow-color);
    }
    .profile__header {
        padding: 20px;
    }
    .user-container {
        display: flex;
        align-items: center;
        margin: 0 0 15px 30px;
    }
    .user-container img {
        margin-right: 15px;
    }
    .user__title {
        font-weight: 500;
        font-size: 25px;
        line-height: 29px;
        color: #052137;
        margin-bottom: 5px;
    }
    .user__nickname {
        font-weight: 500;
        font-size: 20px;
        line-height: 23px;
        color: #052137;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 12px;
    }
    .form-group__password {
        margin-top: 35px;
    }
    .form-group label {
        padding-left: 10px;
        font-weight: 500;
        font-size: 15px;
        line-height: 17px;
        color: #052137;
        margin-bottom: 5px;
    }
    .form-group__input {
        height: 40px;
    }
    .form-group__img {
        top: 32px;
    }
    .auth-btn {
        margin: 30px auto 0 auto;
    }
</style>
