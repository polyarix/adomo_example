const state = {
    category: null,
    active: false,
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
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
