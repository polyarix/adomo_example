<template>
    <form class="additional-form" @submit.prevent="onSubmit">
        <div class="alert alert-success" v-if="hasCommonMessage">{{ getCommonMessage }}</div>
        <div class="alert alert-danger" v-if="hasCommonError">{{ getCommonError }}</div>

        <div class="additional-form-title" v-if="title">{{ title }}</div>
        <div class="additional-form-title" v-else>Предложения об улучшении сервиса ADOMO.ru</div>

        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" id="name" placeholder="Иван" v-model="name" :class="{ 'is-invalid': isError('name') }">

            <span class="invalid-feedback" role="alert" v-if="isError('name')">
                <strong>{{ getError('name') }}</strong>
            </span>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="email@gmail.com" v-model="email" :class="{ 'is-invalid': isError('email') }">

            <span class="invalid-feedback" role="alert" v-if="isError('email')">
                <strong>{{ getError('email') }}</strong>
            </span>
        </div>

        <div class="form-group">
            <label for="message">Сообщение</label>
            <textarea name="" id="message" placeholder="Kратко опишите ситуацию..." v-model="text" :class="{ 'is-invalid': isError('text') }"></textarea>

            <span class="invalid-feedback" role="alert" v-if="isError('text')">
                <strong>{{ getError('text') }}</strong>
            </span>
        </div>
        <button class="btn btn-big btn-yellow btn-auto">Отправить</button>
    </form>
</template>

<script>
    import { isValidPhone, isValidEmail } from "../../../helpers/User/SignUpHelpers";
    import { CONTACT_TYPE_OFFER, CONTACT_TYPE_REQUEST } from "../Cabinet/_partials/bar_constants";

    export default {
        props: ['title'],

        data() {
            return {
                name: '',
                email: '',
                text: '',
                type: CONTACT_TYPE_OFFER
            }
        },

        methods: {
            async onSubmit() {
                this.clearErrorsBag();

                if(this.name.length === 0) {
                    this.addError('name', 'Не заполнено имя.');
                }

                // email
                if(this.email.length === 0) {
                    this.addError('email', 'Не заполнена почта.');
                }
                if(!isValidEmail(this.email)) {
                    this.addError('email', 'Почта не валидна.');
                }

                if(this.text.length < 10) {
                    this.addError('text', 'Текст сообщение должен быть длиннее 10 символов.');
                }

                if(!this.isValid()) {
                    this.setCommonError('Не заполнены обязательные поля.', 2000);

                    return false;
                }

                this.clearBag();

                const data = {
                    name: this.name,
                    text: this.text,
                    email: this.email,
                    type: this.type,
                };

                if(window.recaptchaEnabled) {
                    await this.$recaptchaLoaded();
                    data[window.recaptchaField] = await this.$recaptcha('contacts');
                }

                axios.post(this.route('api.contacts.store'), data)
                    .then(res => {
                        if(res.data.success === true) {
                            this.setCommonMessage('Ваше предложение успешно зарегистрировано.');
                            this.name = '';
                            this.text = '';
                            this.email = '';
                            return;
                        }

                        this.setCommonError('Ошибка отправки запроса. Повторите ещё раз.')
                    })
                    .catch(err => {
                        let data = err.response.data;

                        this.setCommonError(data.message);
                        for(let key in data.errors) {
                            this.addError(key, data.errors[key][0]);
                        }
                    })
            }
        }
    }
</script>

<style scoped>

</style>
