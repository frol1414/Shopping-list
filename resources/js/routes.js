import StartPage from './views/StartPage';
import Collaboration from "./views/Collaboration";
import List from "./views/List";
import Registration from "./views/Registration";
import Login from "./views/Login";
import DiscountCards from "./views/DiscountCards";
import DiscountCardData from "./views/DiscountCardData";
import DiscountCardScan111 from "./views/DiscountCardScan";
import DiscountCardAdd from "./views/DiscountCardAdd";
import AttachCards from "./views/AttachCards";
import Lists from "./views/Lists";
import Profile from "./views/Profile";

export const routes = [
    // {
    //     path: '/',
    //     name: 'start',
    //     meta: {layout: 'auth', auth: undefined},
    //     component: () => import('./views/StartPage.vue')
    // },
    {
        path: '/',
        name: 'lists',
        meta: {layout: 'main', auth: undefined},
        component: () => import('./views/Lists.vue')
    },
    {
        path: '/registration',
        name: 'registration',
        meta: {layout: 'auth', auth: false},
        component: () => import('./views/Registration.vue')
    },
    {
        path: '/login',
        name: 'login',
        meta: {layout: 'auth', auth: false},
        component: () => import('./views/Login.vue')
    },
    {
        path: '/profile',
        name: 'profile',
        meta: {layout: 'auth', auth: false},
        component: () => import('./views/Profile.vue')
    },
    {
        path: '/list/:id',
        name: 'list',
        meta: {layout: 'main', auth: undefined},
        component: () => import('./views/List.vue')
    },
    {
        path: '/collaboration',
        name: 'collaboration',
        meta: {layout: 'main', auth: undefined},
        component: () => import('./views/Collaboration.vue')
    },
    {
        path: '/attach-cards',
        name: 'attachCards',
        meta: {layout: 'main', auth: undefined},
        component: () => import('./views/AttachCards.vue')
    },
    {
        path: '/discountCards',
        name: 'discountCards',
        meta: {layout: 'main', auth: undefined},
        component: () => import('./views/DiscountCards.vue')
    },
    {
        path: '/discountCardData/:id',
        name: 'discountCardData',
        meta: {layout: 'main', auth: undefined},
        component: () => import('./views/DiscountCardData.vue')
    },
    {
        path: '/discountCardScan',
        name: 'discountCardScan',
        meta: {layout: 'main', auth: undefined},
        component: () => import('./views/DiscountCardScan.vue')
    },
    {
        path: '/discountCardAdd',
        name: 'discountCardAdd',
        meta: {layout: 'main', auth: undefined},
        component: () => import('./views/DiscountCardAdd.vue')
    },
]
