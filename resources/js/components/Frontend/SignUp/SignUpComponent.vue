<template>
    <div class="row login-page-row">
        <div class="col login-page-info">
            <div class="login-page-title">Регистрация {{ isCustomer ? 'заказчика' : 'исполнителя' }}</div>

            <div class="login-page-subtitle" v-if="isExecutor">После регистрации вы сможете получать задания и зарабатывать на сервисе</div>
            <div class="login-page-subtitle" v-if="isCustomer">После регистрации вы сможете получать задания и зарабатывать на сервисе</div>

            <div class="login-page-description">
                <div class="login-page-description-item">
                    <h2>Более 800 категорий услуг для работы</h2>
                    <p>Вы сможете работать как по своей специальности, так и пробовать свои силы в новых направлениях</p>
                </div>
                <div class="login-page-description-item">
                    <h2>Работайте в удобное для вас время</h2>
                    <p>Составьте свой личный график работы и зарабатывайте только когда вам удобно</p>
                </div>
                <div class="login-page-description-item">
                    <h2>Зарабатывайте достойно</h2>
                    <p>Может быть для вас источником как дополнительного заработка, так и основного финансового дохода</p>
                </div>
            </div>
        </div>
        <div class="col login-page-form">
            <div class="form-card">
                <div class="form-title">Тип пользователя</div>

                <div class="alert alert-danger" v-if="success_message">{{ success_message }}</div>
                <div class="alert alert-danger" v-if="common_error">{{ common_error }}</div>

                <div class="form-switch">
                    <div class="form-switch-controls">
                        <button @click="setType('customer')" :class="{ 'form-switch-btn': true, 'current': isCustomer }">Заказчик</button>
                        <button @click="setType('executor')" :class="{ 'form-switch-btn': true, 'current': isExecutor }">Исполнитель</button>
                    </div>
                    <div class="form-switch-info">Пользователь отбирающий исполнителей для своих проектов.</div>
                </div>
                <form>
                    <div class="form-group">
                        <label for="first_name">Ваше имя</label>
                        <input
                            id="first_name"
                            type="text"
                            name="first_name"
                            :class="{ 'form-control': true, 'is-invalid': isError('first_name') }"
                            v-model="first_name"
                            required
                        >

                        <span class="invalid-feedback" role="alert" v-if="isError('first_name')">
                            <strong>{{ getError('first_name') }}</strong>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="email">Почта</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            :class="{ 'form-control': true, 'is-invalid': isError('email') }"
                            v-model="email"
                            required
                        >

                        <span class="invalid-feedback" role="alert" v-if="isError('email')">
                            <strong>{{ getError('email') }}</strong>
                        </span>
                    </div>
                    <div class="form-check">
                        <label for="agree">C правилами <a href="#">сервиса согласен</a>
                            <input type="checkbox" id="agree" required="required" v-model="is_agree" />
                            <span class="checkmark" :class="{'is-invalid': isError('is_agree') }"></span>

                            <span class="invalid-feedback" role="alert" v-if="isError('is_agree')">
                                <strong>{{ getError('is_agree') }}</strong>
                            </span>
                        </label>
                    </div>
                    <button class="btn btn-big btn-yellow btn-auto" @click.prevent="setToStep(2)"><span>Зарегистрироваться</span></button>
                </form>

                <div class="form-social-info">Регистрация с помощью соцсетей:</div>
                <div class="form-social-login">
                    <a class="social-login-btn vk-btn" :href="getLoginUrl('facebookUrl')">
                        <svg class="vk">
                            <use xlink:href="/images/sprite-inline.svg#vk"></use>
                        </svg>
                        <span>Facebook</span>
                    </a>

                    <a class="social-login-btn vk-btn" :href="getLoginUrl('vkUrl')">
                        <svg class="vk">
                            <use xlink:href="/images/sprite-inline.svg#vk"></use>
                        </svg>
                        <span>Vkontakte</span>
                    </a>

                    <a class="social-login-btn ok-btn" :href="getLoginUrl('odnoklassnikiUrl')">
                        <svg class="odnoklassniki">
                            <use xlink:href="/images/sprite-inline.svg#odnoklassniki"></use>
                        </svg>
                        <span>Одноклассники</span>
                    </a>
                </div>

                <div class="form-account-ask">Уже есть аккаунт? <a href="/login">Войти в систему</a></div>
            </div>
        </div>
    </div>
