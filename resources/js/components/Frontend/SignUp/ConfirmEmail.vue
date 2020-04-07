<template>
    <div class="form-group row">
        <div class="alert alert-danger" v-if="common_error">
            {{ common_error }}
        </div>

        <h3>{{ email }}</h3>

        <label for="email_code" class="col-md-4 col-form-label text-md-right">Введите пароль из Email письма</label>

        <div class="col-md-6">
            <input
                id="email_code"
                type="text"
                name="email_code"
                :class="{ 'form-control': true, 'is-invalid': error }"
                v-model="email_code"
                required
            >

            <span class="invalid-feedback" role="alert" v-if="error">
                <strong>{{ error }}</strong>
            </span>

            <button @click="checkCode" class="btn btn-success">Подтвердить</button>

            <a @click.prevent="repeatSending" href="" class="text-success">Отправить СМС еще раз</a>
        </div>
    </div>
</template>

<script>
    const API_CHECK_EMAIL = '/api/user/sign_up/check_email';

    export default {
        props: ['email'],

        data() {
            return {
                email_code: '',
                error: '',

                common_error: ''
            }
        },

        methods: {
            checkCode() {
                axios.post(API_CHECK_EMAIL, { code: this.email_code })
                    .then(res => {
                        if(res.data.success === true) {
                            this.$emit('validate', this.email_code);
                            return;
                        }

                        this.common_error = res.data.error;
                    })
                    .catch(err => {
                        this.common_error = err.message;
                    })
            },

            repeatSending() {
                console.log('repeat..')
                this.$emit('repeat_sending')
            }
        }
    }
</script>

<style scoped>

</style>
