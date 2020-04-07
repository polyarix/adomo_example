<template>
    <div class="modal modal-take-task" style="display: none;" id="take-task-modal" v-if="isModalActive" ref="modal">
        <div class="modal-title">Хотите выполнить задачу?</div>
        <div class="modal-info-box">
            <p>{{ title }}</p>
            <a :href="route('user.details', {id: advert.author.id})" target="_blank">{{ authorName }}</a>
        </div>
        <form @submit.prevent>
            <div class="form-group">
                <label for="messsage">Дополните заявку (необязательно)</label>
                <textarea name="" id="messsage" placeholder="Заявки с описанием чаще получают отклик от заказчиков" v-model="message"></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-small btn-grey" @click="onCancel">Отмена</button>
                <button class="btn btn-small btn-yellow" @click="onConfirm">Отправить</button>
            </div>
        </form>
    </div>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        data() {
            return {
                message: ''
            }
        },

        computed: {
            ...mapState({
                advert: state => state.service.task,
                isModalActive: state => state.service.active,
            }),
            authorName() {
                return `${this.advert.author.first_name} ${this.advert.author.last_name}`
            },
            title() {
                return this.advert.title
            },
        },

        methods: {
            onCancel() {
                $.fancybox.close($(this.$refs.modal));
                this.$store.commit('service/hideModal');
                this.$emit('close')
            },
            onConfirm() {
                this.$emit('confirm', this.message)
            },
        },
        mounted() {
            this.$forceUpdate();
            $.fancybox.open($(this.$refs.modal), {
                beforeClose: () => {
                    this.$store.commit('service/hideModal');
                    this.$emit('close');
                    return true;
                }
            })
        },
        destroyed() {
            $.fancybox.close($(this.$refs.modal))
        }
    }
</script>

<style scoped>

</style>
