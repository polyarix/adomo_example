<template>
    <div class="personal-content-inner">
        <div class="personal-main-heading">
            <div class="main-title">Основная информация </div>

            <div class="alert alert-success" v-if="hasCommonMessage">
                {{ getCommonMessage }}
            </div>
            <div class="alert alert-danger" v-if="hasCommonError">
                {{ getCommonError }}
            </div>

            <p class="text">Информацию о себе, добавляйте документы подтверждающие личность, сертификаты, которые подтвердят вашу профессиональность.</p>

            <avatar-cropper
                trigger="#pick-avatar"
                :labels="{submit: 'Подтвердить', cancel: 'Отменить'}"
                :upload-url="route('api.user.cabinet.avatar_update')"
                :uploadHeaders="{'X-CSRF-TOKEN': csrfToken}"
                uploadFormName="avatar"
                @uploaded="onUploaded"
            />

            <div class="personal-main-avatar" :data-text="userTypeText">
                <img :src="avatar" alt="" class="avatar" id="pick-avatar">
            </div>
        </div>
        <div class="center-wrap">
            <div class="form-group" v-if="isExecutor">
                <label for="company">Компания/бригада</label>
                <input disabled type="text" id="company" placeholder="Название компании или бригады" v-model="companyName">
            </div>

            <div class="form-group">
                <label for="lastname">Фамилия</label>
                <input disabled type="text" id="lastname" placeholder="Иванов" v-model="lastName">
            </div>

            <div class="form-group">
                <label for="name">Имя</label>
                <input disabled type="text" id="name" placeholder="Иван" v-model="firstName">
            </div>

            <div class="form-group-select">
                <label for="city">Город</label>
                <div class="select">
                    <select name="city" id="city" class="form-control" v-model="city_id">
                        <option value=""></option>
                        <option v-for="city in cities" :value="city.id">
                            {{ city.name }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-group-radio">
                <div class="form-group-name">Выберите пол:</div>
                <div class="radio">
                    <input disabled id="gender-1" name="gender" type="radio" v-model="sex" :value="SEX_MAN">
                    <label class="radio-label" for="gender-1">Мужчина</label>
                </div>
                <div class="radio">
                    <input disabled id="gender-2" name="gender" type="radio" v-model="sex" :value="SEX_WOMAN">
                    <label class="radio-label" for="gender-2">Женщина</label>
                </div>
            </div>

            <div class="form-group input-phone">
                <label for="phone">Контактный телефон</label>
                <input type="text" id="phone" placeholder="+7 ___ ___-__-__" v-model="phoneNumber" disabled>
            </div>

            <div class="form-group-BOD">
                <div class="form-group">
                    <label for="dob">Дата рождения</label>
                    <input disabled type="text" id="dob" placeholder="" class="flatpickr-input" readonly="readonly" v-model="birthDate">
                    <svg class="calendar-icon">
                        <use xlink:href="/images/sprite-inline.svg#calendar-icon"></use>
                    </svg>
                </div>
            </div>

            <div class="form-group-radio" v-if="isExecutor">
                <div class="form-group-name">Вы оформлены как: </div>
                <div class="radio">
                    <input disabled id="legal-1" name="legal" type="radio" v-model="legalType" :value="LEGAL_TYPE_PRIVATE">
                    <label class="radio-label" for="legal-1">Частное  лицо</label>
                </div>
                <div class="radio">
                    <input disabled id="legal-2" name="legal" type="radio" v-model="legalType" :value="LEGAL_TYPE_LEGAL">
                    <label class="radio-label" for="legal-2">Юридическое лицо</label>
                </div>
            </div>

            <div class="form-group-radio" v-if="isExecutor">
                <div class="form-group-name">Вы работаете как: </div>
                <div class="radio">
                    <input disabled id="group-1" name="group" type="radio" v-model="teamType" :value="TYPE_INDIVIDUAL">
                    <label class="radio-label" for="group-1">Частный исполнитель</label>
                </div>
                <div class="radio">
                    <input disabled id="group-2" name="group" type="radio" v-model="teamType" :value="TYPE_BRIGADE">
                    <label class="radio-label" for="group-2">Бригада</label>
                </div>
            </div>

            <districts-component
                v-if="isExecutor"
                title="Рабочие районы"
                :init-districts="initDistricts"
                @changeDistricts="districts = $event"
                :cities="cities"
                :init-city="city_id"
                :key="city_id"
            />

            <div class="form-group" v-if="isBrigade">
                <label for="count">Укажите кол-во человек</label>
                <input type="text" :class="{'is-invalid': isError('brigadeSize')}" id="count" placeholder="От 2 до 30" v-model="brigadeSize">
            </div>

            <div class="form-group">
                <label for="about">О себе {{ isBrigade ? '/Бригаде' : '' }}</label>
                <textarea name="" :class="{'is-invalid': isError('about')}" id="about" placeholder="Делайте упор на самые сильные стороны и постарайтесь заинтересовать работодателя своей личностью" v-model="about"></textarea>
            </div>

            <button class="btn btn-yellow btn-big" @click.prevent="onSubmit">Сохранить изменения</button>
        </div>
    </div>
</template>

<script>
    import AvatarCropper from "vue-avatar-cropper";
    import ChangePhoneComponent from "./ChangePhoneComponent";
    import DistrictsComponent from "../../../../Shared/Advert/DistrictsComponent";

    const TYPE_CUSTOMER = 'customer';
    const TYPE_EXECUTOR = 'executor';

    const TYPE_BRIGADE = 'brigade'; //Бригада
    const TYPE_INDIVIDUAL = 'individual'; //Частный исполнитель

    const LEGAL_TYPE_LEGAL = 'private'; //Частное лицо
    const LEGAL_TYPE_PRIVATE = 'legal'; //Юридическое лицо

    const SEX_MAN = 1;
    const SEX_WOMAN = 0;

    export default {
        props: ['user', 'cities'],

        data() {
            return {
                firstName: this.user.first_name,
                lastName: this.user.last_name,
                city_id: this.user.city_id,
                sex: this.user.sex,
                phoneNumber: this.user.phone,
                userAvatar: this.user.avatar,
                birthDate: this.user.birth_date,
                brigadeSize: this.user.work_data ? this.user.work_data.brigade_size : '',
                about: this.user.work_data ? this.user.work_data.about : this.user.about,
                companyName: this.user.work_data ? this.user.work_data.company_name : '',
                legalType: this.user.work_data ? this.user.work_data.legal_type : '',
                teamType: this.user.work_data ? this.user.work_data.team_type : '',
                districts: this.initDistricts,

                SEX_MAN,
                SEX_WOMAN,
                TYPE_BRIGADE,
                TYPE_INDIVIDUAL,
                LEGAL_TYPE_LEGAL,
                LEGAL_TYPE_PRIVATE,
            }
        },

        methods: {
            onUploaded(resp) {
                if(!resp || !resp.success) {
                    this.setCommonError('Ошибка загрузки аватара', 2000);
                    return;
                }
                this.userAvatar = resp.data.relative_url;
            },
            onSubmit() {
                this.clearErrorsBag();

                if(this.about.length === 0) {
                    this.addError('about', 'Не заполнено поле "О себе/Бригаде".');
                }
                // required fields only for brigade
                if(this.isBrigade) {
                    if(this.brigadeSize.length === 0) {
                        this.addError('brigadeSize', 'Не заполнено поле размера бригады.');
                    }
                }

                if(!this.isValid()) {
                    this.setCommonError('Не заполнены обязательные поля.', 2000);

                    return false;
                }

                this.clearBag();

                axios.put(this.route('api.user.cabinet.main_info.update'), {
                    brigade_size: this.brigadeSize,
                    about: this.about,
                    city: this.city_id,
                    districts: this.districts
                })
                    .then(res => {
                        if(res.data.success === true) {
                            this.setCommonMessage('Информация успешно обновлена');
                            return;
                        }

                        this.setCommonError('Ошибка при обновлении. Повторите ещё раз.')
                    })
                    .catch(err => {
                        let data = err.response.data;

                        this.setCommonError(data.message);
                        for(let key in data.errors) {
                            this.addError(key, data.errors[key][0]);
                        }
                    })
            }
        },

        computed: {
            currentCity() {
                if(!this.city_id) {
                    return [];
                }
                return this.cities.filter(city => city.id === this.city_id)[0];
            },
            initDistricts() {
                if(!this.isExecutor) {
                    return [];
                }
                return this.user.work_data.districts.map(el => el.id)
            },
            avatar() {
                return `/${this.userAvatar}`
            },
            isCustomer() {
                return this.user.type === TYPE_CUSTOMER
            },
            isExecutor() {
                return this.user.type === TYPE_EXECUTOR
            },
            isBrigade() {
                return this.isExecutor && this.teamType === this.TYPE_BRIGADE
            },
            userTypeText() {
                if(this.isCustomer) {
                    return 'Заказчик'
                }
                if(this.isBrigade) {
                    return 'Бригада'
                }

                return 'Исполнитель'
            },
            phoneExpires() {
                return this.user.phone_code_expires
            },
            isPhoneConfirmed() {
                return Boolean(this.user.phone_verified_at)
            }
        },

        components: {
            DistrictsComponent,
            AvatarCropper, ChangePhoneComponent
        }
    }
</script>

<style scoped>
    *:disabled {
        background: silver;
        opacity: .8;
    }
    .radio {
        opacity: .6;
    }
    .select select:disabled {
        background: silver;
    }
    .avatar:hover {
        cursor: pointer;
    }
</style>
