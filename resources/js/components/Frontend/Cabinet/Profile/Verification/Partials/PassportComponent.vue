<template>
    <div class="questionnaire-inner-container">
        <!-- mixin vux-uploader -->
        <uploader
            v-model="files"
            :readonly="isReadOnly"
            :url="route('api.user.cabinet.verification.file.upload')"
            description="Загрузите документы"
            :limit="1"
            @on-fileList-change="onChange('passport', $event)"
            @on-success="onSuccess"
            :params="{_token: csrfToken, type: TYPE_PASSPORT}"
            :quality="1"
        >
            <div slot="image-label" :class="{
                'document-status': true,
                'success': isVerified,
                'rejected': isRejected,
                'moderation': !isVerified && !isRejected
            }" v-if="message">{{ message }}</div>
        </uploader>

        <!-- / mixin vux-uploader -->
        <div class="form-input-description text offset-top">Загрузите фото с открытым паспортом в руках. Откройте первую страницу паспорта, данные должны быть отчетливо видны.</div>
    </div>
</template>

<script>
    import {TYPE_PASSPORT} from "../../../_partials/bar_constants";
    import Uploader from "../../../../../../helpers/Common/Uploader/Uploader";

    const VERIFIED_STATUS = 'verified';
    const REJECTED_STATUS = 'rejected';

    export default {
        props: ['file'],

        data() {
            return {
                files: [],
                TYPE_PASSPORT
            }
        },

        computed: {
            isReadOnly() {
                return this.file && (this.file.status === 'verified')
            },
            isVerified() {
                return this.file.status === VERIFIED_STATUS
            },
            isRejected() {
                return this.file.status === REJECTED_STATUS
            },
            message() {
                if(this.isRejected) {
                    return this.file.reject_reason
                }
                if(this.isVerified) {
                    return 'Документ успешно проверен'
                }
                return 'На проверке'
            }
        },

        created() {
            if(this.file && this.file.id !== undefined) {
                this.files.push(this.file)
            }
        },

        methods: {
            onChange(e) {
                if(this.files.length === 0) {
                    this.$emit('remove', this.file.id)
                }
            },
            onSuccess(e) {
                console.log('success')
            }
        },

        components: {
            Uploader
        }
    }
</script>

<style scoped>
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
