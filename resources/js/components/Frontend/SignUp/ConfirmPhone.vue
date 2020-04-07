<template>
    <div>
        <div class="form-group-name">Контактный телефон</div>

        <div class="questionnaire-inner-container">
            <div class="alert alert-success" v-if="common_message">
                {{ common_message }}
            </div>

            <div class="alert alert-danger" v-if="common_error">
                {{ common_error }}
            </div>

            <span class="invalid-feedback" style="margin-top: 120px;" role="alert" v-if="getResendSecondsLeft()">
            <strong>До повторного запроса осталось {{ getResendSecondsLeft() }} секунд</strong>
            </span>

            <!--<div class="alert alert-danger" v-if="getResendSecondsLeft()">
                До повторного запроса осталось {{ getResendSecondsLeft() }} секунд
            </div>-->
        </div>

        <div class="questionnaire-inner-container">
            <div class="form-group-phone">
                <span class="invalid-feedback" role="alert" v-if="isError('phone_number')">
                    <strong>{{ getError('phone_number') }}</strong>
                </span>

                <div class="form-group input-phone">
                    <input
                        type="text"
                        id="phone_number"
                        name="email_code"
                        placeholder="Контактный телефон"
                        class="form-control"
                        v-model="phone_number"
                        :class="{ 'form-control': true, 'is-invalid': isError('phone_number') }"
                        :disabled="isPhoneInputDisabled"
                        required
                    >
                </div>

                <button class="btn btn-big btn-white" @click.prevent="checkPhone" :disabled="isCheckButtonDisabled"> <span>Проверить номер</span></button>
            </div>
            <div class="form-input-description text">Мы отправим вам SMS с 6-ти значным кодом для подтверждения номера телефона.</div>
        </div>
        <div class="questionnaire-inner-container">
            <div class="check-phone-code">
                <div class="form-group">
                    <input
                        type="text"
                        id="phone_code"
                        placeholder="Введите код"
                        v-model="phoneCode"
                        pattern="\d*"
                        maxlength="6"
                        :disabled="isCodeInputDisabled"
                    >
                </div>
            </div>
            <div class="form-input-description text" v-if="!isCheckButtonDisabled">
                Код действителен в течение 1 минуты. <a href="#" @click.prevent="reSend">Отправить код еще раз</a>
            </div>

            <span class="invalid-feedback" role="alert" v-if="isError('phone_code')">
            <strong>{{ getError('phone_code') }}</strong>
        </span>
        </div>
    </div>
</template>

