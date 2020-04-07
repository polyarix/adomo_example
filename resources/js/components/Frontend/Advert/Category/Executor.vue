<template>
    <div class="user-card">
        <div class="user-card-avatar">
            <img :src="'/' + avatar" alt="">
        </div>
        <div class="user-card-main">
            <a class="user-card-name" :href="route('user.details', user.id)">
                <span>{{ fullName }}</span>
                <div class="pro" v-if="premium" style="background-image:url(/images/pro-icon.svg)"></div>
            </a>
            <div class="user-card-type">{{ isBrigade ? 'Бригада' : 'Частный исполнитель' }}</div>
            <!-- mixin user-rating-->
            <div class="user-rating">
                <div class="user-rating-stars" :data-star="starRating">
                    <svg class="star" v-for="index in 5">
                        <use xlink:href="/images/sprite-inline.svg#star"></use>
                    </svg>
                </div>
                <div class="user-rating-rate">{{ rating }}</div>
            </div>
            <!-- /mixin user-rating-->
        </div>
        <div class="user-card-addition">
            <img class="user-recommend" v-if="isRecommend" src="/images/recom.svg" alt="">
            <div class="user-certified" v-if="isConfirmed" style="background-image:url(/images/shield-true.svg)"></div>
            <div class="user-certified" v-else style="background-image:url(/images/shield-false.svg)"></div>
            <!-- mixin user-reviews-->
            <div class="user-reviews">
                <div class="user-reviews-icon" style="background-image:url(/images/review-icon.svg)"></div>
                <div class="user-reviews-count">{{ user.reviews_count }}</div>
            </div>
            <!-- /mixin user-reviews-->
            <!-- mixin user-like-->
            <div class="user-like">
                <div class="user-like-icon" style="background-image:url(/images/like-icon.svg)"></div>
                <div class="user-like-count">{{ user.reviews_positive_percent }} %</div>
            </div>
            <!-- //mixin user-like-->
        </div>
        <a class="btn btn-small btn-yellow" :href="workInviteUrl">Предложить работу</a>
    </div>
</template>

<script>
    import {TYPE_BRIGADE} from "../../../../constants";

    export default {
        props: ['user', 'category'],

        computed: {
            workInviteUrl() {
                return this.category ?
                    this.route('advert.order.create', {category: this.category.slug, user: this.user.id}) :
                    this.route('advert.order.create_individual', {user: this.user.id});
            },
            isRecommend() {
                return this.user.is_best_executor
            },
            avatar() {
                return this.user.avatar;
            },
            fullName() {
                return `${this.user.first_name} ${this.user.last_name}`;
            },
            premium() {
                return this.user.has_premium === true;
            },
            starRating() {
                return this.user.star_rating;
            },
            rating() {
                return this.user.rating;
            },
            isConfirmed() {
                return this.user.confirmed === true;
            },
            isBrigade() {
                return this.user.team_type === TYPE_BRIGADE;
            }
        },
    }
</script>

<style scoped>

</style>
