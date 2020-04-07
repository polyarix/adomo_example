<template>
<div class="chat">
    <threads :class="{'threads-hidden': !threadsActive}" />
    <history v-if="hasActiveThread" :class="{'history-hidden': !historyActive}" ref="history" />
</div>
</template>

<script>
    import Threads from "./Thread/Threads";
    import History from "./Chat/History";
    import {mapGetters, mapState, mapMutations} from 'vuex';

    export default {
        props: ['chat'],

        data() {
            return {
                init: false
            }
        },

        computed: {
            ...mapGetters('chat', ['hasActiveThread', 'threadsCount']),
            ...mapState('user', ['user']),
            ...mapState('chat', ['threadsSection', 'messagesSection']),

            threadsActive() {
                return this.threadsSection
            },
            historyActive() {
                return this.messagesSection
            }
        },

        methods: {
            ...mapMutations('chat', ['addMessage', 'pushMessage']),
        },

        components: {
            History,
            Threads
        },

        watch: {
            threadsCount() {
                if(this.chat || this.init) {
                    return;
                }
                this.init = true;
                this.$store.commit('chat/setActiveFirstThread');
                this.$store.commit('chat/setActiveMessagesSection');
            }
        },

        created() {
            if(this.chat) {
                // set active chat
                this.$store.commit('chat/setActiveThread', this.chat);
                this.$store.commit('chat/setActiveMessagesSection');
            }

            Echo.private(`user.${this.user.id}`)
                .listen('.user.message.sent', e => {
                    //if(is active conversation, push the message)

                    console.log('socket message', e.message);

                    this.pushMessage(e.message);
                    //this.$store.commit('chat/incrementUnseenCount', this.chat)

                    // TODO write this
                    // make notification
                    // search list of conversations and increment count of unread messages
                    // if the conversation is not exists, create new one...
                })
                //.listen('.mercurius.user.status.changed', user => this.onUserStatusChanged(user));
        },
    }
</script>

<style scoped>
    @media (max-width:1279.98px) {
        .threads-hidden {
            display: none;
        }
        .history-hidden {
            display: none;
        }
    }
</style>
