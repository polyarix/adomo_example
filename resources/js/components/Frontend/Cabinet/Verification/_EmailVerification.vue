<template>
    <div>
        <div class="alert alert-success" v-if="common_message">
            {{ common_message }}
        </div>

        <div class="alert alert-danger" v-if="common_error">
            {{ common_error }}
        </div>

        <div>
            На вашу почту отправлено письмо с кодом для активации вашей учётной записи.
            <input
                type="text"
                name="email_code"
                placeholder="Ввод кода из почты"
                class="form-control"
                v-model="email_code"
                :class="{ 'form-control': true, 'is-invalid': error }"
                pattern="\d*"
                maxlength="6"
                required
            >

            <span class="invalid-feedback" role="alert" v-if="error">
            <strong>{{ error }}</strong>
        </span>

            <div>
                <button @click="checkCode" class="btn btn-warning">Следующий шаг</button>
            </div>

            Если вы не получили письмо, можете <a href="" @click.prevent="reSend">отправить заново</a>.
        </div>
    </div>
</template>

<script>
    const CHECK_EMAIL_URL = '/api/user/sign_up/check_email';
    const RESEND_EMAIL_URL = '/api/user/sign_up/resend_email';

    export default {
        data() {
            return {
                email_code: '',
                error: '',

                email: this.userMail,

                common_error: '',
                common_message: '',
            }
        },

        props: ['userMail'],

        methods: {
            checkCode() {
                this.common_error = this.common_message = '';

                axios.post(CHECK_EMAIL_URL, { code: this.email_code })
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

                axios.post(RESEND_EMAIL_URL)
                    .then(res => {
                        if(res.data.success === true) {
                            this.common_message = 'Ссылка успешно отправлена.';
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

</style>
