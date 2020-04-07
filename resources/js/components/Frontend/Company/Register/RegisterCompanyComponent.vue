<template>
    <div class="row registration-part">
        <div class="col questionnaire-outer">
            <div class="questionnaire">
                <div class="alert alert-success" v-if="hasCommonMessage">{{ getCommonMessage }}</div>
                <div class="alert alert-danger" v-if="hasCommonError">{{ getCommonError }}</div>

                <div class="questionnaire-heading">Заполнение информацию о компании</div>
                <div class="questionnaire-subtitle">Размещайте достоверную информацию о компании, добавляйте документы подтверждающие личность, сертификаты, которые подтвердят профессиональность вашей компании.</div>
                <div class="hr-1"></div>
                <div class="questionnaire-title">Рабочие данные </div>

                <form @submit.prevent>
                    <template v-if="step === 0"><main-info-form @next-step="onSecondStep"/></template>
                    <template v-else-if="step === 1"><contacts-form @next-step="onThirdStep"/></template>
                    <template v-else><categories-form :categories-list="categories" @next-step="onFourthStep" /></template>
                </form>
            </div>
        </div>

        <progress-bar-component :progress="progress" :page="step" :pages="pages" />
    </div>
</template>

<script>
    import ProgressBarComponent from "../_partials/_ProgressBarComponent";
    import MainInfoForm from "./_MainInfoForm";
    import ContactsForm from "./_ContactsForm";
    import CategoriesForm from "./_CategoriesForm";

    export default {
        props: ['categories'],

        data() {
            return {
                name: '',
                description: '',
                workers_count: '',
                logo: '',

                coords: '',
                address: '',
                contacts: '',
                schedule: '',

                step: 0,
                selectedCategories: [],
            }
        },

        computed: {
            pages() {
                return ['Информация о компании', 'Контакты', 'Рабочие данные']
            },
            progress() {
                return Math.round((this.step * 0.7 + 1) / this.pages.length * 100)
            },
        },

        methods: {
            onSecondStep(payload) {
                this.name = payload.name;
                this.description = payload.description;
                this.workers_count = payload.workers_count;
                this.logo = payload.logo;

                this.step = 1;
            },
            onThirdStep(payload) {
                this.coords = payload.coords;
                this.address = payload.address;
                this.contacts = payload.contacts;
                this.schedule = payload.schedule;

                this.step = 2;
            },
            onFourthStep(payload) {
                this.selectedCategories = payload;

                axios.post(this.route('api.companies.create'), {
                    address: this.address,
                    contacts: this.contacts,
                    coords: this.coords,
                    description: this.description,
                    logo: this.logo,
                    name: this.name,
                    schedule: this.schedule,
                    workers_count: this.workers_count,
                    categories: this.selectedCategories,
                    city_id: 1,
                })
                    .then(res => {
                        let data = res.data;

                        if (data.success === true) {
                            this.common_message = 'Компания успешно создана.';
                            window.location.href = this.route('company.show', data.data.slug);
                        } else {
                            this.common_error = data.message;
                        }
                    })
                    .catch(err => {
                        let data = err.response.data;

                        this.common_error = data.message;
                        for (let key in data.errors) {
                            this.errors[key] = data.errors[key][0];
                        }
                    })
            },
        },

        components: {ProgressBarComponent, MainInfoForm, CategoriesForm, ContactsForm}
    }
</script>

<style scoped>

</style>
