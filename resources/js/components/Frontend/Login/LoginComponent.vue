<template>
    <div class="row login-page-row">
        <div class="col login-page-info">
            <div class="login-page-title">Вход в систему</div>

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
                <div class="form-title">Войти </div>

                <div class="alert alert-danger" v-if="common_error">{{ common_error }}</div>

                <form @submit.prevent="onSubmit">
                    <div class="form-group">
                        <label for="login">Логин</label>
                        <input :class="{'form-control': true, 'is-invalid': isError('email')}" type="text" id="login" v-model="email">

                        <span class="invalid-feedback" role="alert" v-if="isError('email')">
                            <strong>{{ getError('email') }}</strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input :class="{'form-control': true, 'is-invalid': isError('password')}" type="password" id="password" v-model="password">

                        <span class="invalid-feedback" role="alert" v-if="isError('password')">
                            <strong>{{ getError('password') }}</strong>
                        </span>

                        <div class="btn-toggle-pass"></div>
                    </div>
                    <button class="btn btn-big btn-yellow btn-auto" @click.prevent="onSubmit"><span>Войти</span></button>
                </form>
                <div class="form-social-info">Вход с помощью соцсетей:</div>
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

                <div class="form-account-ask">Забыли пароль? <a href="/password/reset">Восстановить пароль</a></div>
            </div>
        </div>
    </div>
</template>

<script>
    const API_LOGIN_URL = '/api/user/login';

    export default {
        props: ['facebookUrl', 'vkUrl', 'odnoklassnikiUrl'],

        data() {
            return {
                email: '',
                password: '',

                common_error: '',
                success_message: '',
                errors: []
            }
        },

        methods: {
            getLoginUrl(field) {
                return `${this[field]}`
            },
            async onSubmit() {
                let errors = {};

                if(this.email.length === 0) {
                    errors['email'] = 'Логин пустой.';
                }
                if(this.password.length === 0) {
                    errors['password'] = 'Заполните пароль.';
                }

                let data = { email: this.email, password: this.password, remember: true };
                if(window.recaptchaEnabled) {
                    await this.$recaptchaLoaded();
                    data[window.recaptchaField] = await this.$recaptcha('login');
                }

                this.errors = errors;
                this.common_error = '';

                if(Object.keys(errors).length > 0) {
                    return false;
                }

                axios.post(API_LOGIN_URL, data)
                    .then(res => {
                        if(res.data.success === true) {
                            window.location.href = res.data.data.url;
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

                                if(key === window.recaptchaField) {
                                    this.common_error = 'Вы похожи на бота. Обновите страницу и попробуйте ещё раз.'
                                }
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

        mounted() {
            $(".btn-toggle-pass").on("click",function(){
                var this_input = $(this).parent().find("input");
                if(this_input.attr("type")=="password"){
                    this_input.attr("type","text");
                }else{
                    this_input.attr("type","password");
                }
                $(this).toggleClass("show-pass");
            });
        },

        components: {
            // ConfirmEmail, ConfirmPhone
        }
    }
</script>

<style scoped>

</style>
