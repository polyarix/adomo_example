<template>
    <div class="people-group">
        <div class="headline">Рекомендуемые </div>

        <div class="people-group-container">
            <executor v-for="executor in executors" :category="category" :user="executor" :key="'top' + executor.id" />
        </div>

        <div v-if="isLoading">
            <div class="filter-loader"><img style="margin: 15px auto;" src="/images/ajax-loader.gif" alt=""></div>
        </div>
    </div>
</template>

<script>
    import Executor from "./Executor";

    export default {
        props: ['category'],

        data() {
            return {
                loading: true,
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

                axios.post(this.route('api.category.recommended_executors'), { category_id: this.category.id })
                    .then(res => {
                        this.executors = this.executors = res.data.data;
                        this.loading  = false;
                    });
            },
        },

        created() {
            this.showMore();
        },

        components: {
            Executor
        },
    }
</script>

<style scoped>

</style>
