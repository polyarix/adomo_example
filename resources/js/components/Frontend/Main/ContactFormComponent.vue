<template>
    <form class="main-form" @submit.prevent="onSubmit">
        <div class="alert alert-success" v-if="hasCommonMessage">{{ getCommonMessage }}</div>
        <div class="alert alert-danger" v-if="hasCommonError">{{ getCommonError }}</div>

        <p v-if="description">{{ description }}</p>

        <ul class="main-form-list">
            <li><span>Электронная почта</span><a :href="'mailto:' + adminEmail">{{ adminEmail }}</a></li>
            <li><span>Телефон</span><a :href="'tel:+' + sanitizedPhone">{{ adminPhone }}</a></li>
        </ul>

        <div class="form-group">
            <label for="mainname">Имя</label>
            <input type="text" id="mainname" placeholder="Иван" v-model="name" :class="{ 'is-invalid': isError('name') }">

            <span class="invalid-feedback" role="alert" v-if="isError('name')">
                <strong>{{ getError('name') }}</strong>
            </span>
        </div>

        <div class="main-form-row">
            <div class="form-group input-phone">
                <label for="phone">Телефон</label>
                <input ref="phone" type="text" id="phone" placeholder="+7 ___ ___-__-__" v-model="phone" :class="{ 'is-invalid': isError('phone') }">

                <span class="invalid-feedback" role="alert" v-if="isError('phone')">
                    <strong>{{ getError('phone') }}</strong>
                </span>
            </div>

            <div class="form-group">
                <label for="mainemail">Email</label>
                <input type="email" id="mainemail" placeholder="email@gmail.com" v-model="email" :class="{ 'is-invalid': isError('email') }">

                <span class="invalid-feedback" role="alert" v-if="isError('email')">
                    <strong>{{ getError('email') }}</strong>
                </span>
            </div>
        </div>

        <div class="form-group">
            <label for="mainmessage">Сообщение</label>
            <textarea name="" id="mainmessage" placeholder="Kратко опишите ситуацию..." v-model="text" :class="{ 'is-invalid': isError('text') }"></textarea>

            <span class="invalid-feedback" role="alert" v-if="isError('text')">
                <strong>{{ getError('text') }}</strong>
            </span>
        </div>
        <button class="btn btn-big btn-yellow">Отправить</button>
    </form>
</template>

<script>
    import { isValidPhone, isValidEmail } from "../../../helpers/User/SignUpHelpers";
    import { CONTACT_TYPE_OFFER, CONTACT_TYPE_REQUEST } from "../Cabinet/_partials/bar_constants";

    export default {
        props: ['adminEmail', 'adminPhone', 'description'],

        data() {
            return {
                name: '',
                phone: '',
                email: '',
                text: '',
                type: CONTACT_TYPE_REQUEST
            }
        },

        computed: {
            sanitizedPhone() {
                return this.adminPhone.replace(/([^0-9]*)/, '')
            }
        },

        mounted() {
            $(this.$refs.phone).mask('+0 (000) 000 00 00', {placeholder: "+_ (___) ___ __ __"});
        },

        methods: {
            async onSubmit() {
                this.clearErrorsBag();

                if(this.name.length === 0) {
                    this.addError('name', 'Не заполнено имя.');
                }

                // phone
                if(this.phone.length === 0) {
                    this.addError('phone', 'Не заполнен телефон.');
                }
                if(this.phone.length !== 18) {
                    this.addError('phone', 'Телефон не валиден.');
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
                    phone: this.phone,
                    text: this.text,
                    email: this.email,
                    type: this.type
                };
                if(window.recaptchaEnabled) {
                    await this.$recaptchaLoaded();
                    data[window.recaptchaField] = await this.$recaptcha('contacts');
                }

                axios.post(this.route('api.contacts.store'), data)
                    .then(res => {
                        if(res.data.success === true) {
                            this.setCommonMessage('Ваше обращение успешно зарегистрировано.');
                            this.name = '';
                            this.phone = '';
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
