<template>
    <div class="chat-body-write">
        <div class="chat-body-write-message">
            <label class="input-area">
                <textarea
                    name=""
                    placeholder="Напишите сообщение..."
                    class="input-area_input"
                    v-model="message"
                    @keyup="onTyping"
                    @keyup.ctrl.enter="onSend"
                />
            </label>

            <div class="files">
                <div class="files__container" :class="{open: filesListOpen}" v-if="attachments.length > 0">
                    <div class="files__container-toggle" @click="filesListOpen = !filesListOpen">Прикрепленные файлы</div>
                    <div class="files__container-list">
                        <div class="file-item" v-for="(attachment, index) in attachments">
                            <div class="file-item__name" :title="`${attachment.filename}.${attachment.extension}`">
                                {{ attachment.filename }}.{{ attachment.extension }}
                            </div>
                            <button class="file-item__remove" @click="onRemoveAttachment(index)">×</button>
                        </div>
                    </div>
                </div>
                <label class="input-file">
                    <div class="input-file-icon"></div>
                    <input :disabled="attachments.length > 3" id="attachments" type="file" @change="onAttachmentsChange" ref="input">
                </label>
            </div>

            <button class="message-submit" @click.prevent="onSend" :disabled="message.length === 0" />
        </div>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex';
    import FormAttachment from "./FormAttachment";

    const FILE_NAME_LIMIT = 25;

    import Vue from 'vue';
    import Tooltip from 'vue-directive-tooltip';
    import 'vue-directive-tooltip/dist/vueDirectiveTooltip.css';
    Vue.use(Tooltip);

    export default {
        data() {
            return {
                message: '',
                attachments: [],
                filesListOpen: true
            }
        },

        computed: {
            ...mapState('user', ['user']),
            ...mapGetters('chat', ['activeConversationId']),
            avatar() {
                return `/storage/${this.user.photo}`
            },
            hasAttachments() {
                return this.attachments.length > 0
            },
            attachmentIds() {
                return this.attachments.map(el => el.id)
            },
            attachmentsTooltip() {
                if(!this.hasAttachments) {
                    return 'Выберите файлы, которые хотите приложить к письму.'
                }

                return this.attachments.map(el => {
                    let [name, extension] = el.filename.split('.');
                    if(name.length > 30) {
                        name = name.substr(0, 30) + '...'
                    }

                    return `${name}.${extension}`
                }).join("<br>")
            }
        },
        methods: {
            getFilename(filename) {
                return filename.length > FILE_NAME_LIMIT ? filename.substr(0, FILE_NAME_LIMIT) + '...' : filename
            },
            onSend() {
                this.$store.dispatch('chat/sendMessage', {message: this.message, attachments: this.attachmentIds});
                this.attachments = [];
                this.message = '';
            },
            onTyping() {
                console.log('typing');

                const conversationId = this.$store.getters['chat/activeConversationId'];

                Echo.private(`user.conversation.${conversationId}`)
                    .whisper('typing', {
                        name: this.user.first_name
                    });
            },
            onRemoveAttachment(index) {
                this.attachments.splice(index, 1)
            },
            onAttachmentsChange(e) {
                const target = e.target || e.srcElement;
                const inputChangeFiles = target.files;

                if (inputChangeFiles.length  === 0) {
                    console.log('cancel')
                    return
                }

                Array.prototype.map.call(inputChangeFiles, file => {
                    //this.loaderVisible = true;

                    let data = new FormData();
                    data.append('attachment', file);

                    axios.post(this.route('api.user.cabinet.chat.attachment'), data, {
                        headers: {'Content-Type': 'multipart/form-data'}
                    })
                        .then(result => {
                            this.attachments.push(result.data.data);
                        }).catch(err => {
                            if(err.response && err.response.data && err.response.data.errors) {
                                const errors = err.response.data.errors;
                                alert(errors[Object.keys(errors)][0])
                            }

                            console.log(err)
                        }).finally(() => {
                            //this.loaderVisible = false;
                            this.$refs.input.value = null;
                        });
                })
            }
        },

        watch: {
            activeConversationId() {
                this.message = '';
            }
        },

        components: {
            FormAttachment
        }
    }
</script>

<style scoped>
.add-comment {
    background: white;
}
.attach-button {
    margin: 0 19px;
}
.attach-button:hover {
    cursor: pointer;
}
.attachments {
    background: #fff;
    text-align: left;
    padding: 8px;
    font-size: .9em;
}
.attachments-item:not(:last-child) {
    border-bottom: 1px dashed silver;
    margin-bottom: 5px;
}
.attachments .remove {
    float: right;
    margin-right: 15px;
}
</style>
