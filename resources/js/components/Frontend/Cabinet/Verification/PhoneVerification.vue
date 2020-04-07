<template>
    <div class="col questionnaire-outer">
        <div class="questionnaire">
            <div class="questionnaire-heading">Заполнение анкеты</div>
            <div class="questionnaire-subtitle">Регистрация подрядчика (мастера, бригады или компании) После регистрации вы сможете получать задания и зарабатывать на сервисе Adomo.ru</div>
            <div class="hr-1"></div>
            <div class="questionnaire-title">Подтверждение контактов</div>

            <div class="alert alert-success" v-if="common_message">
                {{ common_message }}
            </div>

            <div class="alert alert-danger" v-if="common_error">
                {{ common_error }}
            </div>

            <div class="questionnaire-subtitle">На ваш  почту отправлено письмо с кодом для активации вашей учетной записи.</div>
            <form class="mail-confirmation-form">
                <div class="form-group">
                    <input
                        type="text"
                        name="email_code"
                        placeholder="Контактный телефон"
                        class="form-control"
                        v-model="phone"
                        :class="{ 'form-control': true, 'is-invalid': error }"
                        pattern="\d*"
                        maxlength="6"
                        required
                    >

                    <button class="btn btn-big btn-default" @click.prevent="checkPhone"> <span>Проверить номер</span></button>

                    <input
                        type="text"
                        name="email_code"
                        placeholder="Введите код"
                        class="form-control"
                        v-model="phone_code"
                        :class="{ 'form-control': true, 'is-invalid': error }"
                        pattern="\d*"
                        maxlength="6"
                        required
                    >

                    <div class="warning">
                        Код действителен в течении 2 минут, <a href="#" @click.prevent="reSend">отправить заново</a>.
                    </div>

                    <span class="invalid-feedback" role="alert" v-if="error">
                        <strong>{{ error }}</strong>
                    </span>
                </div>
                <button class="btn btn-big btn-yellow" @click.prevent="checkCode"> <span>Следующий шаг </span></button>
            </form>
        </div>
    </div>
</template>

<script>
    const CHECK_PHONE_URL = '/api/user/sign_up/check_phone';
    const RESEND_PHONE_URL = '/api/user/sign_up/resend_phone';

    export default {
        data() {
            return {
                phone: '',
                phone_code: '',
                error: '',

                common_error: '',
                common_message: '',
            }
        },

        methods: {
            checkCode() {
                this.common_error = this.common_message = '';

                axios.post(CHECK_PHONE_URL, { code: this.phone_code })
                    .then(res => {
                        if(res.data.success === true) {
                            window.location.reload();
                            return;
                        }
                        this.common_error = res.data.error;
                    })
                    .catch(err => {
                        if(err.response.status === 422) {
                            this.common_error = err.response.data.message;
                            return
                        }

                        this.common_error = err.message
                    })
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
                    .catch(err => this.common_error = err.message)
            }
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
</style>
