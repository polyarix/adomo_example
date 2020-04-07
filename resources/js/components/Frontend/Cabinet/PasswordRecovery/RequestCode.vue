<template>
    <div class="row login-page-row">
        <div class="col login-page-info">
            <div class="login-page-title">Восстановление пароля</div>
            <div class="login-page-subtitle">После регистрации вы сможете получать задания и зарабатывать на сервисе</div>
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
                <div class="form-title">Восстановление пароля</div>

                <div class="alert alert-danger" v-if="common_error">
                    {{ common_error }}
                </div>
                <div class="alert alert-success" v-if="success_message">
                    {{ success_message }}
                </div>

                <form @submit.prevent="onSubmit">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input :class="{'form-control': true, 'is-invalid': isError('email')}" type="text" id="email" v-model="email">

                        <span class="invalid-feedback" role="alert" v-if="isError('email')">
                            <strong>{{ getError('email') }}</strong>
                        </span>
                    </div>
                    <button class="btn btn-big btn-yellow btn-auto"><span>Отправить ссылку для восстановления</span></button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    const RESET_PASSWORD_URL = '/password/email';

    export default {
        data() {
            return {
                email: '',

                common_error: '',
                success_message: '',
                errors: []
            }
        },

        methods: {
            onSubmit() {
                let errors = {};

                if(this.email.length === 0) {
                    errors['email'] = 'Email пустой.';
                }

                this.errors = errors;
                this.common_error = '';

                if(Object.keys(errors).length > 0) {
                    return false;
                }

                axios.post(RESET_PASSWORD_URL, { email: this.email})
                    .then(res => {

                        if(res.data.success === true) {
                            this.success_message = 'Ссылка для восстановления отправлена на вашу почту.';
                            return;
                        }

                        this.common_error = res.data.error;
                    })
                    .catch(err => {
                        this.common_error = err.message;

                        const response = err.response;

                        if(response.data.message !== undefined) {
                            this.common_error = response.data.message;
                        }

                        if(response.status === 422) {
                            // validation error
                            for(let key in response.data.errors) {
                                this.errors[key] = response.data.errors[key][0]
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
        }
    }
</script>

<style scoped>

</style>
