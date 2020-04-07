<template>
    <div class="task-card">
        <div class="task-card-inner">
            <a class="task-card-name" :href="route('advert.order.show', task.slug)">{{ task.title }}</a>

            <template v-if="isAuthor">
                <div class="task-card-info" v-if="order.isWorking()">
                    <span>Выбран исполнитель</span>
                    <a class="task-card-info-who" :href="route('user.details', {id: task.executor.id})" target="_blank">{{ executorName }}</a>
                </div>

                <div class="task-card-info" v-if="order.isCompleted() || order.isFinished()">
                    <span>Выполнено исполнителем</span>

                    <a class="task-card-info-who" :href="route('user.details', {id: task.executor.id})" target="_blank">{{ executorName }}</a>

                    <div class="user-rating" v-if="userReview">
                        <div class="user-rating-stars" :data-star="userReview.avg">
                            <svg class="star" v-for="i in 5">
                                <use xlink:href="/images/sprite-inline.svg#star"></use>
                            </svg>
                        </div>
                    </div>
                </div>
                <!--Fix markup broking after hiding the block-->
                <div class="task-card-info" style="visibility: hidden" v-else>
                    <span>Выполнено исполнителем</span>

                    <a class="task-card-info-who">Test</a>
                </div>
            </template>

            <!-- IS Executor -->
            <template v-else>
                <div class="task-card-info" v-if="order.isActive() && invitedByCustomer && isExecutor">
                    <span>Предложено заказчиком</span>

                    <a class="task-card-info-who" :href="route('user.details', {id: task.author.id})" target="_blank">{{ authorName }}</a>
                </div>
                <div class="task-card-info" v-if="(order.isWorking() || order.isFinished() || order.isCompleted()) && isExecutor">
                    <span>Принято у заказчика</span>

                    <a class="task-card-info-who" :href="route('user.details', {id: task.author.id})" target="_blank">{{ authorName }}</a>

                    <review-star-component v-if="userReview" :avg="userReview.avg" />
                </div>
                <!--Fix markup broking after hiding the block-->
                <div class="task-card-info" style="visibility: hidden" v-else>
                    <span>Принято у заказчика</span>

                    <a class="task-card-info-who">123</a>
                </div>
            </template>

            <div class="task-card-absolute">
                <a class="task-card-price" :href="route('advert.order.show', task.slug)">{{ price }}</a>
                <div :class="{'task-card-status': true, 'status-done': order.isCompleted() || order.isFinished()}">{{ status }}</div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from "vuex";
    import {normalize as normalizeStatus} from "../../../../helpers/Advert/statusesHelper";
    import OrderWrapper from "../../../../helpers/Advert/OrderWrapper";
    import RemoveModal from "../../Cabinet/Profile/Task/Index/RemoveModal";
    import ReviewStarComponent from "../../../Shared/Order/ReviewStarComponent";

    const PRICE_TYPE_SPECIFIC = 'specific'; // определённая
    const PRICE_TYPE_DISCUSS = 'discuss'; // договорная

    export default {
        props: ['task', 'target'],

        computed: {
            user() {
                return this.target
            },
            userReview() {
                if(!this.task.reviews) {
                    return null;
                }

                const reviews = this.task.reviews.filter(req => req.user_id === this.user.id);
                if(reviews.length === 0) {
                    return null;
                }

                return reviews[0];
            },
            authorName() {
                return `${this.task.author.first_name} ${this.task.author.last_name}`
            },
            status() {
                return normalizeStatus(this.task.status)
            },
            date() {
                return this.$moment(this.task.created_at).format("D MMMM");
            },
            preview() {
                return this.task.preview;
            },
            price() {
                if(this.isPriceDiscuss) {
                    return 'Обсуждается'
                }

                return `${this.task.price} Р`;
            },
            isPriceSpecific() {
                return this.task.price_type === PRICE_TYPE_SPECIFIC
            },
            isPriceDiscuss() {
                return this.task.price_type === PRICE_TYPE_DISCUSS
            },
            order() {
                return new OrderWrapper(this.task)
            },
            isAuthor() {
                return this.task.author.id === this.user.id
            },
            isExecutor() {
                return this.task.executor.id === this.user.id
            },
            isGuest() {
                return !this.user || !this.isExecutor
            },
            actionsAvailable() {
                return this.order.isActive() || this.order.isCompleted() || this.order.isFinished() || this.order.isWorking()
            },
            executorName() {
                return `${this.task.executor.first_name} ${this.task.executor.last_name}`
            },
            invitedByCustomer() {
                return this.userRequest && this.userRequest.customer_invite
            },
            userRequest() {
                if(!this.task.requests) {
                    return {};
                }

                const request = this.task.requests.filter(req => req.user_id === this.user.id);
                if(request.length === 0) {
                    return {};
                }

                return request[0];
            },
        },

        components: {RemoveModal, ReviewStarComponent},
    }
</script>

<style scoped>

</style>