<script>
    const CHECK_PHONE_URL = '/api/user/sign_up/attach_phone';
    const CHECK_CODE_URL = '/api/user/sign_up/check_phone';
    const RESEND_PHONE_URL = '/api/user/sign_up/resend_phone';

    export default {
        props: {
            phone: {
                type: String,
                default: ''
            },
            smsDate: {
                type: String,
                default: ''
            },
            isConfirmed: {
                type: Boolean,
                default: false
            },
        },

        data() {
            return {
                phone_number: this.phone,
                number_attached: this.smsValid,
                code_verified: false,

                phoneCode: '',
                error: '',

                common_error: '',
                common_message: '',
                loading: false,
                rateLimitDate: '',

                errors: []
            }
        },

        computed: {
            isPhoneInputDisabled() {
                return this.number_attached === true || this.isConfirmed;
            },
            isCheckButtonDisabled() {
                return this.isConfirmed;
            },
            isCodeInputDisabled() {
                return !this.phone_number || this.phone_number.length !== 18 || this.number_attached === false && !this.code_verified || this.isConfirmed;
            },
            tokenSentMinutes() {
                let today = new Date();
                let sent = new Date(this.smsDate);

                let diffMs = today - sent;

                return Math.round(((diffMs % 86400000) % 3600000) / 60000)
            }
        },

        methods: {
            checkPhone() {
                let errors = {};

                if(this.phone_number.length !== 18) {
                    errors['phone_number'] = 'Введите корректный телефон';
                }

                this.errors = errors;
                this.common_error = this.common_message = '';

                if(Object.keys(errors).length > 0) {
                    return false;
                }

                axios.post(CHECK_PHONE_URL, { phone_number: this.phone_number })
                    .then(res => {
                        if(res.data.success === true) {
                            console.log('success');
                            this.number_attached = true;
                            this.common_message = 'СМС сообщение с кодом верификации успешно отправлено.';
                            //window.location.reload();
                            return;
                        }
                        this.common_error = res.data.error;
                    })
                    .catch(err => {
                        if(err.response.status === 422) {
                            this.common_error = err.response.data.errors.phone_number[0];
                            return
                        }
                        if(err.response.status === 429) {
                            this.rateLimitDate = err.response.headers['x-ratelimit-reset'];
                            this.common_error = 'Вы отправляете запросы слишком часто.';
                            return
                        }

                        this.common_error = err.message
                    })
            },

            checkCode() {
                this.common_error = this.common_message = '';
                this.loading = true;

                axios.post(CHECK_CODE_URL, { code: this.phoneCode })
                    .then(res => {
                        if(res.data.success === true) {
                            this.common_message = 'Телефон успешно подтверждён.';
                            this.code_verified = true;
                            this.code_verified = true;
                            this.$emit('confirmed', this.phone_number);
                            //window.location.reload();
                            return;
                        }
                        this.common_error = res.data.error;
                    })
                    .catch(err => {
                        if(err.response.status === 422) {
                            this.common_error = err.response.data.errors.phone_number[0];
                            return
                        }
                        if(err.response.status === 429) {
                            this.rateLimitDate = err.response.headers['x-ratelimit-reset'];
                            this.common_error = 'Вы отправляете запросы слишком часто.';
                            return
                        }

                        this.common_error = err.message
                    })
                    .finally(() => { this.loading = true; })
            },

            reSend() {
                this.common_error = this.common_message = '';

                axios.post(RESEND_PHONE_URL)
                    .then(res => {
                        if(res.data.success === true) {
                            this.common_message = 'Сообщение успешно отправлено.';
                            //setTimeout(() => this.common_message = '', 3000);
                            return;
                        }
                        this.common_error = res.data.error;
                    })
                    .catch(err => {
                        if(err.response.status === 429) {
                            this.rateLimitDate = err.response.headers['x-ratelimit-reset'];
                            this.common_error = 'Вы отправляете запросы слишком часто.';
                            return
                        }

                        this.common_error = err.message;
                    })
            },

            checkPhoneCode() {
                this.loading = true;

                axios.post(API_CHECK_PHONE, { code: this.phoneCode })
                    .then(res => {
                        if(res.data.success === true) {
                            this.$emit('validate', this.phone_number);
                            return;
                        }

                        this.common_error = res.data.error;
                    })
                    .catch(err => {
                        this.common_error = err.message;
                    })
                    .finally(() => { this.loading = true; })
            },

            isError(key) {
                return this.getError(key) !== undefined
            },
            getError(key) {
                return this.errors[key]
            },
            getResendSecondsLeft() {
                if(!this.rateLimitDate) {
                    return false;
                }

                let left = +this.rateLimitDate - (Math.floor(Date.now() / 1000));

                console.log(left);
                if(left < 0) {
                    return false;
                }

                return left;
            }
        },

        watch: {
            phoneCode() {
                if(this.phoneCode.length === 6) {
                    // send ajax request
                    this.checkCode();
                }
            }
        },

        mounted() {
            $(document).ready(() => {
                $('#phone_number').mask('+0 (000) 000 00 00', {placeholder: "+_ (___) ___ __ __"});
            })
        }
    }
</script>

<style scoped>
    .warning {
        padding: 10px;
    }
    .warning a {
        color: #0d95e8;
    }
    .invalid-feedback {
        position: absolute;
        margin-top: 60px;
    }
    .form-group input:disabled {
        background: #ccc;
    }
    .btn-white:disabled {
        background: #ccc;
        cursor: not-allowed;
    }
</style>
