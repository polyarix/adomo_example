<template>
    <li class="attachments-item">
        <extension-preview :name="item.filename" />
        <a :href="route('api.user.cabinet.chat.attachment.view', item.id)">{{ name }}</a>
        <button class="remove" @click="$emit('remove')">X</button>
    </li>
</template>

<script>
    import ExtensionPreview from "../../../../Shared/File/ExtensionPreview";
    const MAX_NAME_LENGTH = 50;

    export default {
        props: ['item'],
        computed: {
            name() {
                return this.item.filename.length > MAX_NAME_LENGTH ? this.item.filename.substr(0, MAX_NAME_LENGTH) : this.item.filename
            },
            preview() {
                // return icon by mime type item.mime or item.filename -> extension
                return '/images/blank-file.svg'
            }
        },
        components: {ExtensionPreview},
    }
</script>

<style scoped>
    .preview {
        display: inline-block;
        width: 16px;
    }
    .remove {
        float: right;
    }
</style>
