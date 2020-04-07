<template>
    <div class="people-group">
        <slot></slot>
        <div class="people-group-container">
            <executor v-for="executor in executors" :category="category" :user="executor" :key="executor.id" />
        </div>

        <div v-if="isLoading">
            <div class="filter-loader"><img style="margin: 15px auto;" src="/images/ajax-loader.gif" alt=""></div>
        </div>

        <button class="btn btn-small btn-white" @click="showMore" v-if="canShowMore">Показать еще</button>
    </div>
</template>

<script>
    import Executor from "../Category/Executor";

    export default {
        props: ['initData', 'filters', 'category'],

        data() {
            return {
                loading: false,
                canShowMore: true,
                page: 2,
                executors: []
            }
        },

        computed: {
            isLoading() {
                return this.loading === true;
            },
        },

        methods: {
            showMore() {
                this.loading = true;

                let data = this.filters;
                data.page = this.page;

                axios.post(this.route('api.autofit.users'), data)
                    .then(res => {
                        let info = res.data.data;

                        this.executors = this.executors.concat(info.data);
                        this.canShowMore = info.last_page >= this.page;
                        this.loading  = false;
                    });

                this.page++;
            },
        },

        created() {
            this.executors = this.initData.data;
            this.canShowMore = this.initData.last_page >= this.page;
        },

        components: {Executor},
    }
</script>

<style scoped>

</style>
