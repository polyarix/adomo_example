<template>
    <div>
        <div class="profile-reviews-header" :style="{'margin-bottom': reviews.count > 0 ? '50px' : 0}">
            <slot />
        </div>
        <div class="reviews-container" v-if="reviews.length > 0">
            <!--mixin review-item-->
            <review v-for="review in reviews" :review="review" :key="review.id" />
            <!--mixin review-item-->
        </div>
        <button class="btn btn-small btn-grey btn-center" @click="showMore" v-if="canShowMore">Показать еще</button>
    </div>
</template>

<script>
    const API_REVIEWS_URL = '/api/user/reviews';

    import Review from "./Review";

    export default {
        props: ['userId'],

        data() {
            return {
                loading: false,
                canShowMore: false,
                page: 1,
                reviews: []
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

                axios.post(API_REVIEWS_URL, { user_id: this.userId, page: this.page })
                    .then(res => {
                        this.reviews = this.reviews.concat(res.data.data);
                        this.canShowMore = res.data.meta.last_page >= this.page;
                        this.loading  = false;
                    });

                this.page++;
            },
        },

        created() {
            this.showMore()
        },

        components: {
            Review
        }
    }
</script>

<style scoped>

</style>
