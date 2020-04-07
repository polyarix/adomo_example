import Vue from 'vue'
import Vuex from 'vuex'
import filter from './modules/filter'
import service from './modules/service'
import user from './modules/user'
import task from './modules/task'
import chat from './modules/chat'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        filter, service, user, task, chat
    },
    strict: debug,
    plugins: []
})
