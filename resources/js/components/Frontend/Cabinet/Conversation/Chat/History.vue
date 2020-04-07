<template>
    <div class="chat-body" style="display: block">
        <button class="back-to-all" @click="onSetActiveThreadsSection"><span>Все сообщения</span></button>

        <history-header />

        <vue-scroll class="chat-body-messages bar-content" ref="vs" style="height: calc(100% - 75px - 90px)">
            <chat-message v-for="message in messages" :message="message" />

            <div v-if="isTyping" class="loading_dots" style="width: 100%; text-align:center">
                <span>{{ typingName }} печатает</span>
                <i></i>
                <i></i>
                <i></i>
            </div>
        </vue-scroll>

        <chat-form @scrollDown="scrollDown"/>
    </div>
</template>

<script>
    import ChatMessage from "./Message";
    import HistoryHeader from "./Header";
    import ChatForm from "./Form";
    import {mapState, mapGetters} from 'vuex';

    export default {
        data() {
            return {
                typing: false,
                typingName: '',
                step: 1,
            }
        },

        computed: {
            ...mapState('chat', ['messages']),
            ...mapGetters('chat', ['activeConversationId']),
            isTyping() {
                return this.typing
            }
        },

        methods: {
            disableTyping: _.debounce(function(e) {
                this.typing = false;
                console.log('disabled typing')
            }, 2000),

            scrollDown() {
                this.$refs['vs'].scrollTo({y: '100%'}, 100, 'easeInQuad');
            },

            onSetActiveThreadsSection() {
                this.$store.commit('chat/setActiveThreadsSection');
                this.$router.push('/cabinet/chat');
            }
        },

        updated() {
            this.$refs['vs'].scrollTo({y: '100%'}, 100, 'easeInQuad');
        },

        mounted() {
            setTimeout(() => {
                this.scrollDown()
            }, 1000)
        },

        created() {
            this.$store.dispatch('chat/fetchMessages');

            const conversationId = this.$store.getters['chat/activeConversationId'];

            Echo.private(`user.conversation.${conversationId}`)
                .listenForWhisper('typing', (e) => {
                    this.typing = true;
                    this.typingName = e.name;
                    this.disableTyping();
                })
        },

        watch: {
            activeConversationId(value, old) {
                this.typing = false;

                Echo.leave(`user.conversation.${old}`);

                Echo.private(`user.conversation.${value}`)
                    .listenForWhisper('typing', (e) => {
                        this.typing = true;
                        this.typingName = e.name;
                        this.disableTyping();
                    })
            }
        },

        components: {
            ChatMessage, ChatForm, HistoryHeader
        }
    }
</script>

<style>
    .chat-body-messages {
        height: calc(100% - 75px - 90px);
        border-top: 1px solid #d8d8d8;
        display: flex;
        flex-direction: column;
        padding: 25px 10px;
    }

    .__panel.__hidebar {
        height: 100%;
        overflow: hidden scroll;
    }

    .chat-body-messages .__view {
        padding: 25px 10px;
        display: flex;
        flex-direction: column;
        box-shadow: inset 1px 2px 7px 0 #d2d2d2;
    }

    .loading_dots > span {
        font-size: .8em;
        opacity: .5;
    }
    .loading_dots {
        display: inline-block;
        font-size: 1em;
        line-height: 1;
        padding: .125em 0 .175em .15em
    }

    .loading_dots i {
        border: .125rem solid;
        border-radius: 50%;
        display: inline-block;
        height: .2rem;
        width: .2rem;
        margin-left: .2rem;
        -webkit-animation: loading_dots .8s linear infinite;
        -moz-animation: loading_dots .8s linear infinite;
        -ms-animation: loading_dots .8s linear infinite;
        animation: loading_dots .8s linear infinite
    }

    .loading_dots i:nth-child(2) {
        -webkit-animation-delay: .2s;
        -moz-animation-delay: .2s;
        -ms-animation-delay: .2s;
        animation-delay: .2s
    }

    .loading_dots i:nth-child(3) {
        -webkit-animation-delay: .4s;
        -moz-animation-delay: .4s;
        -ms-animation-delay: .4s;
        animation-delay: .4s
    }

    @-webkit-keyframes loading_dots {
        0% {opacity: 0}
        50% {opacity: 1}
        100% {opacity: 0}
    }

    @-moz-keyframes loading_dots {
        0% {opacity: 0}
        50% {opacity: 1}
        100% {opacity: 0}
    }

    @-ms-keyframes loading_dots {
        0% {opacity: 0}
        50% {opacity: 1}
        100% {opacity: 0}
    }

    @keyframes loading_dots {
        0% {opacity: 0}
        50% {opacity: 1}
        100% {opacity: 0}
    }
</style>
