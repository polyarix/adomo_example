<template>
    <div class="questionnaire-inner-container">
        <uploader
            v-model="files"
            :url="route('api.user.cabinet.verification.file.upload')"
            description="Загрузить файл"
            :limit="4"
            @on-change="onFileChange"
            @on-success="onSuccess"
            :params="{_token: csrfToken, type: TYPE_JURISTIC}"
            :quality="1"
        >
            <div slot="image-label" :class="{
                'document-status': true,
                'success': isSuccess(props.item.status),
                'rejected': isRejected(props.item.status),
                'moderation': !isSuccess(props.item.status) && !isRejected(props.item.status)
            }" slot-scope="props">
                {{ getStatusMessage(props.item) }}
            </div>
        </uploader>
    </div>
</template>

<script>
    import {TYPE_JURISTIC} from "../../../_partials/bar_constants";
    import Uploader from "../../../../../../helpers/Common/Uploader/Uploader";

    const VERIFIED_STATUS = 'verified';
    const REJECTED_STATUS = 'rejected';

    export default {
        props: ['uploaded'],

        data() {
            return {
                files: this.uploaded,
                TYPE_JURISTIC
            }
        },

        methods: {
            getStatusMessage(item) {
                const status = item.status;
                if(status === REJECTED_STATUS) {
                    return item.reject_reason
                }
                if(status === VERIFIED_STATUS) {
                    return 'Документ успешно проверен'
                }
                return 'На проверке'
            },
            isSuccess(status) {
                return status === VERIFIED_STATUS
            },
            isRejected(status) {
                return status === REJECTED_STATUS
            },
            handleItemStatus(item) {
                console.log(item)
            },
            onChange(e) {
                if(this.files.length === 0) {
                    this.$emit('remove', this.file)
                }
            },
            onFileChange(file) {
                if(file.id !== undefined) {
                    if(file.status === 'verified') {
                        this.files.push(file);
                        this.setCommonError('Нельзя удалить уже проверенный документ.');
                        return false
                    }
                    this.$emit('remove', file.id)
                }
            },
            onSuccess(e, file) {
                // add timeout, because we listen onChange event and delete file by id.
                // If make it immediate, it triggers same behavior like delete
                setTimeout(() => {file.id = e.data.id;}, 100)
            }
        },

        components: {
            Uploader
        }
    }
</script>

<style scoped>
    .moderation {
        text-align: center;
        color: white;
        background: rgba(255,127,80, .8);
    }
    .document-status {
        position: absolute;
        padding: 10px;
        width: 100%;
        bottom: 0;
        font-size: 0.7em;
        font-weight: bold;
    }
    .success {
        text-align: center;
        color: #1f2d3d;
        background: rgba(197, 222, 205, 0.8);
    }
    .rejected {
        text-align: center;
        color: darkred;
        background: rgba(250, 201, 184, 0.8);
    }
</style>
