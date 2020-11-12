<template>
    <section class="auth-container">
        <img src="images/auth-img.png" alt="auth" class="auth-img">

        <h2 class="auth-title">Авторизация</h2>

        <form @submit.prevent="login" method="post" novalidate>
            <div class="form-group">
                <img :src="'../images/user.svg'" class="form-group__img" alt="user">
                <input type="text" id="email" class="form-group__input" placeholder="E-mail" v-model="email" required
                       :class="{invalid: ($v.email.$dirty && !$v.email.required) || mismatchData}">
                <small class="helper-text invalid" v-if="($v.email.$dirty && !$v.email.required)">Данное поле обязательно</small>
            </div>

            <div class="form-group">
                <img :src="'../images/password.svg'" class="form-group__img" alt="password">
                <input type="password" id="password" class="form-group__input" placeholder="Пароль" v-model="password" required
                       :class="{invalid: ($v.email.$dirty && !$v.password.required) || mismatchData}">
                <small class="helper-text invalid" v-if="($v.password.$dirty && !$v.password.required)">Данное поле обязательно</small>
                <small class="helper-text invalid" v-if="mismatchData">Email или пароль не верны</small>
            </div>

            <button type="submit" class="auth-btn">Вход</button>
        </form>

        <div class="login-social">
            <span class="login-social__title lb-15">Войти в систему с</span>
            <div id="uLogin" class="ulogin-group">
                <div class="ulogin-item">
                    <a @click="AuthProvider('facebook')">
                        <img src="images/social/fb.png" alt="">
                    </a>
                </div>
                <div class="ulogin-item">
                    <a @click="AuthProvider('vkontakte')">
                        <img src="images/social/vk.png" alt="">
                    </a>
                </div>
                <div class="ulogin-item">
                    <a @click="AuthProvider('google')">
                        <img src="images/social/gl.png" alt="">
                    </a>
                </div>
                <div class="ulogin-item">
                    <a @click="AuthProvider('mailru')">
                        <img src="images/social/mr.png" alt="">
                    </a>
                </div>
                <div class="ulogin-item">
                    <a @click="AuthProvider('yandex')">
                        <img src="images/social/ydx.png" alt="">
                    </a>
                </div>
            </div>
        </div>

        <div class="registration">
            <p class="registration__title">Нет аккаунта?</p>
            <router-link tag="a" to="/registration" class="registration__link">Зарегистрируйтесь</router-link>
        </div>
    </section>
</template>

<script>
    // import {mapMutations} from "vuex";
    import axios from "axios";
    import {required} from "vuelidate/lib/validators";

    export default {
        name: "Login.vue",
        data() {
            return {
                email: null,
                password: null,
                has_error: false,
                mismatchData: false,
            }
        },
        validations: {
            email: {required},
            password: {required},
        },
        mounted() {
            window.addEventListener('message', this.onMessage, false)
            // this.toggleComeBackBtn(true)
        },
        beforeDestroy () {
            window.removeEventListener('message', this.onMessage)
        },
        methods: {
            // ...mapMutations(['toggleComeBackBtn']),
            login() {
                if (this.$v.$invalid) {
                    this.$v.$touch()
                    return
                }
                let redirect = this.$auth.redirect()
                let app = this
                app.mismatchData = false

                this.$auth.login({
                    params: {
                        email: app.email,
                        password: app.password
                    },
                    success: function() {
                        app.$router.push('/')
                    },
                    error: function(error) {
                        if(error.response.status === 401) {
                            app.mismatchData = true
                        }
                        app.has_error = true
                    },
                    rememberMe: true,
                    fetchUser: true
                })
            },
            AuthProvider(provider) {
                const newWindow = openWindow('', 'message')
                var self = this;
                axios.defaults.baseURL = `${process.env.MIX_APP_URL}`;
                this.$http.post('/login/'+provider, {state: JSON.parse(localStorage.getItem('vuex'))}, {withCredentials: true}).then(response => {
                    axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;
                    newWindow.location.href = response.data
                }).catch(err => {
                    axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;
                    console.log({err:err})
                });
            },
            onMessage (e) {
                if (e.origin !== window.origin || !e.data.token) {
                    return
                }
                localStorage.setItem('laravel-vue-spa', e.data.token);
                localStorage.setItem('auth_stay_signed_in', 'true');
                this.$router.push('/')
            }
        },
    }

    function openWindow (url, title, options = {}) {
        if (typeof url === 'object') {
            options = url
            url = ''
        }
        options = { url, title, width: 600, height: 720, ...options }
        const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left
        const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top
        const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width
        const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height
        options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft
        options.top = ((height / 2) - (options.height / 2)) + dualScreenTop
        const optionsStr = Object.keys(options).reduce((acc, key) => {
            acc.push(`${key}=${options[key]}`)
            return acc
        }, []).join(',')
        const newWindow = window.open(url, title, optionsStr)
        if (window.focus) {
            newWindow.focus()
        }
        return newWindow
    }
</script>

<style scoped>
    .auth-container {
        position: relative;
        overflow: hidden;
    }
    .auth-title {
        padding: 200px 0 30px 30px;
    }
    .form-group {
        height: 50px;
        margin-bottom: 20px;
    }
    .auth-btn {
        width: 250px;
        margin:  0 auto 20px auto;
    }
    .login-social__title {
        font-size: 15px;
        line-height: 17px;
        text-align: center;
        color: #7D7D7D;
    }
    .login-social {
        text-align: center;
    }
    .ulogin-group {
        margin-top: 15px;
    }
    .ulogin-item {
        display: inline-block;
        margin: 0 9px;
    }
    .ulogin-item img {
        height: 38px;
    }
    .registration {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 55px;
        padding-bottom: 20px;
    }
    .registration__title {
        font-size: 15px;
        line-height: 17px;
        color: #7D7D7D;
    }
    .registration__link {
        font-size: 15px;
        line-height: 17px;
    }
</style>
