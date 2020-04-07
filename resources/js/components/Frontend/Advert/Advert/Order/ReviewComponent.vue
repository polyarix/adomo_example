<template>
    <div>
        <div class="alert alert-success" v-if="hasCommonMessage">{{ getCommonMessage }}</div>
        <div class="alert alert-danger" v-if="hasCommonError">{{ getCommonError }}</div>

        <customer-type v-if="isForExecutorType" @change="onGradeChange" />
        <executor-type v-else @change="onGradeChange" />

        <div class="add-comment">
            <div class="user-avatar">
                <img :src="avatar" alt=""/>
            </div>

            <textarea
                :class="{'add-comment-input': true, 'is-invalid': hasError('text')}"
                name="text"
                placeholder="Опишите свой опыт работы с данным исполнителем..."
                v-model="text"
            ></textarea>
        </div>

        <span class="invalid-feedback" role="alert" v-if="hasError('text')">
            <strong>{{ getError('text') }}</strong>
        </span>

        <div class="order-feedback-footer">
            <div class="form-check" v-if="isForExecutorType">
                <label for="agree">Рекомендую этого исполнителя
                    <input type="checkbox" id="agree" required="required" v-model="recommended" />
                    <span class="checkmark"></span>
                </label>
            </div>

            <button class="btn btn-big btn-yellow" @click="onSendReview">Отправить</button>
        </div>
    </div>
</template>

<script>
    import CustomerType from "./Review/CustomerType";
    import ExecutorType from "./Review/ExecutorType";
    import {mapState} from 'vuex';

    const TYPE_FOR_EXECUTOR = 'executor';
    const TYPE_FOR_CUSTOMER = 'customer';

    export default {
        props: ['order'],

        data() {
            return {
                text: '',

                recommended: true,

                quality: 1,
                professionalism: 1,
                punctuality: 1,
                grade: 1,
            }
        },

        computed: {
            ...mapState('user', ['user']),
            isAuthor() {
                return this.user.id === this.order.user_id
            },
            type() {
                return this.isAuthor ? TYPE_FOR_EXECUTOR : TYPE_FOR_CUSTOMER
            },
            isForExecutorType() {
                return this.type === TYPE_FOR_EXECUTOR
            },
            isForCustomerType() {
                return this.type === TYPE_FOR_CUSTOMER
            },
            avatar() {
                return `/storage/${this.user.photo}`
            }
        },

        methods: {
            onGradeChange(payload) {
                this[payload.key] = payload.value;
            },
            onSendReview() {
                this.clearErrorsBag();

                if(this.text.length === 0) {
                    this.addError('text', 'Вы не заполнили текст отзыва.');
                    return;
                }
                if(this.text.length < 3) {
                    this.addError('text', 'Количество символов отзыва должно быть больше 3.');
                    return;
                }

                let data = {};
                if(this.isForExecutorType) {
                    data.quality = this.quality;
                    data.professionalism = this.professionalism;
                    data.punctuality = this.punctuality;
                } else {
                    data.grade = this.grade;
                }
                data.text = this.text;

                axios.post(this.route('api.advert.order.review', this.order.slug), data)
                    .then(res => {
                        if(res.data.success === true) {
                            this.setCommonMessage('Отзыв о проекте успешно добавлен.');
                            window.location.href = this.route('advert.order.finish', {order: this.order.slug});

                            return;
                        }
                        console.log(res.data);
                        this.setCommonError('Ошибка добавления отзыва. Попробуйте ещё раз.');
                    })
                    .catch(err => {
                        this.setCommonError(err.message);

                        const response = err.response;

                        if(response.data.message !== undefined) {
                            this.setCommonError('Ошибка валидации');
                        }
                        if(response.status === 422) {
                            // validation error
                            for(let key in response.data.errors) {
                                this.addError(key, response.data.errors[key][0]);
                            }
                        }
                    })
            }
        },

        components: {
            CustomerType, ExecutorType
        }
    }
</script>

<style scoped>
    .is-invalid {
        border: 1px solid;
        border-color: #dc3545 !important;
    }
</style>
