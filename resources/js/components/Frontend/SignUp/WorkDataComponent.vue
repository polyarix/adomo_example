<template>
    <div class="row registration-part">
        <div class="col questionnaire-outer">
            <div class="questionnaire">
                <div class="alert alert-success" v-if="common_message">
                    {{ common_message }}
                </div>

                <div class="alert alert-danger" v-if="common_error">
                    {{ common_error }}
                </div>

                <div class="questionnaire-heading">Заполнение анкеты</div>
                <div class="questionnaire-subtitle">Размещайте достоверную информацию о себе, добавляйте документы подтверждающие личность, сертификаты, которые подтвердят вашу профессиональность. Это поможет быстрее найти исполнителя/заказчика. </div>
                <div class="hr-1"></div>
                <div class="questionnaire-title">Рабочие данные</div>

                <form @submit.prevent="onSubmit">
                    <div class="questionnaire-inner-container">
                        <div class="form-group">
                            <label for="company">Компания/бригада</label>
                            <input type="text" id="company" placeholder="Название компании или бригады" v-model="company_name" :class="{ 'form-control': true, 'is-invalid': isError('company_name') }">

                            <span class="invalid-feedback" role="alert" v-if="isError('company_name')">
                                <strong>{{ getError('company_name') }}</strong>
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

                                <span class="invalid-feedback" role="alert" v-if="isError('city')">
                                    <strong>{{ getError('city') }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-input-description text offset-top">Укажите город, в котором вы планируете работать и получать рассылку новых заданий.</div>
                    </div>

                    <districts-component
                        title="Рабочие районы (оставьте пустым, если все)"
                        :cities="cities"
                        :init-city="city"
                        :init-districts="initDistricts"
                    />

                    <!-- Тип оформления-->
                    <div class="questionnaire-inner-container">
                        <div class="form-group-radio">
                            <div class="form-group-name">Вы оформлены как: </div>
                            <div class="radio">
                                <input id="legal-1" name="legal" type="radio" v-model="legal_type" value="private">
                                <label class="radio-label" for="legal-1">Частное лицо</label>
                            </div>
                            <div class="radio">
                                <input id="legal-2" name="legal" type="radio" v-model="legal_type" value="legal">
                                <label class="radio-label" for="legal-2">Юридическое лицо</label>
                            </div>
                            <div class="radio">
                                <input id="legal-3" name="legal" type="radio" v-model="legal_type" value="ie">
                                <label class="radio-label" for="legal-3">ИП</label>
                            </div>

                            <span class="invalid-feedback" role="alert" v-if="isError('sex')">
                                <strong>{{ getError('legal_type') }}</strong>
                            </span>
                        </div>
                    </div>

                    <!-- Тип работника-->
                    <div class="questionnaire-inner-container">
                        <div class="form-group-radio">
                            <div class="form-group-name">Вы работаете как: </div>
                            <div class="radio">
                                <input id="group-1" name="group" type="radio" v-model="team_type" value="individual">
                                <label class="radio-label" for="group-1">Частный исполнитель</label>
                            </div>
                            <div class="radio">
                                <input id="group-2" name="group" type="radio" v-model="team_type" value="brigade">
                                <label class="radio-label" for="group-2">Бригада</label>
                            </div>

                            <span class="invalid-feedback" role="alert" v-if="isError('sex')">
                                <strong>{{ getError('team_type') }}</strong>
                            </span>
                        </div>
                    </div>
                    <!-- кол-во человек-->
                    <div class="questionnaire-inner-container" v-if="isBrigade">
                        <div class="form-group">
                            <label for="count">Укажите кол-во человек</label>
                            <input type="text" id="count" v-model="brigade_size" placeholder="От 2 до 30" :class="{'is-invalid': isError('brigade_size')}">

                            <span class="invalid-feedback" role="alert" v-if="isError('brigade_size')">
                                <strong>{{ getError('brigade_size') }}</strong>
                            </span>
                        </div>
                    </div>

                    <!-- О себе-->
                    <div class="questionnaire-inner-container">
                        <div class="form-group">
                            <label for="about">О себе/Бригаде</label>
                            <textarea name="" id="about" placeholder="Делайте упор на самые сильные стороны и постарайтесь заинтересовать работодателя своей личностью" v-model="about" :class="{'is-invalid': isError('about')}"></textarea>

                            <span class="invalid-feedback" role="alert" v-if="isError('about')">
                                <strong>{{ getError('about') }}</strong>
                            </span>
                        </div>
                        <div class="form-input-description text offset-top">Размещайте достоверную информацию о себе, добавляйте документы подтверждающие личность, сертификаты, которые подтвердят вашу профессиональность. Это поможет быстрее найти исполнителя/заказчика. </div>
                    </div>

                    <!-- submit-->
                    <button class="btn btn-large btn-yellow" @click.prevent="onSubmit"> <span>Следующий шаг </span></button>
                </form>
            </div>
        </div>

        <right-bar-component :progress="70" :type="user.type" :page="constants.WORK_DATA_PAGE" />
    </div>
</template>

<script>
    import RightBarComponent from "../Cabinet/_partials/RightBarComponent";
    import * as BarConstants from './../Cabinet/_partials/bar_constants';
    import DistrictsComponent from "../../Shared/Advert/DistrictsComponent";

    const API_SAVE_URL = '/api/user/sign_up/work_data';
    const TYPE_BRIGADE = 'brigade'; //Бригада

    export default {
        props: ['user', 'workData', 'cities'],

        data() {
            return {
                city: this.workData         ? this.workData.main_city_id    : 1,
                legal_type: this.workData   ? this.workData.legal_type      : '',
                team_type: this.workData    ? this.workData.team_type       : '',
                brigade_size: this.workData ? this.workData.brigade_size    : '',
                about: this.workData        ? this.workData.about           : '',
                company_name: this.workData ? this.workData.company_name    : '',
                districts: this.workData ? this.initDisctricts    : '',

                common_error: '',
                common_message: '',
                errors: {},
            }
        },

        computed: {
            initDistricts() {
                if(!this.workData) {
                    return [];
                }
                return this.workData.districts.map(el => el.id)
            },
            constants() {
                return BarConstants
            },
            isBrigade() {
                return this.team_type === TYPE_BRIGADE
            },
        },

        mounted() {

        },

        methods: {
            onSubmit() {
                let errors = {};
                if(!this.legal_type || this.legal_type.length < 2) {
                    errors['legal_type'] = 'Укажите тип оформления.';
                }
                if(!this.team_type || this.team_type.length < 2) {
                    errors['team_type'] = 'Укажите тип команды.';
                }
                if(!this.company_name || this.company_name.length === 0) {
                    errors['company_name'] = 'Заполните название компании/бригады.';
                }

                this.errors = errors;

                if(Object.keys(errors).length > 0) {
                    return false;
                }

                this.common_message = this.common_error = '';

                axios.post(API_SAVE_URL, {
                    legal_type: this.legal_type,
                    team_type: this.team_type,
                    brigade_size: this.brigade_size,
                    about: this.about,
                    city_id: this.city,
                    company_name: this.company_name,
                    districts: this.districts
                })
                    .then(res => {
                        let data = res.data;

                        if(data.success === true) {
                            this.common_message = 'Данные успешно обновлены.';

                            window.location.href = '/sign-up/categories';
                        } else {
                            this.common_error = data.message;
                        }
                    })
                    .catch(err => {
                        let data = err.response.data;

                        this.common_error = data.message;
                        for(let key in data.errors) {
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

        components: {DistrictsComponent, RightBarComponent },
    }
</script>

<style scoped>
    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>
