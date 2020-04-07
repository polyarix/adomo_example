require('./bootstrap');
require('./shared/common');

import Vuex from 'vuex';
import Store from './store';
import route from 'ziggy'
import { Ziggy } from './../assets/js/ziggy';
import HttpMixin from "./helpers/Common/Http/HttpMixin";
import ValidationMixin from "./helpers/Common/Validation/ValidationMixin";
import Vuesax from 'vuesax';
import VueRouter from 'vue-router';
import vuescroll from "vuescroll/dist/vuescroll-native";
import VueYouTubeEmbed from 'vue-youtube-embed';
import { VueReCaptcha } from 'vue-recaptcha-v3';

import 'vuescroll/dist/vuescroll.css';
import 'vuesax/dist/vuesax.css';

const moment = require('moment');
require('moment/locale/ru');

window.Vue = require('vue');

window.route = route;
window.Ziggy = Ziggy;

Vue.use(vuescroll);
Vue.prototype.$vuescrollConfig = {
    scrollPanel: {
        scrollingX: false,
    },
    bar: {
        hoverStyle: true,
        background: 'rgba(50, 50, 50, .5)',
        width: '3px'
    },
    rail: {
        size: '3px',
        gutterOfSide: '0',
    },
};

Vue.use(Vuesax, {});
Vue.use(Vuex);
Vue.use(require('vue-moment'), {moment});
Vue.mixin(ValidationMixin);
Vue.mixin(HttpMixin);
Vue.use(VueRouter);
Vue.use(VueYouTubeEmbed);

window.recaptchaField = process.env.MIX_RECAPTCHA_INPUT_NAME || 'g-recaptcha-response';
window.recaptchaEnabled = Boolean(process.env.MIX_RECAPTCHA_ENABLED || true);
if(recaptchaEnabled) {
    Vue.use(VueReCaptcha, {
        siteKey: process.env.MIX_RECAPTCHA_SITE_KEY,
        loaderOptions: {
            autoHideBadge: true
        }
    });
}

Vue.mixin({
    methods: {
        route: (name, params, absolute) => route(name, params, absolute, Ziggy),
    }
});

Vue.component('contact-form-component', () => import(/* webpackChunkName: "contacts" */'./components/Frontend/Main/ContactFormComponent'));
Vue.component('offer-form-component', () => import(/* webpackChunkName: "contacts" */'./components/Frontend/Main/OfferFormComponent'));

Vue.component('map-component', () => import('./components/MapComponent'));
Vue.component('order-map', () => import('./components/Frontend/Advert/Advert/Order/OrderMapComponent'));

Vue.component('truncate-component', () => import('./components/Frontend/Cabinet/_partials/TruncateComponent'));
Vue.component('auto-fit-component', () => import('./components/Shared/AutoFitComponent'));
Vue.component('auto-fit-full-page-component', () => import('./components/Frontend/Advert/Autofit/AutofitComponent'));
Vue.component('select-city-component', () => import('./components/Shared/SelectCityComponent'));

Vue.component('companies-list-component', () => import(/* webpackChunkName: "companies" */'./components/Frontend/Company/List'));

Vue.component('signup-component', () => import(/* webpackChunkName: "auth" */'./components/Frontend/SignUp/SignUpComponent'));
Vue.component('login-component', () => import(/* webpackChunkName: "auth" */'./components/Frontend/Login/LoginComponent'));
Vue.component('reset-password-request', () => import(/* webpackChunkName: "auth" */'./components/Frontend/Cabinet/PasswordRecovery/RequestCode'));
Vue.component('reset-password-change', () => import(/* webpackChunkName: "auth" */'./components/Frontend/Cabinet/PasswordRecovery/ChangePassword'));
Vue.component('email-verification', () => import(/* webpackChunkName: "auth" */'./components/Frontend/Cabinet/Verification/EmailVerification'));
Vue.component('phone-verification', () => import(/* webpackChunkName: "auth" */'./components/Frontend/Cabinet/Verification/PhoneVerification'));
// ...
Vue.component('blog-articles-component', () => import(/* webpackChunkName: "blog" */'./components/Frontend/Blog/IndexComponent.vue'));
Vue.component('blog-articles-comment-form', () => import(/* webpackChunkName: "blog" */'./components/Frontend/Blog/CommentComponent.vue'));

const router = new VueRouter({
    routes: [
        {
            path: '/cabinet/chat/:id',
            component: () => import('./components/Frontend/Cabinet/Conversation/ConversationsComponent'),
            name: 'cabinet.conversation.show'
        },
        {
            path: '/cabinet/tasks',
            component: () => import('./components/Frontend/Cabinet/Profile/Task/Index/List'),
            name: 'cabinet.tasks.index'
        },
        {
            path: '/cabinet/tasks/:type',
            component: () => import('./components/Frontend/Cabinet/Profile/Task/Index/List'),
            name: 'cabinet.tasks.list'
        }
    ],
    mode: 'history',
});

const app = new Vue({
    el: '#app',
    store: Store,
    router,
    created() {
        this.$store.commit('user/setUser', window.user);
    },
});