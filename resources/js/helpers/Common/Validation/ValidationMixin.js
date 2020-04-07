const DEFAULT_TIMEOUT = 3000;

export default {
    data() {
        return {
            _errors: {},
            _common_error: '',
            _common_message: '',
        }
    },

    computed: {
        hasCommonError() {
            return this.$data._common_error && this.$data._common_error.length > 0;
        },
        getCommonError() {
            return this.$data._common_error;
        },
        getCommonMessage() {
            return this.$data._common_message;
        },
        hasCommonMessage() {
            return this.$data._common_message && this.$data._common_message.length > 0;
        },
    },

    methods: {
        setCommonError(error, timeout = null) {
            this.$vs.notify({
                title: 'Ошибка',
                text: error,
                color:'danger',
                position:'top-right',
                time: timeout ? timeout : DEFAULT_TIMEOUT
            });

            this.$data._common_message = '';
            this.$data._common_error = error;

            if(timeout) {
                setTimeout(() => {
                    this.$data._common_error = '';
                }, timeout)
            }
        },
        setCommonMessage(message, timeout = null) {
            this.$vs.notify({
                title: 'Успешно выполнено.',
                text: message,
                color:'success',
                position:'top-right',
                time: timeout ? timeout : DEFAULT_TIMEOUT
            });

            this.$data._common_error = null;
            this.$data._common_message = message;

            if(timeout) {
                setTimeout(() => {
                    this.$data._common_message = '';
                }, timeout)
            }
        },
        clearErrorsBag() {
            this.$data._errors = {};
            this.$data._common_error = '';
        },
        clearBag() {
            this.$data._errors = {};
            this.$data._common_error = '';
            this.$data._common_message = '';
        },
        addError(key, value) {
            this.$data._errors[key] = value;
        },
        hasError(key) {
            return this.$data._errors[key] && this.$data._errors[key] !== undefined;
        },
        getError(key) {
            return this.$data._errors[key];
        },
        isValid() {
            if(Object.keys(this.$data._errors).length > 0) {
                return false;
            }
            return true;
        },
        isError(key) {
            return this.getError(key) !== undefined
        },
    }
}
