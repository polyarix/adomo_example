<template>
    <div class="profile-section profile-tasks">
        <div class="headline">Задания</div>
        <div class="tabs">
            <div class="tabs-caption">
                <div :class="{'tab-button': true, active: tab === null}" @click="tab = null">Все</div>
                <div :class="{'tab-button': true, active: key === tab}" v-for="(name, key) in categories" @click="tab = key">{{ name }}</div>
            </div>

            <div class="tabs-content active">
                <div class="category-task-container">
                    <advert v-for="task in adverts" :target="user" :task="task" />

                    <button class="btn btn-small btn-grey" @click="showMore" v-if="canShowMore">Показать еще</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Advert from "../../Advert/User/Advert";
    import {STATUS_ACTIVE, STATUS_COMPLETED, STATUS_WORKING, TYPE_CUSTOMER, TYPE_EXECUTOR} from "../../../../constants";

    export default {
        props: ['user'],

        data() {
            return {
                loading: true,
                canShowMore: true,
                page: 1,
                adverts: [],
                tab: null,
            }
        },

        computed: {
            isLoading() {
                return this.loading === true;
            },
            isExecutor() {
                return this.user.type === TYPE_EXECUTOR
            },
            isCustomer() {
                return this.user.type === TYPE_CUSTOMER
            },
            categories() {
                const categories = {};

                if(this.isExecutor) {
                    categories[STATUS_WORKING] = 'В работе';
                    categories[STATUS_COMPLETED] = 'Выполнено';
                } else {
                    categories[STATUS_ACTIVE] = 'В ожидании';
                    categories[STATUS_WORKING] = 'В работе';
                    categories[STATUS_COMPLETED] = 'Выполнено';
                }

                return categories;
            }
        },

        methods: {
            showMore() {
                this.loading = true;

                axios.post(this.route('api.user.tasks'), { user_id: this.user.id, page: this.page, status: this.tab })
                    .then(res => {
                        this.adverts = this.adverts.concat(res.data.data);
                        this.canShowMore = res.data.meta.last_page >= this.page;
                        this.loading = false;
                    });

                this.page++;
            },
        },

        watch: {
            tab(newTab, oldTab) {
                this.page = 1;
                this.adverts = [];
                this.showMore();
            }
        },

        created() {
            this.showMore();
        },

        components: {
            Advert
        },
    }
</script>

<style scoped>

</style>
