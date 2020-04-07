const state = {
    price: {
        from: null,
        to: null
    },
    date: '',
    city: window.city.id,
    district: '',
    onlyActive: false,
    loading: false,
};

// getters
const getters = {
    isLoading(state) {
        return state.loading === true;
    },
    formData(state) {
        return {
            price: state.price,
            date: state.date,
            city: state.city,
            district: state.district,
            active_only: state.onlyActive,
        };
    }
};

// actions
const actions = {

};

// mutations
const mutations = {
    setPriceFrom(context, value) {
        context.price.from = value;
    },
    setPriceTo(context, value) {
        context.price.to = value;
    },
    setDate(context, value) {
        context.date = value;
    },
    setCity(context, value) {
        context.city = value;
        context.district = '';
    },
    setDistrict(context, value) {
        context.district = value;
    },
    setActiveOnly(context, value) {
        context.onlyActive = value;
    },
    setLoading(context, value) {
        context.loading = value;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
