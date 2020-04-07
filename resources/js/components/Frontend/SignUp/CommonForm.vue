<template>
    <div class="row registration-part">
        <div class="col questionnaire-outer">
            <div class="questionnaire">
                <div class="questionnaire-heading">Заполнение анкеты</div>

                <div class="alert alert-danger" v-if="common_error">
                    {{ common_error }}
                </div>

                <div class="questionnaire-subtitle">Регистрация подрядчика (мастера, бригады или компании) После регистрации вы сможете получать задания и зарабатывать на сервисе Adomo.ru</div>
                <div class="hr-1"></div>
                <div class="questionnaire-title">Личные данные  </div>
                <div class="questionnaire-subtitle">В качестве фото профиля разрешено использовать только реальную фотографию. Лицо исполнителя должно быть отчетливо видно и занимать не менее 50% фотографии.</div>

                <form @submit.prevent="onSubmit">
                    <!-- Загрузить фотографию-->
                    <div class="questionnaire-inner-container">
                        <div class="photo-input">
                            <div class="photo-input-avatar">
                                <img v-if="userAvatar" class="image_upload_preview avatar" :src="'/storage/' + userAvatar">
                                <div class="photo-input-avatar" v-else>
                                    <img src="/images/userpic.svg" class="image_upload_preview">
                                </div>
                            </div>

                            <avatar-cropper
                                trigger="#pick-avatar"
                                :labels="{submit: 'Подтвердить', cancel: 'Отменить'}"
                                :upload-url="avatarUploadUrl"
                                :uploadHeaders="{'X-CSRF-TOKEN': csrfToken}"

                                uploadFormName="avatar"
                                @uploaded="onUploaded"
                            />

                            <div class="photo-input-control">
                                <div class="text">В качестве фото профиля разрешено использовать только реальную фотографию</div>
                                <label class="btn btn-small btn-white" id="pick-avatar">
                                    Загрузить фотографию
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Фамилия-->
                    <div class="questionnaire-inner-container">
                        <div class="form-group">
                            <label for="lastname">Фамилия</label>
                            <input
                                type="text"
                                id="lastname"
                                placeholder="Иванов"
                                name="last_name"
                                :class="{ 'form-control': true, 'is-invalid': isError('last_name') }"
                                v-model="last_name">

                            <span class="invalid-feedback" role="alert" v-if="isError('last_name')">
                                <strong>{{ getError('last_name') }}</strong>
                            </span>
                        </div>
                    </div>

                    <!-- Имя-->
                    <div class="questionnaire-inner-container">
                        <div class="form-group">
                            <label for="first_name">Имя</label>

                            <input
                                type="text"
                                id="first_name"
                                placeholder="Иван"
                                name="first_name"
                                :class="{ 'form-control': true, 'is-invalid': isError('first_name') }"
                                v-model="first_name"
                                required
                            >

                            <span class="invalid-feedback" role="alert" v-if="isError('first_name')">
                                <strong>{{ getError('first_name') }}</strong>
                            </span>
                        </div>
                    </div>

                    <!-- Город-->
                    <div class="questionnaire-inner-container">
                        <div class="form-group-select">
                            <label for="city">Город</label>
                            <div class="select">
                                <select
                                    name="city"
                                    id="city"
                                    class="form-control"
                                    v-model="city"
                                >
                                    <option v-for="city in cities" :value="city.id">
                                        {{ city.name }}
                                    </option>
                                </select>
                            </div>

                            <span class="invalid-feedback" role="alert" v-if="isError('city')">
                                <strong>{{ getError('city') }}</strong>
                            </span>
                        </div>
                        <div class="form-input-description text offset-top">Укажите город, в котором вы планируете работать и получать рассылку новых заданий.</div>
                    </div>

                    <!-- пол-->
                    <div class="questionnaire-inner-container">
                        <div class="form-group-radio">
                            <div class="form-group-name">Выберите пол:</div>
                            <div class="radio">
                                <input id="gender-1" name="gender" type="radio" v-model="sex" value="1">
                                <label class="radio-label" for="gender-1">Мужчина</label>
                            </div>
                            <div class="radio">
                                <input id="gender-2" name="gender" type="radio" v-model="sex" value="2">
                                <label class="radio-label" for="gender-2">Женщина</label>
                            </div>

                            <span class="invalid-feedback" role="alert" v-if="isError('sex')">
                                <strong>{{ getError('sex') }}</strong>
                            </span>
                        </div>
                    </div>

                    <!-- телефон-->
                    <confirm-phone
                        :phone="user.phone"
                        @validate="onPhoneValidated"
                        @confirmed="onConfirmed"
                        :sms-date="user.phone_code_expires"
                        :is-confirmed="isUserPhoneConfirmed"
                    />

                    <!-- Дата рождения-->
                    <div class="questionnaire-inner-container">
                        <div class="form-group-BOD">
                            <div class="form-group">
                                <label for="dob">Дата рождения</label>
                                <input
                                    type="text"
                                    id="dob"
                                    placeholder=""
                                    class="flatpickr-input"
                                    readonly="readonly"
                                    v-model="birth_date"
                                    ref="birthdate"
                                    :class="{'is-invalid': isError('birth_date'), 'flatpickr-input': true}"
                                >
                                <svg class="calendar-icon">
                                    <use xlink:href="/images/sprite-inline.svg#calendar-icon"></use>
                                </svg>
                            </div>
                        </div>

                        <span class="invalid-feedback" role="alert" v-if="isError('birth_date')">
                            <strong>{{ getError('birth_date') }}</strong>
                        </span>
                    </div>

                    <!-- О себе-->
                    <div class="questionnaire-inner-container">
                        <div class="form-group">
                            <label for="about">О себе</label>
                            <input
                                type="text"
                                id="about"
                                name="info"
                                placeholder=""
                                :class="{'form-control': true, 'is-invalid': isError('about')}"
                                v-model="about"
                            >

                            <span class="invalid-feedback" role="alert" v-if="isError('about')">
                                <strong>{{ getError('about') }}</strong>
                            </span>
                        </div>
                        <div class="form-input-description text offset-top">Размещайте достоверную информацию о себе, добавляйте документы подтверждающие личность, сертификаты, которые подтвердят вашу профессиональность. Это поможет быстрее найти исполнителя/заказчика. </div>
                    </div>

                    <!-- Пароль-->
                    <div class="questionnaire-inner-container">
                        <div class="form-group">
                            <label for="pass">Пароль</label>
                            <input
                                type="password"
                                id="pass"
                                placeholder="Пароль (не мение 6 знаков)"
                                v-model="password"
                                name="password"
                                :class="{'form-control': true, 'is-invalid': isError('password')}"
                            >

                            <div class="btn-toggle-pass"></div>

                            <span class="invalid-feedback" role="alert" v-if="isError('password')">
                                <strong>{{ getError('password') }}</strong>
                            </span>
                        </div>
                    </div>

                    <!-- Пароль повторно-->
                    <div class="questionnaire-inner-container">
                        <div class="form-group">
                            <label for="pass2">Пароль повторно</label>
                            <input
                                type="password"
                                id="pass2"
                                name="password_confirmation"
                                placeholder="Пароль повторно"
                                v-model="password_confirmation"
                                :class="{'form-control': true, 'is-invalid': isError('password_confirmation')}"
                            >

                            <div class="btn-toggle-pass"></div>

                            <span class="invalid-feedback" role="alert" v-if="isError('password_confirmation')">
                                <strong>{{ getError('password_confirmation') }}</strong>
                            </span>
                        </div>
                    </div>

                    <!-- Чекбокс-->
                    <div class="questionnaire-inner-container">
                        <div class="form-check">
                            <label for="agree">Я соглашаюсь с правилами использования сервиса, а также с передачей и обработкой моих данных в adomo.ru <br> Я подтверждаю, что все данные заполнены мною верно и несу ответственность за размещение информации на сервисе.
                                <input
                                    type="checkbox"
                                    id="agree"
                                    required="required"
                                    v-model="accept_rules" :class="{'form-control': true, 'is-invalid': isError('accept_rules')}"
                                ><span class="checkmark"></span>
                            </label>

                            <span class="invalid-feedback" role="alert" v-if="isError('accept_rules')">
                                <strong>{{ getError('accept_rules') }}</strong>
                            </span>
                        </div>
                    </div>
                    <!-- submit-->
                    <button class="btn btn-large btn-yellow" @click.prevent="onSubmit">
                        <span v-if="isCustomer">Завершить регистрацию</span>
                        <span v-else="isCustomer">Следующий шаг</span>
                    </button>
                </form>
            </div>
        </div>

        <right-bar-component :progress="isCustomer ? 80 : 60" :type="user.type" :page="constants.PERSON_DATA_PAGE" />
    </div>
