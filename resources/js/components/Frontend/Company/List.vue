<template>
    <div>
        <div class="companies-container">
            <company v-for="company in companies" :company="company" :key="company.id" />

            <div v-if="isLoading">
                <div class="filter-loader"><img style="margin: 15px auto;" src="/images/ajax-loader.gif" alt=""></div>
            </div>
        </div>

        <button class="btn btn-small btn-white" @click="showMore" v-if="canShowMore">Показать еще</button>
    </div>
</template>

<script>
    import Company from "./Company";

    export default {
        props: ['category'],

        data() {
            return {
                loading: true,
                canShowMore: false,
                page: 1,
                companies: [],
            }
        },

        computed: {
            isLoading() {
                return this.loading === true;
            },
        },

        methods: {
            showMore() {
                const categoryId = this.category ? this.category.id : null;
                this.loading = true;

                axios.post(this.route('api.companies.index'), { category_id: categoryId, page: this.page })
                    .then(res => {
                        this.companies = this.companies.concat(res.data.data);
                        this.canShowMore = res.data.meta.last_page >= this.page;
                        this.loading = false;
                    });

                this.page++;
            },
        },

        created() {
            this.showMore();
        },

        components: {Company},
    }
</script>

<style scoped>

</style>
