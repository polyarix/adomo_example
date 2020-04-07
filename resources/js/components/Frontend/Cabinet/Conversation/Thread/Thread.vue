<template>
    <div class="chat-user" :class="{current: isActive}" @click.prevent="setActiveThread">
        <div class="chat-user-avatar">
            <img :src="avatar" alt="">
            <div class="status">
                <div class="status-offline"></div>
            </div>
        </div>
        <div class="chat-user-info" :data-date="dataTime">
            <template>
                <div class="chat-user-info-name" v-if="isForCompany">{{ inbox.company.name }}</div>
                <div class="chat-user-info-name" v-else>{{ inbox.withUser.first_name }} {{ inbox.withUser.last_name }}</div>
            </template>

            <div class="chat-user-info-task">{{ inbox.subject }}</div>
            <div class="chat-user-info-messages" v-if="inbox.unseen > 0">{{ inbox.unseen }}</div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex';

    export default {
        props: ['inbox'],

        computed: {
            ...mapState('user', ['user']),
            ...mapState('chat', ['active']),

            isOwnLastMessage() {
                return this.inbox.thread && this.user.id === this.inbox.thread.sender.id
            },
            humansTime() {
                const today = this.$moment();
                const createdAt = this.$moment(this.inbox.thread.updated_at);

                if (createdAt.diff(today, 'days') === 0) {
                    return createdAt.format('HH:mm');
                }

                return createdAt.format('DD.MM.YYYY')
            },
            dataTime() {
                const createdAt = this.$moment(this.inbox.thread.updated_at);

                return createdAt.format('DD.MM.YYYY')
            },
            avatar() {
                if(this.isForCompany && this.inbox.company.user_id !== this.user.id) {
                    return `/storage/${this.inbox.company.logo}`
                }

                return `/${this.inbox.withUser.avatar}`
            },
            isActive() {
                return this.active && this.active.thread && this.active.thread.conversation_id === this.inbox.thread.conversation_id
            },
            messagePreview() {
                return this.inbox.thread.message.substr(0, 20)
            },
            isByOrder() {
                return this.inbox.order && this.inbox.order.id
            },
            isForCompany() {
                return this.inbox.company && this.inbox.company.id
            },
            order() {
                return this.inbox.order
            },
        },

        methods: {
            setActiveThread() {
                if(this.isActive) {
                    return
                }

                const conversationId = this.inbox.thread.conversation_id;

                this.$router.push({ name: 'cabinet.conversation.show', params: { id: conversationId }});
                this.$store.commit('chat/setActiveThread', this.inbox);
                this.$store.commit('chat/clearUnseenMessagesCount', conversationId);
                this.$store.dispatch('chat/fetchMessages');

                this.$store.commit('chat/setActiveMessagesSection');
            }
        },

        mounted() {
            $(document).on('mousemove', '.chat-body-messages', e => {
                if(this.inbox.unseen > 0) {
                    // make request for read messages from active conversation
                    this.$store.dispatch('chat/readMessages')
                }
            })
        }
    }
</script>

<style scoped>
    .avatar {
        width: 25px
    }
    .unseen_count {
        background: darkorange;
        padding: 5px;
        border-radius: 30px;
        color: white;
        font-size: .8em;
        float: right;
        right: 0;
        top: 0;
        position: absolute;
    }
</style>
