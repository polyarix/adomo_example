<template>
    <div class="questionnaire-inner-container">
        <uploader
            v-model="files"
            :url="route('api.user.cabinet.verification.file.upload')"
            description="Загрузите сертификат"
            :limit="4"
            @on-change="onFileChange"
            @on-success="onSuccess"
            :params="{_token: csrfToken, type: TYPE_CERTIFICATE}"
            :quality="1"
        ></uploader>
    </div>
</template>

<script>
    import {TYPE_CERTIFICATE} from "../../../_partials/bar_constants";
    import Uploader from "../../../../../../helpers/Common/Uploader/Uploader";

    export default {
        props: ['uploaded'],

        data() {
            return {
                files: this.uploaded,
                TYPE_CERTIFICATE
            }
        },

        methods: {
            onChange(e) {
                if(this.files.length === 0) {
                    this.$emit('remove', this.file)
                }
            },
            onFileChange(file) {
                if(file.id !== undefined) {
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

</style>
