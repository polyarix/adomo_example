<template>
    <div>
        <!-- modal Error-->
        <div class="modal modal-message" style="display: none;" id="error-modal">
            <div class="modal-message-inner">
                <div class="modal-message-icon"><img src="/images/error-icon.svg" alt=""/></div>
                <div class="modal-message-text">
                    <div class="modal-title">Ошибка</div>
                    <p>Попробуйте позже</p>
                </div>
            </div>
        </div>
        <!-- /modal Error-->

        <!-- modal Успех-->
        <div class="modal modal-message" style="display: none;" id="success-modal">
            <div class="modal-message-inner">
                <div class="modal-message-icon"><img src="/images/success-icon.svg" alt=""/></div>
                <div class="modal-message-text">
                    <div class="modal-title">Заявка отправлена</div>
                    <p>Ожидайте ответ заказчика в чате </p>
                </div>
            </div>
        </div>
        <!-- /modal Успех-->

        <div class="modal modal-take-task" style="display: none;" id="take-task-modal">
            <div class="modal-title">Хотите выполнить задачу?</div>
            <div class="modal-info-box">
                <p>{{ order.title }}</p>
                <a :href="route('user.details', order.user_id)" target="_blank">{{ authorName }}</a>
            </div>

            <form @submit.prevent>
                <div class="form-group">
                    <label for="messsage">Дополните заявку (необязательно)</label>
                    <textarea name="" id="messsage" placeholder="Заявки с описанием чаще получают отклик от заказчиков" v-model="requestMessage"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-small btn-grey" @click.prevent="onRequestCancel">Отмена</button>
                    <button class="btn btn-small btn-yellow" @click="onRequestTask">Отправить</button>
                </div>
            </form>
        </div>

        <div class="modal modal-task-is-already-at-work" style="display: none;" id="modal-task-is-already-at-work">
            <div class="modal-title">Задача уже в работе</div>
            <div class="modal-footer">
                <button class="btn btn-big btn-yellow" @click="onRemove">Отменить и удалить задачу</button>
                <button class="btn btn-big btn-grey" @click="onFindNewExecutor">Найти другого исполнителя</button>
            </div>
        </div>

        <div class="modal modal-remove-task" style="display: none;" id="modal-remove-task">
            <div class="modal-title">Удалить задачу?</div>

            <div class="modal-text" v-if="order.requests.length === 0">Это действие невозможно отменить</div>
            <div class="modal-text" v-else>{{ order.requests.length }} исполнителей откликнулись на неё</div>

            <div class="modal-footer">
                <button class="btn btn-big btn-grey" onclick="$.fancybox.close()">Отмена  </button>
                <button class="btn btn-big btn-yellow" @click.prevent="onRemove">Да, удалить</button>
            </div>
        </div>

        <div class="order-card-footer" v-if="isExecutor && !isAuthor && !isInWorking && !isComplete">
            <button class="btn btn-big btn-grey" v-if="requestSent && !invitedByCustomer">Отправлено</button>
            <button class="btn btn-big btn-grey" v-else-if="invitedByCustomer" @click="redirectToActiveTasks">Ожидание ответа</button>
            <button class="btn btn-big btn-green" v-else onclick="$.fancybox.open( $('#take-task-modal'))">Выполнить задачу</button>
        </div>

        <div class="order-card-footer" v-if="isAuthor">
            <a class="btn-edit" :href="route('advert.order.edit', {id: this.order.slug})" v-if="canEdit">
                <svg class="reduction-icon">
                    <use xlink:href="/images/sprite-inline.svg#reduction-icon"></use>
                </svg>
                <span>Редактировать</span>
            </a>

            <button class="btn-remove" onclick="$.fancybox.open( $('#modal-remove-task'))" v-if="!isInWorking && !isComplete">
                <svg class="rubbish-bin-delete-button">
                    <use xlink:href="/images/sprite-inline.svg#rubbish-bin-delete-button"></use>
                </svg>
                <span>Удалить</span>
            </button>
        </div>

        <div class="order-card-footer" v-if="isInWorking && isAuthor">
            <button class="btn btn-big btn-grey" onclick="$.fancybox.open( $('#modal-task-is-already-at-work'))">Отменить задачу</button>
        </div>

        <div class="order-card-footer" v-if="isAuthor && isWaiting">
            <button class="btn btn-big btn-yellow" @click="onCatchUp">Поднять в топ</button>

            <small style="display: block; font-size: 0.8em; margin-top: 10px;" v-if="hasActivePremium">
                В топе до:
                <b style="font-weight: bold">{{ catchUpDateTo }}</b>
            </small>

            <small style="display: block; font-size: 0.8em; margin-top: 10px;" v-if="hasCatchedUp">
                Последний раз было поднято:
                <b style="font-weight: bold">{{ catchUpDate }}</b>
            </small>
        </div>

        <div class="order-card-footer" v-if="isInWorking">
            <a class="btn btn-big btn-green" href="#" @click.prevent="onConfirm">Подтвердить выполнение</a>
        </div>

        <div class="modal modal-take-task" style="display: none;" id="pay-premium-modal">
            <div class="modal-title">Хотите поднять вашу услугу в топ?</div>
            <div class="modal-info-box">
                <p>Ваша услуга будет закреплена в верхней части выбранной категории услуги</p>
                <p style="margin: 10px 0"></p>
                <p>Стоимость одного поднятия в топ: <b style="font-weight: bold;">50 рублей</b></p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-small btn-grey" onclick="$.fancybox.close($('#pay-premium-modal'))">Отмена</button>
                <a :href="catchUpUrl" class="btn btn-small btn-yellow" target="_blank">Оплатить</a>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex';
    import {STATUS_ACTIVE, STATUS_COMPLETED, STATUS_FINISHED, STATUS_WORKING} from "../../../../../constants";

    export default {
        props: ['order', 'requested'],

        data() {
            return {
                requestMessage: '',
                requestSent: this.requested
            }
        },

        methods: {
            redirectToActiveTasks() {
                window.location.href = this.route('cabinet.tasks', 'active');
            },
            onRequestTask() {
                axios.post(this.route('api.advert.task.offer'), {id: this.order.id, message: this.requestMessage})
                    .then(res => {
                        if(res.data.success) {
                            this.requestSent = true;
                            $.fancybox.close( $('#take-task-modal'));
                            // set timeout it's fix, because follow code close success modal too...
                            setTimeout(() => {
                                $.fancybox.open( $('#success-modal'));
                            }, 10);

                            let count = $('#advert_requests_count');
                            count.text(parseInt(count.text()) + 1 + ' предложения');
                            return;
                        }

                        $.fancybox.open( $('#error-modal'))
                    })
                    .catch(err => {
                        $.fancybox.open( $('#error-modal'))
                    });
            },
            onRequestCancel() {
                $.fancybox.close( $('#take-task-modal'))
            },
            // confirm execution of the order
            onConfirm() {
                axios.put(this.route('api.advert.order.confirm', this.order.slug))
                    .then(res => {
                        if(res.data.success === true) {
                            this.setCommonMessage('Вы успешно закрыли проект. Оставьте отзыв о впечатлениях при работе.');
                            setTimeout(() => {
                                window.location.href = this.route('advert.order.review', this.order.slug);
                            }, 2000);
                            return
                        }

                        this.setCommonError('Ошибка подтверждения объявления. Повторите позже.')
                    })
                    .catch(err => {
                        this.setCommonError('Ошибка подтверждения объявления. Повторите позже.')
                    })
            },
            onRemove() {
                axios.delete(this.route('api.advert.order.destroy', {id: this.order.slug}))
                    .then(res => {
                        if(res.data.success === true) {
                            this.setCommonMessage('Объявление успешно удалено.');
                            $.fancybox.close('#modal-remove-task');
                            return
                        }

                        this.setCommonError('Ошибка удаления объявления. Повторите позже.')
                    })
                    .catch(err => {
                        this.setCommonError('Ошибка удаления объявления. Повторите позже.')
                    })
            },
            onCatchUp() {
                $.fancybox.open($('#pay-premium-modal'));
            },
            onFindNewExecutor() {
                axios.post(this.route('api.advert.order.kick_executor', {id: this.order.slug}))
                    .then(res => {
                        if(res.data.success === true) {
                            this.setCommonMessage('Объявление успешно переведлен в статус поиска исполнителя.');
                            return
                        }

                        this.setCommonError('Ошибка. Повторите позже.')
                    })
                    .catch(err => {
                        this.setCommonError('Ошибка. Повторите позже.')
                    })
            }
        },

        computed: {
            ...mapState('user', ['user']),
            ...mapGetters('user', ['isExecutor', 'isCustomer']),

            catchUpDateTo() {
                return this.hasCatchedUp ? this.$moment(this.order.catched_up_to).format('DD.MM.YYYY H:mm') : ''
            },
            catchUpUrl() {
                // with params "id" it works incorrect
                return this.route('pay', {
                    type: 'catch_up',
                    entity: 'order',
                    redirect_to: route('advert.order.show', this.order.slug).toString()
                }) + '&id=' + this.order.id
            },
            hasCatchedUp() {
                return !!this.order.catched_up_at
            },
            catchUpDate() {
                return this.$moment(this.order.catched_up_at).format('DD.MM.YYYY в H:mm')
            },
            canEdit() {
                return this.order.requests.length === 0
            },
            isAuthor() {
                return this.order.user_id === this.user.id
            },
            hasActivePremium() {
                return !!this.order.catched_up_at && this.$moment(this.order.catched_up_to).diff(this.$moment.now()) > 0
            },
            isWaiting() {
                return this.order.status === STATUS_ACTIVE
            },
            isInWorking() {
                return this.order.status === STATUS_WORKING
            },
            isComplete() {
                return this.order.status === STATUS_FINISHED || this.order.status === STATUS_COMPLETED
            },
            authorName() {
                return `${this.order.user.first_name} ${this.order.user.last_name}`
            },
            invitedByCustomer() {
                return this.userRequest && this.userRequest.customer_invite
            },
            userRequest() {
                if(!this.order.requests) {
                    return {};
                }

                const request = this.order.requests.filter(req => req.user_id === this.user.id);
                if(request.length === 0) {
                    return {};
                }

                return request[0];
            },
            isReacted() {
                return this.userRequest && this.invitedByCustomer && this.userRequest.status === 'waiting'
            }
        },
    }
</script>

<style scoped>

</style>
