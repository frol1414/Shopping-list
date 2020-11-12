// require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';
import Vue2TouchEvents from 'vue2-touch-events'
import 'es6-promise/auto';
import axios from 'axios';
import VueAuth from '@websanova/vue-auth';
import VueAxios from 'vue-axios';
import auth from './auth';
import Loader from "./components/Loader";
import {routes} from './routes'
import Vuelidate from 'vuelidate'

Vue.use(VueRouter);
Vue.use(Vue2TouchEvents)
Vue.use(Vuelidate)

import App from './views/App';

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes
});
Vue.router = router;
Vue.use(VueAxios, axios);
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;
// axios.defaults.xsrfCookieName = 'laravel_session';
// axios.defaults.xsrfHeaderName = "X-XSRF-TOKEN";
Vue.use(VueAuth, auth);

/*import VueSocialauth from 'vue-social-auth';
Vue.use(VueSocialauth, {
    providers: {
        facebook: {
            clientId: process.env.FACEBOOK_CLIENT_ID,
            redirectUri: 'login/callback/facebook' // Your client app URL
        },
        vkontakte: {
            clientId: process.env.VKONTAKTE_CLIENT_ID,
            redirectUri: 'login/callback/vkontakte' // Your client app URL
        }
    }
})*/


const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
});

Notification.requestPermission(function(status) {
    // console.log(status)
});
// export function displayNotification() {
//     if (Notification.permission == 'granted') {
//         navigator.serviceWorker.getRegistration().then(function(reg) {
//             reg.showNotification('А Вы ничего не забыли по списку?');
//         });
//     }
// }

export function newProducts() {
    if (Notification.permission == 'granted') {
        navigator.serviceWorker.getRegistration().then(function(reg) {
            const options = {
                body: 'First notification!',
                icon: './images/telegram.svg',
                vibrate: [100, 50, 100],
                data: {
                    dateOfArrival: Date.now(),
                    primaryKey: 1
                },

                // TODO 2.5 - add actions to the notification

                // TODO 5.1 - add a tag to the notification

            };
            reg.showNotification('В Вашем списке произошли изменения', options);
        });
    }
}
