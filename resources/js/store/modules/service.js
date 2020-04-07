const state = {
    category: null,
    active: false,
    task: null
};

// getters
const getters = {
    isMainPageActive(state) {
        return Boolean(state.category) === false;
    },
    isSpecificFilterActive(state) {
        return Boolean(state.category) === true;
    }
};

// actions
const actions = {
};

// mutations
const mutations = {
    setMainPageActive(context) {
        context.category = null;
    },
    setCategory(context, id) {
        context.category = id;
    },
    showModal(context, advert) {
        context.task = advert;
        context.active = true;
    },
    hideModal(context) {
        context.task = null;
        context.active = false;
    },
    setSuccess(context) {
        context.task.left_request = true;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
