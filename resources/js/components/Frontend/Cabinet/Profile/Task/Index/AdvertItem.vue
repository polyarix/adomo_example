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
                    <review-star-component v-if="userReview" :avg="userReview.avg" />
                </div>

                <div style="text-align: left; padding-top: 10px;">
                    <a class="btn btn-big btn-yellow" v-if="isReviewWaiting" :href="route('advert.order.review', this.task.slug)" target="_blank">Оставить отзыв</a>
                    <button class="task-card-button btn btn-big btn-green" v-if="order.isWorking() && isAuthor" @click.prevent="onConfirm">Завершить задание</button>
                    <a class="task-card-button btn btn-big btn-dark" v-if="order.isCompleted() || order.isFinished()" :href="route('advert.order.repeat', task.slug)">Повторить задание</a>

                    <a class="task-card-button btn btn-big btn-dark" @click="setVisibility(false)" v-if="canHide">Скрыть задание</a>
                    <a class="task-card-button btn btn-big btn-yellow" @click="setVisibility(true)" v-if="canDisplay">Отобразить задание</a>
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

                <div style="float: right; margin-right: 9%; text-align: left;" v-if="isExecutor">
                    <a class="btn btn-small btn-yellow" @click.prevent="onAccept" v-if="isWaitingResponse">Принять предложение</a>
                    <a class="btn btn-small btn-white" v-if="false">Отменить задачу</a>
                    <a class="task-card-button btn btn-big btn-green" @click.prevent="onConfirm" v-if="order.isWorking()">Подтвердить выполнение</a>
                    <a class="btn btn-small btn-white" @click.prevent="refuseRequest" v-if="canRefuse">Отказаться</a>
                </div>

                <div style="text-align: left;">
                    <a class="btn btn-big btn-yellow" v-if="isReviewWaiting" :href="route('advert.order.review', this.task.slug)" target="_blank">Оставить отзыв</a>
                    <a class="task-card-button btn btn-big btn-dark" v-if="order.isCompleted() || order.isFinished()" :href="route('category.show', this.task.category.slug)">Найти похожие</a>
                </div>
            </template>

            <div class="task-card-absolute">
                <a class="task-card-price" :href="route('advert.order.show', task.slug)">{{ price }}</a>
                <div :class="{'task-card-status': true, 'status-done': order.isCompleted() || order.isFinished(), 'status-cancel' : order.isRejected(), 'status-verification' : order.isOnModeration()}">{{ status }}</div>
            </div>

            <div class="task-card-rejection" v-if="order.isRejected() && task.close_reason">
                <p><strong>Причина отклонения: </strong>{{ task.close_reason }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    import RemoveModal from "./RemoveModal";
    import { normalize as normalizeStatus } from './../../../../../../helpers/Advert/statusesHelper';
    import OrderWrapper from "../../../../../../helpers/Advert/OrderWrapper";
    import {mapState} from 'vuex';
    import {STATUS_ACTIVE, STATUS_COMPLETED, STATUS_FINISHED, STATUS_WORKING} from "../../../../../../constants";
    import ReviewStarComponent from "../../../../../Shared/Order/ReviewStarComponent";
    const PRICE_TYPE_SPECIFIC = 'specific'; // определённая
    const PRICE_TYPE_DISCUSS = 'discuss'; // договорная

    export default {
        props: ['task'],

        data() {
            return {
                showModal: false
            }
        },

        methods: {
            setVisibility(isVisible) {
                axios.put(this.route('api.advert.order.visibility', this.task.slug), {visible: isVisible})
                    .then(res => {
                        if(res.data.success) {
                            this.$emit('setVisibility', isVisible);
                            return;
                        }

                        this.setCommonError('Что-то пошло не так. Повторите запрос.', 2000)
                    })
                    .catch(err => {
                        this.setCommonError('Произошла какая-то ошибка.');
                    })
            },
            onAccept() {
                axios.put(this.route('api.advert.request.accept', {id: this.task.id}))
                    .then(res => {
                        let data = res.data;

                        if(!data.success || data.success !== true) {
                            alert(data.error);
                            return;
                        }
                        this.setCommonMessage('Предложение было успешно принято');
                        this.$store.commit('task/setCategory', STATUS_WORKING)
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            onConfirm() {
                axios.put(this.route('api.advert.order.confirm', this.task.slug))
                    .then(res => {
                        if (res.data.success === true) {
                            this.setCommonMessage('Вы успешно закрыли проект. Оставьте отзыв о впечатлениях при работе.');
                            setTimeout(() => {
                                window.location.href = this.route('advert.order.review', this.task.slug);
                            }, 2000);
                            return
                        }

                        this.setCommonError('Ошибка подтверждения объявления. Повторите позже.');
                        this.$store.commit('task/setCategory', STATUS_COMPLETED);
                    })
                    .catch(err => {
                        console.log(err)
                        this.setCommonError('Ошибка подтверждения объявления. Повторите позже.')
                    })
            },
            refuseRequest() {
                axios.delete(this.route('api.advert.request.reject', {id: this.task.id}))
                    .then(res => {
                        let data = res.data;

                        if(!data.success || data.success !== true) {
                            alert(data.error);
                            return;
                        }

                        this.setCommonMessage('Предложение было успешно отклонено');
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
        },

        computed: {
            ...mapState('user', ['user']),
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
            canAccept() {
                return this.userRequest.status === 'waiting' && this.userRequest.customer_invite
            },
            isVisible() {
                return this.task.is_visible
            },
            canHide() {
                return this.isAuthor && this.isVisible && (this.order.isCompleted() || this.order.isFinished())
            },
            canDisplay() {
                return this.isAuthor && !this.isVisible && (this.order.isCompleted() || this.order.isFinished())
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
            address() {
                return this.task.address;
            },
            city() {
                return this.task.address.split(',')[0];
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
            actionsAvailable() {
                return this.order.isActive() || this.order.isCompleted() || this.order.isFinished() || this.order.isWorking()
            },
            executorName() {
                return `${this.task.executor.first_name} ${this.task.executor.last_name}`
            },
            canRefuse() {
                return this.order.isActive() && this.isExecutor
            },
            isWaitingResponse() {
                return this.isExecutor && this.order.isActive()
            },
            invitedByCustomer() {
                return this.userRequest && this.userRequest.customer_invite
            },
            isReviewWaiting() {
                return (this.order.isCompleted() || this.order.isFinished()) && !this.userReview
            }
        },

        components: {ReviewStarComponent, RemoveModal},
    }
</script>

<style scoped>
</style>
