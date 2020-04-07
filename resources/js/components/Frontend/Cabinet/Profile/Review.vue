<template>
    <div class="review-item">
        <div class="review-item-header">
            <a class="review-item-name" :href="'/user/' + review.author.id">{{ author }}</a>

            <div class="review-item-avatar"><img :src="'/' + review.author.avatar" alt=""></div>
            <div class="review-item-date">{{ date }}</div>

            <div class="review-item-rate">
                <div class="user-rating">
                    <div class="user-rating-stars" :data-star="review.stars">
                        <svg class="star">
                            <use xlink:href="/images/sprite-inline.svg#star"></use>
                        </svg>
                        <svg class="star">
                            <use xlink:href="/images/sprite-inline.svg#star"></use>
                        </svg>
                        <svg class="star">
                            <use xlink:href="/images/sprite-inline.svg#star"></use>
                        </svg>
                        <svg class="star">
                            <use xlink:href="/images/sprite-inline.svg#star"></use>
                        </svg>
                        <svg class="star">
                            <use xlink:href="/images/sprite-inline.svg#star"></use>
                        </svg>
                    </div>
                </div>

                <div class="user-rating-rate" v-if="isForExecutor"> <span>Оценки</span></div>

                <div class="user-rating-rate-values" v-if="isForExecutor">
                    <!-- mixin rating-type-->
                    <div class="rating-type">
                        <div class="rating-type-item">
                            <svg class="star">
                                <use xlink:href="/images/sprite-inline.svg#star"></use>
                            </svg>
                            <strong>{{ review.quality }}</strong>
                            <span>Качество</span>
                        </div>

                        <div class="rating-type-item">
                            <svg class="star">
                                <use xlink:href="/images/sprite-inline.svg#star"></use>
                            </svg>
                            <strong>{{ review.professionalism }}</strong>
                            <span>Профессионализм</span>
                        </div>

                        <div class="rating-type-item">
                            <svg class="star">
                                <use xlink:href="/images/sprite-inline.svg#star"></use>
                            </svg>
                            <strong>{{ review.punctuality }}</strong>
                            <span>Пунктуальность и вежливость</span>
                        </div>
                    </div>
                    <!-- / mixin rating-type-->
                </div>
            </div>
        </div>
        <div class="review-item-body">
            <div class="review-item-text">
                <p>{{ realText }}
                    <span class="truncate-button" v-if="isHided" @click="hided = false">Весь отзыв</span>
                    <span class="truncate-button open" v-else-if="isLong" @click="hided = true">Скрыть </span>
                </p>
            </div>
        </div>
        <div class="review-item-footer" v-if="review.advert">
            <p>Отзыв по заданию: <a :href="route('advert.order.show', review.advert.slug)">{{ review.advert.title }}</a></p>
        </div>
    </div>
</template>

<script>
    import GradeLabelHelper from "../../../../helpers/User/Review/GradeLabelHelper";
    import {TYPE_EXECUTOR} from "../../../../constants";

    const TRUNCATE_LENGTH = 150;

    export default {
        props: ['review'],

        data() {
            return {
                hided: false,
            }
        },

        computed: {
            author() {
                return `${this.review.author.first_name} ${this.review.author.last_name}`
            },
            date() {
                return this.$moment(this.review.created_at).format("D MMMM YYYY");
            },
            realText() {
                if(this.review.text.length > TRUNCATE_LENGTH && this.hided) {
                    return this.review.text.slice(0, TRUNCATE_LENGTH) + '...'
                }

                return this.review.text;
            },
            isLong() {
                return this.review.text.length > TRUNCATE_LENGTH
            },
            isHided() {
                return this.isLong && this.hided
            },
            isForExecutor() {
                return this.review.type === TYPE_EXECUTOR
            }
        },

        filters: {
            truncate(text, stop, clamp) {
                return text.slice(0, stop) + (stop < text.length ? clamp || '...' : '')
            }
        },

        methods: {
            getGradeLabel(status) {
                return GradeLabelHelper(status)
            },
        },

        created() {
            this.hided = this.review.text.length > 100
        }
    }
</script>

<style scoped>
    .truncate-button {
        color: silver;
    }
    .truncate-button:hover {
        cursor: pointer;
    }
</style>
