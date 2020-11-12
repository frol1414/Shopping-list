<template>
    <section class="auth-container">
        <img src="images/register-img.png" alt="auth" class="auth-img">

        <h2 class="auth-title">Регистрация</h2>

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

            <div class="form-group form-group__password" v-bind:class="{ 'has-error': has_error && errors.password }">
                <label for="password">Пароль</label>
                <img :src="'../images/password.svg'" class="form-group__img" alt="user">
                <input type="password" id="password" class="form-group__input" placeholder="Пароль" v-model="password">
                <span class="help-block" v-if="has_error && errors.password">{{ errors.password }}</span>
            </div>

            <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.password }">
                <label for="password_confirmation">Повторите пароль</label>
                <img :src="'../images/password.svg'" class="form-group__img" alt="user">
                <input type="password" id="password_confirmation" class="form-group__input" placeholder="Пароль"
                       v-model="password_confirmation">
            </div>

            <button type="submit" class="auth-btn">Зарегистрироваться</button>
        </form>
    </section>
</template>


<script>
    import {v4 as uuidv4} from "uuid";
    import {mapMutations, mapGetters} from 'vuex';
    import {maxLength} from "vuelidate/lib/validators";

    export default {
        name: "Registration.vue",
        data() {
            return {
                name: '',
                nickname: '',
                email: '',
                password: '',
                password_confirmation: '',
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
            ...mapGetters(['getList', 'getLists', 'getProductsTypeNoAuth']),
            ...mapMutations(['setFirstList', 'setFirstProducts', 'setProducts']),
            register() {
                if (this.$v.$invalid) {
                    this.$v.$touch()
                    return
                }
                let listId;
                if (!this.getLists().length) {
                    this.setFirstList()
                    listId = this.getList()
                    const products = [
                        {
                            external_id: uuidv4(),
                            title: 'Булочки с повидлом',
                            'list_id': listId,
                            product_group_id: 'cb2eaa85-9232-4c25-b3ba-9472317ce28a',
                            unit: '4 шт.',
                            marked: false,
                            product_group: {color: '#F70909'},
                            type: 'noAuth'
                        },
                        {
                            external_id: uuidv4(),
                            title: 'Молоко',
                            'list_id': listId,
                            product_group_id: '692b46bd-bdbc-4841-ae50-c8e85ea36f64',
                            unit: '2 л.',
                            marked: false,
                            product_group: {color: '#6633F9'},
                            type: 'noAuth'
                        },
                        {
                            external_id: uuidv4(),
                            title: 'Хлеб Бородинский',
                            'list_id': listId,
                            product_group_id: 'cb2eaa85-9232-4c25-b3ba-9472317ce28a',
                            unit: '1 шт.',
                            marked: true,
                            product_group: {color: '#F70909'},
                            type: 'noAuth'
                        },
                        {
                            external_id: uuidv4(),
                            title: 'Огурцы',
                            'list_id': listId,
                            product_group_id: '5133b9e0-f27b-4b07-964c-00d2babaafb7',
                            unit: '500 гр.',
                            marked: false,
                            product_group: {color: '#FCF554'},
                            type: 'noAuth'
                        },
                        {
                            external_id: uuidv4(),
                            title: 'Кефир',
                            'list_id': listId,
                            product_group_id: '692b46bd-bdbc-4841-ae50-c8e85ea36f64',
                            unit: '1 л.',
                            marked: true,
                            product_group: {color: '#6633F9'},
                            type: 'noAuth'
                        },
                        {
                            external_id: uuidv4(),
                            title: 'Шоколад "Аленка"',
                            'list_id': listId,
                            product_group_id: '',
                            unit: '1 шт.',
                            marked: false,
                            product_group: {color: ''},
                            type: 'noAuth'
                        }
                    ]
                    this.setFirstProducts(products)
                }
                    this.setProducts(this.getProductsTypeNoAuth())


                let app = this
                this.$auth.register({
                    data: {
                        email: app.email,
                        name: app.name,
                        password: app.password,
                        password_confirmation: app.password_confirmation,
                        state: JSON.parse(localStorage.getItem('vuex'))
                    },
                    success: function () {
                        app.success = true
                        app.$router.push({name: 'start', params: {successRegistrationRedirect: true}})
                            .catch(()=>{})
                    },
                    error: function (res) {
                        console.log(res.response.data.errors)
                        app.has_error = true
                        app.error = res.response.data.error
                        app.errors = res.response.data.errors || {}
                    }
                })
            }
        }
    }
</script>

<style scoped>
    .auth-title {
        padding: 35px 0 25px 30px;
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
