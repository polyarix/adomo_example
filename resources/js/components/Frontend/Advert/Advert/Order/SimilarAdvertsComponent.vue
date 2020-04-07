<template>
    <div class="category-task-container">
        <div class="headline">Другие задания в категории</div>

        <similar-advert v-for="advert in adverts" :advert="advert" :key="advert.id" />

        <div v-if="isLoading">
            <div class="filter-loader"><img style="margin: 15px auto;" src="/images/ajax-loader.gif" alt=""></div>
        </div>

        <button class="btn btn-small btn-white" v-if="canShowMore" @click.prevent="showMore()">Показать еще</button>
    </div>
</template>

<script>
    import SimilarAdvert from "./SimilarAdvert";

    export default {
        props: ['category', 'order'],

        data() {
            return {
                loading: true,
                canShowMore: false,
                page: 1,
                adverts: []
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

                axios.post(this.route('api.advert.order.similar'), {
                    category_id: this.category.id,
                    except_id: this.order.id,
                    page: this.page
                })
                    .then(res => {
                        this.adverts = this.adverts.concat(res.data.data);
                        this.canShowMore = res.data.meta.last_page >= this.page;
                        this.loading  = false;
                    });

                this.page++;
            },
        },

        created() {
            this.showMore()
        },

        components: {SimilarAdvert}
    }
</script>

<style scoped>

</style>
