import Vue from 'vue';

Vue.component('signup-component', require('./../components/Frontend/SignUp/SignUpComponent').default);
Vue.component('login-component', require('./../components/Frontend/Login/LoginComponent').default);
Vue.component('reset-password-request', require('./../components/Frontend/Cabinet/PasswordRecovery/RequestCode').default);
Vue.component('reset-password-change', require('./../components/Frontend/Cabinet/PasswordRecovery/ChangePassword').default);
Vue.component('email-verification', require('./../components/Frontend/Cabinet/Verification/EmailVerification').default);
Vue.component('phone-verification', require('./../components/Frontend/Cabinet/Verification/PhoneVerification').default);
