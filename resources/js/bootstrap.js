import {gsap, Power4} from "gsap";

window.Swiper = require('swiper').default;

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.gsap = gsap;
    window.Power4 = Power4;

    require('jquery-mask-plugin');
    require('bootstrap');
    require('flatpickr');
    require('jquery-lazy');

    require('@fancyapps/fancybox');//($);
    //require('fancybox')($);

    const Russian = require("flatpickr/dist/l10n/ru.js").default.ru;
    flatpickr.localize(Russian);
} catch (e) {
    console.log(e)
}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

import Echo from 'laravel-echo';

window.io = require('socket.io-client');

if (typeof io !== 'undefined') {
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':6001',
    });
}
