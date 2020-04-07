<template>
    <i :class="['fa', className]" />
</template>

<script>
    import getClassNameForExtension from 'font-awesome-filetypes';
    import '@fortawesome/fontawesome-free/css/all.min.css';

    export default {
        props: ['name'],

        computed: {
            className() {
                const filename = this.name;
                const extension = filename.split('.').pop();

                return getClassNameForExtension(extension);
            }
        }
    }
</script>

<style scoped>
.fa {
    opacity: .3;
}
</style>
