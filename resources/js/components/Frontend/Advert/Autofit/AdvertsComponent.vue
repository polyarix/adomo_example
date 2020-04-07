<template>
    <div class="category-advertisement">
        <div class="headline">Объявления в категории: {{ category.name }}</div>
        <div class="category-advertisement-container">
            <advert v-for="advert in premium" :advert="advert" :key="advert.id" />
        </div>

        <div class="category-advertisement-container">
            <advert v-for="advert in adverts" :advert="advert" :key="advert.id" />
        </div>

        <div v-if="isLoading">
            <div class="filter-loader"><img style="margin: 15px auto;" src="/images/ajax-loader.gif" alt=""></div>
        </div>

        <button class="btn btn-small btn-white" @click="showMore" v-if="canShowMore">Показать еще</button>
    </div>
</template>

<script>
    import Advert from "../Advert";

    export default {
        props: ['category', 'premium', 'initData', 'filters'],

        data() {
            return {
                loading: false,
                canShowMore: false,
                page: 2,
                adverts: [],
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

                axios.post(this.route('api.autofit.services'), data)
                    .then(res => {
                        let info = res.data.data;

                        this.adverts = this.adverts.concat(info.data);
                        this.canShowMore = info.last_page >= this.page;
                        this.loading  = false;
                    });

                this.page++;
            },
        },

        created() {
            this.adverts = this.initData.data;
            this.canShowMore = this.initData.last_page >= this.page;
        },

        components: {
            Advert
        },
    }
</script>

<style>

</style>
