<template>
    <div class="attachment-item">
        <extension-preview :name="attachment.filename" />

        <a :href="route('api.user.cabinet.chat.attachment.view', attachment.id)">{{ name }}</a>
    </div>
</template>

<script>
    const MAX_NAME_LENGTH = 50;

    import ExtensionPreview from "../../../../Shared/File/ExtensionPreview";

    export default {
        props: ['attachment'],

        computed: {
            name() {
                return this.attachment.filename.length > MAX_NAME_LENGTH ? this.item.attachment.substr(0, MAX_NAME_LENGTH) : this.attachment.filename
            },
            preview() {
                // return icon by mime type item.mime or item.filename -> extension
                return '/images/blank-file.svg'
            }
        },
        components: {
            ExtensionPreview
        }
    }
</script>

<style scoped>
    .attachment-item {
        margin-top: 10px;
        text-align: left;
    }
    .attachment-image {
        width: 16px;
        display: inline-block;
    }
</style>
