<template>
    <div class="recommend-user">
        <div class="recommend-user__avatar user-card-avatar"><img :src="'/' + avatar" alt=""></div>
        <div class="recommend-user__body">
            <a :href="route('user.details', user.id)" class="user-card-name">
                <span>{{ fullName }}</span>
                <div class="pro" v-if="premium" style="background-image:url(/images/pro-icon.svg)"></div>
            </a>

            <div class="user-card-type">{{ isBrigade ? 'Бригада' : 'Частный исполнитель' }}</div>
            <div class="user-rating">
                <div class="user-rating-stars" :data-star="starRating">
                    <svg class="star" v-for="index in 5">
                        <use xlink:href="/images/sprite-inline.svg#star"></use>
                    </svg>
                </div>
                <div class="user-rating-rate">{{ rating }}</div>
            </div>

            <p>{{ user.age }} года {{ user.city.name }}</p>
            <p>Отзывов: <span>{{ user.reviews_count }}</span></p>
            <p>Положительных: <span>{{ user.reviews_positive_percent }}%</span></p>
            <div class="recommend-user__icons">
                <img src="/images/shield-true.svg" v-if="isConfirmed" title="Проверенный исполнитель">
                <img src="/images/recom.svg" v-if="isBestExecutor" title="Лучший исполнитель">
                <img src="/images/police.svg" v-if="noCriminalRecords" title="Нет судимости">
            </div>

            <button class="btn btn-small btn-outline" :class="{'btn-outline--inverse': isExecutor}" @click="toggleExecutor">
                {{ isExecutor ? 'Отменить выбор' : 'Выбрать исполнителя' }}
            </button>
        </div>
    </div>
</template>

<script>
    import {TYPE_BRIGADE} from "../../../../../../constants";

    export default {
        props: ['user', 'executorId'],

        computed: {
            isBestExecutor() {
                return this.reviews_positive_percent > 90 || true
            },
            noCriminalRecords() {
                return true;
            },
            isExecutor() {
                return this.user.id === this.executorId
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
                return this.user.confirmed === true || true
            },
            isBrigade() {
                return this.user.team_type === TYPE_BRIGADE;
            }
        },

        methods: {
            toggleExecutor() {
                if(this.isExecutor) {
                    this.$emit('remove');
                    return;
                }

                this.$emit('select', this.user)
            }
        }
    }
</script>

<style scoped>

</style>
