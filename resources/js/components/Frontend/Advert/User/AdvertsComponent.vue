<template>
    <div class="category-advertisement">
        <div class="headline">Объявления</div>
        <div class="category-advertisement-container">
            <advert v-for="advert in adverts" :advert="advert" :key="advert.id" route-name="advert.order.show" />
        </div>

        <div v-if="isLoading">
            <div class="filter-loader"><img style="margin: 15px auto;" src="/images/ajax-loader.gif" alt=""></div>
        </div>

        <button class="btn btn-small btn-grey" @click="showMore" v-if="canShowMore">Показать еще</button>
    </div>
</template>

<script>
    import Advert from "../Advert";

    export default {
        props: ['user'],

        data() {
            return {
                loading: true,
                canShowMore: true,
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

                axios.post(this.route('api.category.user_adverts'), { user_id: this.user.id, page: this.page })
                    .then(res => {
                        this.adverts = this.adverts.concat(res.data.data);
                        this.canShowMore = res.data.meta.last_page >= this.page;
                        this.loading = false;
                    });

                this.page++;
            },
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
