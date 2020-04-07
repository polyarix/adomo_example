<template>
    <div class="category-task-container">
        <!-- modal Ошибка-->
        <div class="modal modal-message" style="display: none;" id="error-modal">
            <div class="modal-message-inner">
                <div class="modal-message-icon" @click="onCloseModal"><img src="/images/error-icon.svg" alt=""/></div>
                <div class="modal-message-text">
                    <div class="modal-title">Ошибка</div>
                    <p>Попробуйте позже</p>
                </div>
            </div>
        </div>
        <!-- modal /Ошибка-->
        <!-- modal Успех-->
        <div class="modal modal-message" style="display: none;" id="success-modal">
            <div class="modal-message-inner">
                <div class="modal-message-icon"><img src="/images/success-icon.svg" alt=""/></div>
                <div class="modal-message-text">
                    <div class="modal-title">Заявка отправлена</div>
                    <p>Ожидайте ответ заказчика в чате </p>
                </div>
            </div>
        </div>
        <!-- /modal -->

        <perform-modal v-if="isModalActive" @confirm="onConfirm" />

        <div>
            <div>
                <task v-for="premiumTask in premium" :advert="premiumTask" :key="premiumTask.id" />
            </div>

            <div>
                <task v-for="task in tasks" :advert="task" :key="task.id" />
            </div>

            <div v-if="isLoading">
                <div class="filter-loader"><img style="margin: 15px auto;" src="/images/ajax-loader.gif" alt=""></div>
            </div>

            <button class="btn btn-small btn-white" v-if="canShowMore" @click.prevent="showMore()">Показать еще</button>
        </div>
    </div>
</template>

<script>
    import { mapState, mapActions, mapGetters, mapMutations } from 'vuex'
    import Task from "./Task";
    import PerformModal from "./PerformModal";

    export default {
        components: {PerformModal, Task},
        props: ['category', 'url', 'withButton', 'premium'],

        data() {
            return {
                loading: true,
                canShowMore: false,
                tasks: [],
                page: 1,
            }
        },

        computed: {
            isLoading() {
                return this.loading === true;
            },
            ...mapState({
                price: state => state.filter.price,
                date: state => state.filter.date,
                city: state => state.filter.city,
                district: state => state.filter.district,
                onlyActive: state => state.filter.onlyActive,
                isModalActive: state => state.service.active,
                advert: state => state.service.task,
            }),
            ...mapGetters({formData: 'filter/formData'})
        },

        watch: {
            price: {
                deep: true,
                handler() {
                    this.applyFilter()
                },
            },
            date() {
                this.applyFilter()
            },
            city() {
                this.applyFilter()
            },
            onlyActive() {
                this.applyFilter()
            },
            district() {
                this.applyFilter()
            }
        },

        methods: {
            onCloseModal() {
                console.log('close')
            },
            onConfirm(message) {
                axios.post(this.route('api.advert.task.offer'), {id: this.advert.id, message: message})
                    .then(res => {
                        if(res.data.success) {
                            this.$store.commit('service/setSuccess');

                            $.fancybox.close( $('#take-task-modal'));
                            // set timeout it's fix, because follow code close success modal too...
                            setTimeout(() => {
                                $.fancybox.open( $('#success-modal'));
                            }, 10);
                            return;
                        }

                        $.fancybox.open( $('#error-modal'))
                    })
                    .catch(err => {
                        $.fancybox.open( $('#error-modal'))
                    })
                    .finally(() => {
                        /*this.$store.commit('service/hideModal');
                        $.fancybox.close($('#take-task-modal'));*/
                    })
            },
            applyFilter: _.debounce(function() {
                this.setLoading(true);
                this.page = 1;
                this.tasks = [];
                this.canShowMore = true;

                this.showMore()
            }, 1000),
            showMore() {
                let formData = this.formData;
                formData['category'] = this.category ? this.category.id : null;
                formData['page'] = this.page;

                this.page++;
                this.loading = true;
                this.setLoading(true);

                axios.post(this.url, formData)
                    .then(res => {
                        this.tasks = this.tasks.concat(res.data.data);
                        this.canShowMore = res.data.are_more;

                        this.loading  = false;
                        this.setLoading(false);
                    });
            },
            onFilter() {

            },
            ...mapMutations({
                setLoading: 'filter/setLoading',
                hideModal: 'service/hideModal',
            })
        },

        created() {
            this.showMore()
        }
    }
</script>

<style scoped>

</style>