</template>

<script>
    import AvatarCropper from "vue-avatar-cropper";
    import DatePicker from 'vue2-datepicker';
    import ConfirmPhone from './ConfirmPhone';
    import {isValidEmail, isValidPhone, isValidDate} from "../../../helpers/User/SignUpHelpers";
    import RightBarComponent from "../Cabinet/_partials/RightBarComponent";
    import * as BarConstants from './../Cabinet/_partials/bar_constants';

    const API_SAVE_URL = '/api/user/sign_up/save';

    export default {
        props: ['user', 'avatarUploadUrl', 'cities'],

        data() {
            return {
                userAvatar: this.user.photo,

                first_name: this.user.first_name,
                last_name: this.user.last_name,
                city: 1,
                phone: this.user.phone,
                sex: '',
                birth_date: '',
                about: '',

                password: '',
                password_confirmation: '',

                accept_rules: false,

                common_error: '',
                errors: {},
            }
        },

        computed: {
            isUserPhoneConfirmed() {
                return this.user.phone_verified_at && this.user.phone_verified_at.length > 0
            },
            csrfToken() {
                return window.axios.defaults.headers.common['X-CSRF-TOKEN'];
            },
            constants() {
                return BarConstants
            },
            isCustomer() {
                return this.user.type === BarConstants.TYPE_CUSTOMER
            }
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

            $("#dob").flatpickr({
                locale: "ru",
                dateFormat:"d-m-Y",
                disable: [
                    function(date) {
                        return date > new Date();
                    }
                ],
            });
        },

        methods: {
            onUploaded(resp) {
                try  {
                    this.userAvatar = resp.data.relative_url;
                } catch(e) {
                    this.setCommonError('Ошибка загрузки аватара.')
                }
            },
            onPhoneValidated(phone) {
                //this.phone = phone;
            },
            onConfirmed(phone) {
                this.phone = phone;
            },

            onSubmit() {
                let errors = {};

                if(this.first_name.length < 2) {
                    errors['first_name'] = 'Имя должно быть длиннее 2 сиволов.';
                }
                if(this.last_name.length < 2) {
                    errors['last_name'] = 'Фамилия должна быть длиннее 2 сиволов.';
                }
                if(!this.city) {
                    errors['city'] = 'Укажите свой город.';
                }
                if(this.sex.length === 0) {
                    errors['sex'] = 'Укажите свой пол.';
                }
                //if(!isValidPhone(this.phone)) {
                if(!this.phone || this.phone.length === 0) {
                    errors['phone'] = 'Телефон не валиден.';
                }
                if(this.birth_date.length === 0 || !isValidDate(this.birth_date)) {
                    errors['birth_date'] = 'Укажите дату рождения.';
                }
                if(!this.about) {
                    errors['about'] = 'Укажите информацию о себе.';
                }
                if(this.password.length < 6) {
                    errors['password'] = 'Пароль должен быть длиннее 5 символов.';
                }
                if(this.password !== this.password_confirmation) {
                    errors['password_confirmation'] = 'Пароли не совпадают.';
                }
                if(!this.accept_rules) {
                    errors['accept_rules'] = 'Вы не согласились с правилами.';
                }

                this.errors = errors;

                if(Object.keys(errors).length > 0) {
                    return false;
                }

                axios.post(API_SAVE_URL, {
                    about: this.about,
                    first_name: this.first_name,
                    last_name: this.last_name,
                    birth_date: this.birth_date,
                    city: this.city,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    company_name: this.company_name,
                    sex: this.sex,
                })
                    .then(res => {
                        let data = res.data;

                        console.log(data);

                        if(data.success === true) {
                            if(this.isCustomer) {
                                window.location.href = '/home';
                                return;
                            }

                            window.location.href = '/sign-up/work-data';
                        } else {
                            this.common_error = data.message;
                        }
                    })
                    .catch(err => {
                        console.log(err.response, 'errr');

                        this.common_error = err.message;

                        return;

                        let data = err.response.data;

                        this.common_error = data.message;
                        for(let key in data.errors) {
                            if(key === 'phone_number') {
                                this.errors['phone_number'] = data.errors[key][0];
                                continue;
                            }

                            this.errors[key] = data.errors[key][0];
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

        components: { AvatarCropper, DatePicker, ConfirmPhone, RightBarComponent },
    }
</script>

<style scoped>
    .avatar {
        width: 100px;
    }
    .is-invalid[name="password"], .is-invalid[name="password_confirmation"] {
        background-position: center right calc(0.375em + 2.1875rem);
    }
</style>
