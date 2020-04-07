export default {
    computed: {
        csrfToken() {
            return window.axios.defaults.headers.common['X-CSRF-TOKEN'];
        },
    },
}
