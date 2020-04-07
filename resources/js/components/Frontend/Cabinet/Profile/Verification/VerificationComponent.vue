<template>
    <div class="personal-content-inner lk-verification">
        <div class="main-title">Данные верификации</div>

        <div class="alert alert-success" v-if="hasCommonMessage">{{ getCommonMessage }}</div>
        <div class="alert alert-danger" v-if="hasCommonError">{{ getCommonError }}</div>

        <div class="text">Добавляйте документы подтверждающие личность, сертификаты,<br> которые подтвердят вашу профессиональность.</div>
        <form @submit.prevent="onSubmit">
            <div class="text">Фотография лица и первой страницы паспорта</div>
            <passport-component @remove="onRemove" :file="passport" />
            <div class="hr-1"></div>

            <!-- Серия номер паспорта-->
            <div class="questionnaire-inner-container">
                <div class="form-group">
                    <label for="passport">Серия номер паспорта</label>
                    <input :class="{ 'is-invalid': isError('passport_series') }" type="text" id="passport" placeholder="Серия номер паспорта" v-model="passport_series" maxlength="10">

                    <span class="invalid-feedback" role="alert" v-if="isError('passport_series')">
                        <strong>{{ getError('passport_series') }}</strong>
                    </span>
                </div>
                <div class="form-input-description text offset-top">Информация в этом блоке является строго конфиденциальной.</div>
            </div>

            <!-- Прописка-->
            <div class="questionnaire-inner-container">
                <div class="form-group">
                    <label for="registration">Прописка</label>
                    <input :class="{ 'is-invalid': isError('registration') }" type="text" id="registration" placeholder="Адрес прописки" v-model="registration">

                    <span class="invalid-feedback" role="alert" v-if="isError('registration')">
                        <strong>{{ getError('registration') }}</strong>
                    </span>
                </div>
                <div class="form-input-description text offset-top">Город, улица, номер дома, номер квартиры.</div>
            </div>

            <!-- Судимость-->
            <div class="questionnaire-inner-container">
                <div class="form-group-radio" :class="{ 'is-invalid': isError('criminal_record') }">
                    <div class="form-group-name">Судимость</div>
                    <div class="radio">
                        <input id="prisoned-1" name="prisoned" type="radio" v-model="criminal_record" :value="true">
                        <label class="radio-label" for="prisoned-1">Да</label>
                    </div>
                    <div class="radio">
                        <input id="prisoned-2" name="prisoned" type="radio" :value="false" v-model="criminal_record">
                        <label class="radio-label" for="prisoned-2">Нет</label>
                    </div>

                    <span class="invalid-feedback" role="alert" v-if="isError('criminal_record')">
                        <strong>{{ getError('criminal_record') }}</strong>
                    </span>
                </div>
            </div>
            <div class="text">Существенный момент при получении <br>новых работ и это + к рейтингу</div>
            <!-- mixin vux-uploader -->
            <docs-component :uploaded="userDocuments" @remove="onRemove" />
            <!-- / mixin vux-uploader -->

            <!-- Для юридических лиц-->
            <div class="headline">Для юридических лиц</div>
            <div class="text">Если вы работаете как юр лицо пожалуйста загрузите <br>свидетельство о регистрации или подтверждающие документы</div>
            <!-- mixin vux-uploader -->
            <juristic-component :uploaded="juristic" @remove="onRemove" />
            <!-- / mixin vux-uploader -->

            <!-- Сертификаты-->
            <div class="headline">Сертификаты</div>
            <!-- mixin vux-uploader -->
            <certificates-component :uploaded="certificates" @remove="onRemove" />
            <!-- / mixin vux-uploader -->

            <button class="btn btn-yellow btn-big" v-if="dataWasChanged">Сохранить данные</button>
        </form>
    </div>
</template>

<script>
    import Uploader from "../../../../../helpers/Common/Uploader/Uploader";
    import {TYPE_PASSPORT, TYPE_CERTIFICATE, TYPE_DOCUMENT, TYPE_JURISTIC} from "../../_partials/bar_constants";
    import PassportComponent from "./Partials/PassportComponent";
    import DocsComponent from "./Partials/DocsComponent";
    import CertificatesComponent from "./Partials/CertificatesComponent";
    import JuristicComponent from "./Partials/JuristicComponent";

    export default {
        props: ['documents', 'user'],

        data() {
            return {
                passport_series: this.user.passport_series,
                registration: this.user.registration, // прописка
                criminal_record: this.user.criminal_record, // судимость
                dataWasChanged: false,

                TYPE_PASSPORT, TYPE_DOCUMENT, TYPE_CERTIFICATE
            }
        },

        computed: {
            passport() {
                let documents = this.documents.filter(doc => {
                    doc.url = this.route('doc', doc.id).url();

                    return doc.type === TYPE_PASSPORT
                });

                return documents.length > 0 ? documents.shift() : [];
            },
            userDocuments() {
                let documents = this.documents.filter(doc => {
                    doc.url = this.route('doc', doc.id).url();

                    return doc.type === TYPE_DOCUMENT
                });

                return documents.length > 0 ? documents : [];
            },
            certificates() {
                let documents = this.documents.filter(doc => {
                    doc.url = this.route('doc', doc.id).url();

                    return doc.type === TYPE_CERTIFICATE
                });

                return documents.length > 0 ? documents : [];
            },
            juristic() {
                let documents = this.documents.filter(doc => {
                    doc.url = this.route('doc', doc.id).url();

                    return doc.type === TYPE_JURISTIC
                });

                return documents.length > 0 ? documents : [];
            },
        },

        methods: {
            onSubmit() {
                this.clearErrorsBag();

                if(this.passport_series.length === 0) {
                    this.addError('passport_series', 'Не заполнено поле Серия/номер пасспорта.');
                }
                if(this.registration.length === 0) {
                    this.addError('registration', 'Не заполнена прописка.');
                }
                if(this.criminal_record === null || this.criminal_record === undefined) {
                    this.addError('criminal_record', 'Не заполнено поле "Судимость".');
                }

                if(!this.isValid()) {
                    this.setCommonError('Не заполнены обязательные поля.', 2000);
                    return false;
                }

                this.clearBag();

                axios.put(this.route('api.user.cabinet.verification.update'), {
                    passport_series: this.passport_series,
                    registration: this.registration,
                    criminal_record: this.criminal_record
                })
                    .then(res => {
                        if(res.data.success === true) {
                            // success
                            this.setCommonMessage('Информация успешно обновлена.');
                            return;
                        }

                        this.setCommonError('Ошибка при обновлении данных услуги. Повторите ещё раз.')
                    })
                    .catch(err => {
                        let data = err.response.data;

                        this.setCommonError(data.message);
                        for(let key in data.errors) {
                            this.addError(key, data.errors[key][0]);
                        }
                    })
            },

            onRemove(id) {
                axios.delete(this.route('api.user.cabinet.verification.file.delete'), {data: {id}})
                    .then(res => {
                        const data = res.data;
                        if(data.success === true) {
                            console.log('success upload');
                            console.log(res.data)
                        } else {
                            this.setCommonError(data.error)
                        }
                    })
                    .catch(e => {
                        console.log(e)
                    })
            }
        },

        watch: {
            passport_series() {
                this.dataWasChanged = true;
            },
            registration() {
                this.dataWasChanged = true;
            },
            criminal_record() {
                this.dataWasChanged = true;
            }
        },

        components: {
            JuristicComponent,
            CertificatesComponent,
            DocsComponent,
            PassportComponent,
            Uploader
        }
    }
</script>

<style scoped>

</style>
