<template>
    <div :class="messageClasses" :id="'message-' + message.id" :data-date="dataDate" :data-type="message.type">
        {{ message.message }}

        <div class="attachments" v-if="hasAttachments">
            <attachment v-for="attachment in message.attachments" :key="attachment.id" :attachment="attachment" />
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import Attachment from "./MessageAttachment";

    const TYPE_MESSAGE = 'message';
    const TYPE_SUCCESS_NOTIFICATION = 'success';
    const TYPE_WARNING_NOTIFICATION = 'warning';

    export default {
        props: ['message'],

        computed: {
            ...mapState('user', ['user']),
            ownMessage() {
                return this.message.sender.id === this.user.id
            },
            foreignMessage() {
                return this.message.sender.id !== this.user.id
            },
            sendError() {
                return this.message.send_error
            },
            time() {
                //return this.$moment(this.message.created_at).humanize()
                //return this.$moment(this.message.created_at).format("D MMMM");
                return this.$moment.max(this.message.created_at);
            },
            dataDate() {
                return this.$moment(this.message.created_at).format("DD.MM.YYYY HH:MM");
            },
            messageType() {
                if(!this.message.type) {
                    return 'default';
                }

                return this.message.type;
            },
            isDefaultMessage() {
                return !this.message.type || this.message.type === TYPE_MESSAGE;
            },
            messageClasses() {
                if(this.messageType !== TYPE_MESSAGE) {
                    return {
                       'message-system': true, 'message-outbox': this.ownMessage, 'message-inbox': this.foreignMessage
                    }
                }

                return {
                    'message': true,
                    'message-outbox': this.ownMessage,
                    'message-inbox': this.foreignMessage,
                    'not-sent': this.sendError,
                };
            },
            hasAttachments() {
                return this.message.attachments && this.message.attachments.length > 0
            }
        },
        components: {
            Attachment
        }
    }
</script>

<style scoped>
    .message {
        z-index: 1;
        flex-direction: column;
    }

    .message-system {
        padding: 20px;
        font-size: 14px;
        color: #323232;
    }

    .message-system[data-type=success] {
        background: #c5f4cb;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .message-system[data-type=info] {
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
