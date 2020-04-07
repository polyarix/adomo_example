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
                        <label for="password">Пароль</label>
                        <input
                            :class="{'form-control': true, 'is-invalid': isError('password')}"
                            type="password"
                            name="password"
                            id="password"
                            v-model="password"
                        >

                        <span class="invalid-feedback" role="alert" v-if="isError('password')">
                            <strong>{{ getError('password') }}</strong>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Пароль повторно</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            :class="{'form-control': true, 'is-invalid': isError('password_confirmation')}"
                            v-model="password_confirmation"
                        >

                        <span class="invalid-feedback" role="alert" v-if="isError('password_confirmation')">
                            <strong>{{ getError('password_confirmation') }}</strong>
                        </span>
                    </div>

                    <button class="btn btn-big btn-yellow btn-auto"><span>Отправить ссылку для восстановления</span></button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    const RESET_PASSWORD_URL = '/password/reset';

    export default {
        props: ['token', 'email'],

        data() {
            return {
                password: '',
                password_confirmation: '',

                common_error: '',
                success_message: '',
                errors: []
            }
        },

        methods: {
            onSubmit() {
                let errors = {};

                if(this.password.length === 0) {
                    errors['password'] = 'Пароль пустой.';
                }
                if(this.password.length < 8) {
                    errors['password'] = 'Пароль должен быть длиннее 8 символов.';
                }
                if(this.password !== this.password_confirmation) {
                    errors['password_confirmation'] = 'Пароли не совпадают';
                }

                this.errors = errors;
                this.common_error = '';

                if(Object.keys(errors).length > 0) {
                    return false;
                }

                axios.post(RESET_PASSWORD_URL, {
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    token: this.token,
                    email: this.email
                })
                    .then(res => {
                        if(res.data.success === true) {
                            this.success_message = 'Пароль успешно изменён.';

                            setTimeout(() => {window.location.href = '/home';}, 1000);
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
