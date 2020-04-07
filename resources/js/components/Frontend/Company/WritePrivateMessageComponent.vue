<template>
    <div>
        <a class="btn btn-large btn-yellow" @click="onDisplayModal">{{ action }}</a>

        <div class="modal modal-take-task" style="display: none;" id="send-pm-modal" ref="modal">
            <div class="modal-title">{{ header }}</div>
            <div class="modal-info-box">
                Компания
                <a :href="route('company.show', company.slug)" target="_blank">{{ company.name }}</a>
            </div>
            <form @submit.prevent>
                <div class="form-group">
                    <label for="subject">Тема сообщения</label>
                    <input placeholder="Тема сообщения" type="text" name="subject" id="subject" v-model="subject" class="subject-input" :class="{ 'is-invalid': isError('subject') }">

                    <span class="invalid-feedback" role="alert" v-if="isError('subject')">
                        <strong>{{ getError('subject') }}</strong>
                    </span>
                </div>

                <div class="form-group">
                    <label for="messsage">Текст сообщения</label>
                    <textarea name="" id="messsage" placeholder="Текст сообщения" v-model="message" :class="{ 'is-invalid': isError('message') }"></textarea>

                    <span class="invalid-feedback" role="alert" v-if="isError('message')">
                        <strong>{{ getError('message') }}</strong>
                    </span>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-small btn-grey" @click="onCancel">Отмена</button>
                    <button class="btn btn-small btn-yellow" @click="onConfirm" :disabled="!sendButtonVisible">Отправить</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            company: {type: Object, required: true},
            action: {type: String, default: 'Написать сообщение'},
            header: {type: String, default: 'Предложение работы'},
        },

        data() {
            return {
                subject: '',
                message: '',
            }
        },

        computed: {
            sendButtonVisible() {
                return this.subject.length > 0 && this.message.length > 0
            }
        },

        methods: {
            onDisplayModal() {
                $.fancybox.open($(this.$refs.modal), {
                    beforeClose: () => {
                        return true;
                    }
                })
            },
            onCancel() {
                $.fancybox.close($(this.$refs.modal));
            },
            onConfirm() {
                this.clearErrorsBag();

                if(this.subject.length === 0) {
                    this.addError('subject', 'Не заполнена тема.');
                }
                if(this.message.length === 0) {
                    this.addError('message', 'Не заполнено сообщение.');
                }

                if(!this.isValid()) {
                    this.setCommonError('Не заполнены обязательные поля.', 2000);

                    return false;
                }

                this.clearBag();

                axios.post(this.route('api.user.cabinet.chat.create_company'), {
                    subject: this.subject, message: this.message, company: this.company.id
                }).then(res => {
                    if(res.data.success === true) {
                        const dialogUrl = this.route('cabinet.chat.index', res.data.data.id);

                        this.setCommonMessage(`Вы успешно создали диалог. Перейти можете по <a href="${dialogUrl}" target="_blank">этой ссылке</a>`, 4000);
                        this.subject = '';
                        this.message = '';

                        $.fancybox.close($(this.$refs.modal));

                        return;
                    }

                    this.setCommonError('Ошибка отправки запроса. Повторите ещё раз.')
                }).catch(err => {
                    let data = err.response.data;

                    this.setCommonError(data.message);
                    for(let key in data.errors) {
                        this.addError(key, data.errors[key][0]);
                    }
                })
            },
        }
    }
</script>

<style scoped>
    .subject-input {
        height: 38px;
    }
    button:disabled {
        opacity: .5;
        cursor: not-allowed;
    }
</style>
