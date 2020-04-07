<template>
    <div class="people-group">
        <slot></slot>
        <div class="people-group-container">
            <executor v-for="executor in executors" :user="executor" :key="executor.id" />
        </div>

        <div v-if="isLoading">
            <div class="filter-loader"><img style="margin: 15px auto;" src="/images/ajax-loader.gif" alt=""></div>
        </div>

        <button class="btn btn-small btn-white" @click="showMore" v-if="canShowMore">Показать еще</button>
    </div>
</template>

<script>
    import Executor from './../Category/Executor';

    export default {
        props: ['tag'],

        data() {
            return {
                loading: true,
                canShowMore: false,
                page: 1,
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

                axios.post(this.route('api.tag.executors'), { tag_id: this.tag.id, page: this.page })
                    .then(res => {
                        this.executors = this.executors.concat(res.data.data);
                        this.canShowMore = res.data.meta.last_page >= this.page;
                        this.loading  = false;
                    });

                this.page++;
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
