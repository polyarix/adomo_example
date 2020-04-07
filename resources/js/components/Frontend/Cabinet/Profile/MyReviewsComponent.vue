<template>
    <div class="profile-section profile-reviews">
        <div class="reviews-container">
            <!--mixin review-item-->
            <review v-for="review in reviews" :review="review" :key="review.id" />
            <!--mixin review-item-->
        </div>
        <button class="btn btn-small btn-white btn-center" @click="showMore" v-if="canShowMore">Показать еще</button>
    </div>
</template>

<script>
    const API_REVIEWS_URL = '/api/user/reviews';

    import Review from "./Review";
    import {mapState} from 'vuex';

    export default {
        data() {
            return {
                loading: false,
                canShowMore: false,
                page: 1,
                reviews: []
            }
        },

        computed: {
            ...mapState('user', ['user']),
            isLoading() {
                return this.loading === true;
            },
        },

        methods: {
            showMore() {
                this.loading = true;

                axios.post(API_REVIEWS_URL, { user_id: this.user.id, page: this.page })
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
