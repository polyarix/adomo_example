import Vue from 'vue';

Vue.component('contact-form-component', require('./../components/Frontend/Main/ContactFormComponent').default);
Vue.component('offer-form-component', require('./../components/Frontend/Main/OfferFormComponent').default);

Vue.component('order-map', require('./../components/Frontend/Advert/Advert/Order/OrderMapComponent').default);

Vue.component('truncate-component', require('./../components/Frontend/Cabinet/_partials/TruncateComponent').default);
Vue.component('map-component', require('./../components/MapComponent').default);
