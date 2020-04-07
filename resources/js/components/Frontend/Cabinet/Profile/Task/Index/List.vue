<template>
    <div class="personal-content-inner lk-tasks">
        <div class="main-title">Мои задания</div>
        <div class="tabs">
            <div class="alert alert-danger" v-if="hasCommonError">
                {{ getCommonError }}
            </div>

            <filter-component :categories="listFilters" @categoryChange="onCategoryChange" />

            <div class="tabs-content active">
                <div class="category-task-container">
                    <advert-item :task="task" v-for="(task, index) in tasks" :key="task.id" @setVisibility="onSetVisibility(index, $event)" />

                    <div class="filter-loader" v-if="loading"><img class="loader" src="/images/ajax-loader.gif" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FilterComponent from "./Filter";
    import AdvertItem from "./AdvertItem";
    import {mapGetters, mapMutations} from "vuex";
    import {STATUS_ACTIVE, STATUS_COMPLETED, STATUS_WORKING} from "../../../../../../constants";

    export default {
        data() {
            return {
                category: null,
                loading: true,

                listFilters: [
                    {id: STATUS_ACTIVE, name: 'В ожидании'},
                    {id: STATUS_WORKING, name: 'В работе'},
                    {id: STATUS_COMPLETED, name: 'Выполнено'},
                ],

                tasks: [],
            }
        },

        computed: {
            ...mapGetters('task', ['isMainPageActive', 'isSpecificFilterActive']),
        },

        methods: {
            ...mapMutations('task', ['setMainPageActive']),

            onSetVisibility(index, value) {
                const task = this.tasks[index];
                task.is_visible = value
            },
            onCategoryChange(id) {
                this.category = id;
                this.fetchData();
            },
            fetchData() {
                this.loading = true;

                axios.post(this.route('api.user.cabinet.tasks.list'), {type: this.category})
                    .then(res => {
                        if(res.data.success) {
                            this.tasks = res.data.data;
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
            let categoryType = this.$route.params.type;
            if(categoryType) {
                this.category = categoryType;
                this.$store.commit('task/setCategory', categoryType)
            }
            this.fetchData()
        },

        components: {
            AdvertItem,
            FilterComponent
        }
    }
</script>

<style scoped>
    .loader {
        margin: 0 auto;
    }
</style>
