<template>
    <div class="chat-body-header">
        <div class="current-chat">
            <div class="current-chat-avatar"><img :src="avatar" alt=""></div>
            <div class="current-chat-info">
                <template>
                    <a class="current-chat-info-task" :href="route('advert.order.show', order.slug)" v-if="isByOrder">{{ order.title }}</a>
                    <a class="current-chat-info-task" :href="route('company.show', thread.company.slug)" v-else-if="isForCompany">
                        <span v-if="amICompanyOwner">Обращение по компании:</span>
                        <span v-else>Компания:</span>
                        {{ company.name }}
                    </a>
                    <a class="current-chat-info-task" :href="route('user.details', thread.withUser.id)" v-else>{{ thread.subject }}</a>
                </template>

                <template>
                    <div class="current-chat-info-name" v-if="isForCompany && !amICompanyOwner">{{ thread.subject }}</div>
                    <div class="current-chat-info-name" v-else>{{ sender.first_name }} {{ sender.last_name }}</div>
                </template>
            </div>
        </div>

        <button class="btn btn-small btn-yellow" @click.prevent="onConfirm" v-if="isOrderExecutor && isWaitingResponse">Принять предложение</button>
        <button class="btn btn-small btn-white" @click.prevent="refuseRequest" v-if="isOrderExecutor && canRefuse">Отклонить предложение</button>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import OrderWrapper from "../../../../../helpers/Advert/OrderWrapper";

    export default {
        computed: {
            ...mapState({thread: state => state.chat.active}),
            ...mapState('user', ['user']),
            isForCompany() {
                return this.thread.company && this.thread.company.id
            },
            company() {
                return this.thread.company
            },
            amICompanyOwner() {
                return this.company && this.company.user_id === this.user.id
            },
            avatar() {
                if(this.isForCompany && this.company.user_id !== this.user.id) {
                    return `/storage/${this.company.logo}`
                }
                return `/${this.sender.avatar}`
            },
            isByOrder() {
                return this.thread.order && this.thread.order.id
            },
            order() {
                return this.thread.order
            },
            isOrderExecutor() {
                return this.order && this.order.executor_id === this.user.id
            },
            orderWrapper() {
                return new OrderWrapper(this.order)
            },
            sender() {
                return this.thread.withUser
            },
            canRefuse() {
                return this.order && this.orderWrapper.isActive() && this.isOrderExecutor
            },
            isWaitingResponse() {
                if(!this.order) {
                    return false;
                }

                let request = this.order.requests.filter(req => req.user_id === this.user.id);
                if(request.length > 0) {
                    request = request[0];

                    console.log(request)
                }

                return this.isOrderExecutor && this.orderWrapper.isActive()
            }
        },

        methods: {
            onConfirm() {
                axios.put(this.route('api.advert.request.accept', {id: this.order.id}))
                    .then(res => {
                        let data = res.data;

                        if(!data.success || data.success !== true) {
                            alert(data.error);
                            return;
                        }

                        this.$store.commit('chat/addMessage', data.data);
                        // hide buttons
                        this.$store.commit('chat/removeExecutor');
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            refuseRequest() {
                axios.delete(this.route('api.advert.request.reject', {id: this.order.id}))
                    .then(res => {
                        let data = res.data;

                        if(!data.success || data.success !== true) {
                            alert(data.error);
                            return;
                        }

                        this.$store.commit('chat/addMessage', data.data);
                        this.$store.commit('chat/removeExecutor');
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
        }
    }
</script>

<style scoped>

</style>
