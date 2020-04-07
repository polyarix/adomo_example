import moment from "moment";
import {throttle} from 'lodash';

const state = {
    threads: [],
    active: null,
    messages: [],
    loading: false,

    page: 1,
    fetching: false,
    more: true,

    threadsSection: true,
    messagesSection: false,
};

// getters
const getters = {
    isLoading(state) {
        return state.loading === true;
    },
    hasActiveThread(state) {
        return state.active !== null;
    },
    threadsCount(state) {
        return state.threads.length;
    },
    activeConversationId(state) {
        return state.active && state.active.thread.conversation_id
    },
    filteredThreads(state) {
        let filtered = state.threads.filter(inbox => inbox.thread);

        return filtered.sort((a, b) => {
            if(a.thread && b.thread && moment(a.thread.updated_at).isAfter(b.thread.updated_at)) {
                return -1;
            } else {
                return 1;
            }
            return 0;
        });
    }
};

// actions
const actions = {
    fetchThreads(context) {
        //context.commit('clearMessages');

        if(context.state.fetching || !context.state.more) {
            return;
        }

        context.commit('setFetching', true);
        axios.get(window.route('api.user.cabinet.chat.threads', {page: context.state.page}))
            .then(res => {
                context.commit('setThreads', res.data.data);
                context.commit('incrementPage');
            })
            .finally(() => {
                context.commit('setFetching', false);
            })
    },
    fetchMessages(context) {
        axios.post(window.route('api.user.cabinet.chat.messages'), {conversation: context.getters.activeConversationId})
            .then(res => {
                context.commit('setMessages', res.data.data.messages)
            })
    },
    sendMessage(context, message) {
        axios.post(window.route('api.user.cabinet.chat.messages.store'), {
            conversation: context.getters.activeConversationId,
            message: message.message,
            attachments: message.attachments
        })
            .then(res => {
                context.commit('addMessage', res.data.data)
            })
            .catch(err => {
                console.log(err);

                context.commit('addMessage', {
                    id: undefined,
                    sender: {id: window.user.id, first_name: undefined, last_name: undefined},
                    message: message.message,
                    send_error: true
                })
            })
    },
    readMessages: throttle(function(context) {
        const conversationId = context.getters.activeConversationId;

        axios.post(window.route('api.user.cabinet.chat.read', conversationId))
            .then(res => {
                console.log('read');
                context.commit('clearUnseenMessagesCount', conversationId);
            })
            .catch(err => {
                console.log(err);
            })
    }, 2000)
};

// mutations
const mutations = {
    setFetching(state, value) {
        state.fetching = !!value;
    },
    incrementPage(state) {
        state.page++
    },
    setThreads(state, threads) {
        if(threads.length === 0) {
            state.more = false;
        }

        state.threads = state.threads.concat(threads)
    },
    setActiveThread(state, inbox) {
        state.active = inbox;
        state.messages = [];
    },
    setActiveFirstThread(state) {
        if(state.threads.length === 0) {
            return;
        }
        state.active = state.threads[0];
        state.messages = [];
    },
    setActiveMessagesSection(state) {
        state.messagesSection = true;
        state.threadsSection = false;
    },
    setActiveThreadsSection(state) {
        state.messagesSection = false;
        state.threadsSection = true;
    },
    clearUnseenMessagesCount(state, conversationId) {
        const conversation = state.threads.filter(conversation => conversation.thread && conversation.thread.conversation_id === conversationId);

        if(conversation.length === 0) {
            return;
        }

        conversation[0].unseen = 0;
    },
    setMessages(state, messages) {
        state.messages = messages.reverse();
    },
    removeExecutor(state) {
        state.active.order.executor_id = null;
    },
    // add own created message
    addMessage(state, message) {
        state.messages.push(message);

        const conversation = state.threads.filter(conversation => conversation.thread && conversation.thread.conversation_id === message.conversation.id);

        if(conversation.length === 0) {
            return;
        }

        conversation[0].thread.updated_at = moment().format('YYYY-MM-DD HH:mm:ss')
    },
    // push message got from websocket
    pushMessage(state, message) {
        console.log(message)

        const conversation = state.threads.filter(conversation => conversation.thread && conversation.thread.conversation_id === message.conversation.id);

        if(conversation.length === 0) {
            // created new conversation
            return;
        }

        conversation[0].unseen++;
        conversation[0].thread.updated_at = moment().format('YYYY-MM-DD HH:mm:ss');

        console.log('message to conversation ...', conversation);
        // if !conversation -> create new one.

        if(state.active && state.active.thread.conversation_id === message.conversation_id) {
            state.messages.push(message);
            //this.dispatch('chat/readMessages');
        }
    },
    clearMessages(state) {
        state.messages = []
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
