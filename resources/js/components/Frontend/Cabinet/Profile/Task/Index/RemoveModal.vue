<template>
    <div class="modal modal-remove-task" style="display: none;" id="modal-remove-task">
        <div class="modal-title">Удалить задачу?</div>
        <div class="modal-text">Это действие невозможно отменить</div>
        <div class="modal-footer">
            <button class="btn btn-big btn-grey" @click="onCancel">Отмена  </button>
            <button class="btn btn-big btn-yellow" @click="onConfirm">Да, удалить</button>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            onCancel() {
                $.fancybox.close($('#modal-remove-task'));
                this.$emit('close')
            },
            onConfirm() {
                this.$emit('confirm')
            }
        },
        mounted() {
            $.fancybox.open($('#modal-remove-task'))
        },
        destroyed() {
            $.fancybox.close($('#modal-remove-task'))
        }
    }
</script>

<style scoped>

</style>
