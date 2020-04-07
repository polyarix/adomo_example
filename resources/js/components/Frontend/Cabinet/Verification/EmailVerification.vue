<template>
    <div class="row registration-part">
        <div class="col questionnaire-outer">
            <div class="questionnaire">
                <div class="questionnaire-heading">Заполнение анкеты</div>
                <div class="questionnaire-subtitle">Регистрация подрядчика (мастера, бригады или компании) После регистрации вы сможете получать задания и зарабатывать на сервисе Adomo.ru</div>
                <div class="hr-1"></div>
                <div class="questionnaire-title">Подтверждение контактов</div>

                <div class="alert alert-success" v-if="hasCommonMessage">
                    {{ getCommonMessage }}
                </div>
                <div class="alert alert-danger" v-if="hasCommonError">
                    {{ getCommonError }}
                </div>

                <div class="questionnaire-subtitle">На вашу электронную почту отправлено письмо с кодом для активации вашей учетной записи.</div>
                <form class="mail-confirmation-form">
                    <div class="questionnaire-inner-container" v-if="!confirmed">
                        <div class="form-group-phone">
                            <div class="form-group input-phone">
                                <input
                                    type="email"
                                    name="email_code"
                                    placeholder="Заполните почту"
                                    class="form-control"
                                    v-model="email"
                                    :class="{ 'form-control': true, 'is-invalid': this.hasError('email') }"
                                    required
                                    v-if="mailInputVisible"
                                    @keyup.enter="onEmailCheck"
                                >
                            </div>
                            <button @click.prevent="onEmailCheck" v-if="visibleEmailButton" class="btn btn-big btn-white"> <span>Проверить почту</span></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <input
                            type="text"
                            name="email_code"
                            placeholder="Ввод кода из почты"
                            class="form-control"
                            v-model="email_code"
                            :class="{ 'form-control': true, 'is-invalid': hasError('email_code') }"
                            pattern="\d*"
                            maxlength="6"
                            required
                        >

                        <span class="invalid-feedback" role="alert" v-if="hasError('email_code')">
                            <strong>{{ getError('email_code') }}</strong>
                        </span>
                    </div>
                    <button class="btn btn-big btn-yellow" @click.prevent="checkCode"> <span>Следующий шаг </span></button>
                </form>

                <div class="warning">
                    Если вы не получили письмо, можете <a href="#" @click.prevent="reSend">отправить заново</a>.
                </div>
            </div>
        </div>
        <right-bar-component :progress="isCustomer ? 20 : 15" :type="user.type" :page="constants.CONTACTS_PAGE" />
    </div>
</template>

<script>
    import {isValidEmail} from "../../../../helpers/User/SignUpHelpers";

    import RightBarComponent from './../_partials/RightBarComponent';
    import * as BarConstants from './../_partials/bar_constants';

    export default {
        data() {
            return {
                email_code: '',
                email: this.userMail,
                confirmed: false
            }
        },
        props: ['userMail', 'user'],

        computed: {
            constants() {
                return BarConstants
            },
            isCustomer() {
                return this.user.type === BarConstants.TYPE_CUSTOMER
            },
            mailInputVisible() {
                return this.userMail.length === 0
            },
            visibleEmailButton() {
                if(this.userMail.length > 0) {
                    return false;
                }

                return !this.mailInputDisabled && this.email.length > 0 && isValidEmail(this.email)
            }
        },

        methods: {
            onEmailCheck() {
                axios.post(this.route('api.user.sign-up.attach_email'), { email: this.email })
                    .then(res => {
                        if(res.data.success === true) {
                            this.setCommonMessage('Почта успешно привязана. Введите код ниже.');
                            this.confirmed = true;
                            return;
                        }
                        this.setCommonError(res.data.error);
                    })
                    .catch(err => {
                        if(err.response.status === 422) {
                            this.setCommonError(err.response.data.message);
                            return
                        }
                        this.setCommonError(err.message);
                    })
            },
            checkCode() {
                this.clearBag();

                axios.post(this.route('api.user.sign-up.check_email'), { code: this.email_code })
                    .then(res => {
                        if(res.data.success === true) {
                            window.location.reload();
                            return;
                        }
                        this.setCommonError(res.data.error);
                    })
                    .catch(err => {
                        if(err.response.status === 422) {
                            this.setCommonError(err.response.data.message);
                            return
                        }
                        this.setCommonError(err.message);
                    })
            },

            reSend() {
                this.clearBag();

                axios.post(this.route('api.user.sign-up.resend_email'))
                    .then(res => {
                        if(res.data.success === true) {
                            this.setCommonMessage('Ссылка успешно отправлена.');
                            return;
                        }
                        this.setCommonError(res.data.error);
                    })
                    .catch(err => {
                        if(err.response.status === 429) {
                            this.setCommonError('Вы делаете слишком много запросов.');
                            return;
                        }
                        this.setCommonError(err.message);
                    })
            }
        },

        components: {
            RightBarComponent
        }
    }
</script>

<style scoped>
    .warning a {
        color: #0d95de;
    }
    .warning a:hover {
        color: #0d95e8;
        cursor: pointer;
    }
    .warning {
        margin-top: 25px;
        font-size: .9em;
    }
    input:disabled {
        background: silver;
    }
</style>
