<template>
    <div :class="{'task-card': true, 'task-premium': isPremiumAdvert, 'reaction-accepted': accepted, 'reaction-rejected': rejected}">
        <div class="task-card-inner">
            <a class="task-card-name" :href="route('advert.order.show', advert.slug)">{{ advert.title }}</a>
            <div class="task-card-disc">{{ advert.description }}</div>
            <div class="task-card-info">
                <a class="task-card-info-who" :href="route('user.details', {id: advert.author.id})" target="_blank">{{ authorName }}</a>
                <div class="task-card-info-date">
                    <div class="date-icon" style="background-image:url(/images/clock-icon.svg)"></div>
                    <span>{{ date }}</span>
                </div>
                <div class="task-card-info-city">
                    <div class="place-icon" style="background-image:url(/images/place-icon.svg)"></div>
                    <span>{{ city }}</span>
                </div>
            </div>
            <div class="task-card-absolute">
                <a class="task-card-price" :href="route('advert.order.show', advert.slug)">{{ price }}</a>
                <div class="task-card-status">{{ status }}</div>
            </div>

            <button class="btn btn-small btn-dark" @click="showModal" v-if="isShowButtonVisible">Выполнить</button>

            <div class="offers-button" v-if="!reacted && isActive">
                <button class="btn btn-small btn-green" @click="onAccept" v-if="isAcceptButtonVisible">Принять предложение</button>
                <button class="btn btn-small btn-yellow" @click="onReject" v-if="isRejectButtonVisible">Отклонить предложение</button>
            </div>
        </div>
    </div>
</template>

<script>
    import { normalize as normalizeStatus } from "../../../../helpers/Advert/statusesHelper";
    import {mapGetters, mapState} from "vuex";
    import {STATUS_ACTIVE, STATUS_REJECTED} from "../../../../constants";

    const PRICE_TYPE_SPECIFIC = 'specific'; // определённая
    const PRICE_TYPE_DISCUSS = 'discuss'; // договорная

    export default {
        props: ['advert'],

        data() {
            return {
                accepted: null,
                rejected: null,
            }
        },

        computed: {
            ...mapState('user', ['user']),
            ...mapGetters('user', ['isExecutor', 'isCustomer']),

            isPremiumAdvert() {
                return this.advert.is_premium
            },
            // does user press one of buttons: reject or accept the project
            reacted() {
                return this.accepted === true || this.rejected === true || (this.userRequest && this.userRequest.status === STATUS_REJECTED)
            },
            authorName() {
                return `${this.advert.author.first_name} ${this.advert.author.last_name}`
            },
            date() {
                return this.$moment(this.advert.created_at).format("D MMMM");
            },
            status() {
                return normalizeStatus(this.advert.status)
            },
            address() {
                return this.advert.address;
            },
            city() {
                return this.advert.city ? this.advert.city.name : this.advert.address.split(',')[0];
            },
            preview() {
                return this.advert.preview;
            },
            price() {
                if(this.isPriceDiscuss) {
                    return 'Обсуждается'
                }

                return `${this.advert.price} Р`;
            },
            isPriceSpecific() {
                return this.advert.price_type === PRICE_TYPE_SPECIFIC
            },
            isPriceDiscuss() {
                return this.advert.price_type === PRICE_TYPE_DISCUSS
            },
            isShowButtonVisible() {
                return this.advert.left_request === false && this.isActive
            },
            isActive() {
                return this.advert.status === STATUS_ACTIVE
            },
            userRequest() {
                let request = this.advert.requests.filter(req => req.user_id === this.user.id);
                if(request.length === 0) {
                    return false;
                }
                return request[0]
            },
            isAcceptButtonVisible() {
                if(!this.advert.requests) {
                    return false;
                }

                let request = this.userRequest;
                if(!request) {
                    return false;
                }

                return request.customer_invite;
            },
            isRejectButtonVisible() {
                if(!this.advert.requests) {
                    return false;
                }

                let request = this.userRequest;
                if(!request) {
                    return false;
                }

                return request.customer_invite;
            }
        },

        methods: {
            showModal() {
                this.$store.commit('service/showModal', this.advert);
            },
            onCancel() {
                this.$emit('close')
            },
            onConfirm() {
                this.$emit('confirm')
            },
            onAccept() {
                axios.put(this.route('api.advert.request.accept', {id: this.advert.id}))
                    .then(res => {
                        let data = res.data;

                        if(!data.success || data.success !== true) {
                            alert(data.error);
                            return;
                        }

                        this.accepted = true;
                    })
                    .catch(err => {
                        console.log(err);
                        alert('Что-то пошло не так.');
                        this.rejected = true;
                    });
            },
            onReject() {
                axios.delete(this.route('api.advert.request.reject', {id: this.advert.id}))
                    .then(res => {
                        let data = res.data;

                        if(!data.success || data.success !== true) {
                            alert(data.error);
                            return;
                        }

                        this.rejected = true;
                    })
                    .catch(err => {
                        console.log(err);
                        alert('Что-то пошло не так.');
                        this.rejected = true;
                    })
            }
        }
    }
</script>

<style scoped>
    .offers-button {
        text-align: left;
    }
    .reaction-accepted {
        opacity: .5;
        border-left: 2px solid green;
    }
    .reaction-rejected {
        opacity: .5;
        border-left: 2px solid red;
    }
    .task-premium {
        color: #323232;
        border: 1px solid rgba(254, 198, 43, .5);
        background: rgba(254, 198, 43, 0.2);
    }
</style>
