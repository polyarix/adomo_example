<template>
    <div class="container">
        <div class="row articles-container">
            <blog-item v-for="article in articles" :key="article.id" :item="article" :base-url="articleUrl" />

            <div v-if="isLoading" style="text-align: center; margin: 0 auto; width: 100%">
                <div class="filter-loader" style="margin: 0 auto;"><img style="margin: 15px auto;" src="/images/ajax-loader.gif" alt=""></div>
            </div>
        </div>

        <div class="btn-container">
            <button class="btn btn-big btn-yellow" @click.prevent="showMore" v-if="canShowMore">Показать еще</button>
        </div>
    </div>
</template>

<script>
    import Categories from "./ListCategories";
    import BlogItem from "./BlogItem";

    export default {
        props: ['category', 'baseUrl', 'articleUrl'],

        data() {
            return {
                articles: [],
                loading: true,
                canShowMore: false,
                page: 1,
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

                axios.post(this.baseUrl, {category: this.category ? this.category.id : null, page: this.page})
                    .then(res => {
                        this.articles = this.articles.concat(res.data.data);
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
            BlogItem,
            Categories
        }
    }
</script>

<style scoped>

</style>