</template>

<script>
    import ConfirmEmail from "./ConfirmEmail";
    import ConfirmPhone from "./ConfirmPhone";
    import CommonForm from "./CommonForm";
    import {isValidEmail} from './../../../helpers/User/SignUpHelpers';

    const STEP_COMMON = 1;
    const STEP_PHONE = 2;
    const STEP_EMAIL = 3;
    const STEP_FINISH = 4;

    const EXECUTOR_TYPE = 'executor';
    const CUSTOMER_TYPE = 'customer';

    const API_CHECK_DATA_URL = '/api/user/sign_up/check_data';
    const API_RESEND_PHONE_URL = '/api/user/sign_up/resend_phone';
    const API_RESEND_EMAIL_URL = '/api/user/sign_up/resend_email';

    export default {
        props: ['facebookUrl', 'vkUrl', 'odnoklassnikiUrl'],

        data() {
            return {
                type: 'executor',
                types: ['executor', 'customer'],

                first_name: '',
                email: '',
                phone_code: '',
                email_code: '',
                is_agree: false,

                step: 1,
                common_error: '',
                success_message: '',
                errors: []
            }
        },

        computed: {
            isFirstStep() {
                return this.step === STEP_COMMON;
            },
            isConfirmPhoneStep() {
                return this.step === STEP_PHONE;
            },
            isConfirmEmailStep() {
                return this.step === STEP_EMAIL;
            },
            isExecutor() {
                return this.type === EXECUTOR_TYPE
            },
            isCustomer() {
                return this.type === CUSTOMER_TYPE
            }
        },

        methods: {
            getLoginUrl(field) {
                return `${this[field]}/${this.type}`
            },
            getUserType(type) {
                return isExecutor ? 'Исполнитель' : 'Заказчик';
            },
            setType(type) {
                this.type = type;
            },
            onValidate(type, val) {
                if(type === 'phone_code') {
                    this.setToStep(STEP_EMAIL);
                    this.phone_code = val;
                    return;
                }

                if(type === 'email_code') {
                    this.setToStep(STEP_FINISH);
                    this.email_code = val;
                    return;
                }
            },
            onRepeatSending: _.debounce(function(type) {
                axios.post(API_RESEND_PHONE_URL)
                    .then(res => {
                        if(res.data.success === true) {
                            this.success_message = type === 'sms' ? 'СМС успешно отправлено.' : 'Email успешно отправлен.';
                        }

                        setTimeout(this.success_message = '', 3000);
                    })
            }, 500),
            async setToStep(step) {
                let errors = {};

                if(this.first_name.length < 2) {
                    errors['first_name'] = 'Имя должно быть длиннее 2 сиволов.';
                }
                if(this.email.length < 2 || !isValidEmail(this.email)) {
                    errors['email'] = 'Почта не валидна.';
                }
                if(!this.is_agree) {
                    errors['is_agree'] = 'Примите правила сервиса.';
                }

                /*if(this.phone.length !== 16) {
                    errors['phone'] = 'Введите корректный телефон.';
                }*/

                this.errors = errors;

                if(Object.keys(errors).length > 0) {
                    return false;
                }

                let data = {email: this.email, type: this.type, first_name: this.first_name};
                if(window.recaptchaEnabled) {
                    await this.$recaptchaLoaded();
                    data[window.recaptchaField] = await this.$recaptcha('register');
                }

                axios.post(API_CHECK_DATA_URL, data)
                    .then(res => {
                        let data = res.data;

                        if(data.success === true) {
                            //this.step = step;

                            window.location.href = '/home';
                        } else {
                            this.common_error = data.error;
                        }
                    })
                    .catch(err => {
                        let data = err.response.data;

                        this.common_error = data.message;
                        for(let key in data.errors) {
                            this.errors[key] = data.errors[key][0];

                            if(key === window.recaptchaField) {
                                this.common_error = 'Вы похожи на бота. Обновите страницу и попробуйте ещё раз.'
                            }
                        }
                    })
            },
            isError(key) {
                return this.getError(key) !== undefined
            },
            getError(key) {
                return this.errors[key]
            },
        },

        components: {
            ConfirmEmail, ConfirmPhone
        }
    }
</script>

<style scoped>

</style>
