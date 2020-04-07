<template>
    <div class="personal-content-inner lk-services">
        <div class="main-title">Услуги</div>

        <div class="alert alert-danger" v-if="hasCommonError">
            {{ getCommonError }}
        </div>

        <div class="text">Вы можете приобрести премиум доступ и выбирать неограниченное количество специализаций. <br> Ваши объявления будут отображаться в категориях услуг.</div>

        <a class="btn-add-new-service btn btn-big btn-yellow btn-auto" :href="route('cabinet.services.create')">
            <div class="icon" style="background-image:url(/images/plus-icon.svg)"></div>
            <span>Добавить новую услугу</span>
        </a>

        <div class="headline">Ваши услуги</div>

        <div class="services-filter">
            <filter-component :categories="listFilters" @categoryChange="onCategoryChange" />
        </div>
        <div class="services-container">
            <service-item :service="service" v-for="(service, index) in services" :key="service.id" @removed="onRemove(index)" />

            <div class="filter-loader" v-if="loading"><img class="loader" src="/images/ajax-loader.gif" alt=""></div>
        </div>
    </div>
</template>

<script>
    import FilterComponent from "./Filter";
    import ServiceItem from "./ServiceItem";
    import {mapGetters, mapMutations} from "vuex";

    export default {
        props: ['filters'],

        data() {
            return {
                category: null,
                loading: true,

                listFilters: this.filters,

                services: [],
            }
        },

        computed: {
            ...mapGetters('service', ['isMainPageActive', 'isSpecificFilterActive']),
        },

        methods: {
            ...mapMutations('service', ['setMainPageActive']),

            removeActiveFilter() {
                let filter = this.listFilters.filter(category => category.id === this.category)[0];

                this.listFilters.splice(this.listFilters.indexOf(filter), 1);
            },
            onCategoryChange(id) {
                this.category = id;
                this.fetchData();
            },
            onRemove(index) {
                this.services.splice(index, 1);

                if(this.services.length === 0 && this.isSpecificFilterActive) {
                    this.removeActiveFilter();
                    this.setMainPageActive();

                    this.category = null;
                    this.fetchData();
                }
            },
            fetchData() {
                this.loading = true;
                this.services = [];

                axios.get(this.route('api.user.cabinet.services.index', { category: this.category }))
                    .then(res => {
                        if(res.data.success) {
                            this.services = res.data.data;
                            return;
                        }

                        this.setCommonError('Что-то пошло не так. Повторите запрос.', 2000)
                    })
                    .catch(err => {
                        this.setCommonError('Произошла какая-то ошибка.');
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            }
        },

        created() {
            this.fetchData()
        },

        components: {
            ServiceItem,
            FilterComponent
        }
    }
</script>

<style scoped>
    .loader {
        margin: 0 auto;
    }
</style>
