<template>
    <div class="personal-portfolio-item">
        <div class="personal-portfolio-item-body" :style="{'background-image':`url(${preview})`}">
            <div class="album-controls">
                <button class="album-controls-btn" @click.prevent="onEdit">
                    <svg class="reduction-icon">
                        <use xlink:href="/images/sprite-inline.svg#reduction-icon"></use>
                    </svg>
                </button>
                <button class="album-controls-btn" @click.prevent="onDelete">
                    <svg class="rubbish-bin-delete-button">
                        <use xlink:href="/images/sprite-inline.svg#rubbish-bin-delete-button"></use>
                    </svg>
                </button>
            </div>
        </div>
        <div class="personal-portfolio-item-name">{{ title }}</div>
    </div>
</template>

<script>
    export default {
        props: ['item'],

        computed: {
            preview() {
                return this.item.preview
            },
            title() {
                return this.item.title
            }
        },

        methods: {
            onEdit() {
                window.location.href = this.route('cabinet.portfolio.edit', this.item.id)
            },
            onDelete() {
                if(!confirm('Are you really want to delete the gallery?')) {
                    return false;
                }

                axios.delete(this.route('api.user.cabinet.portfolio.destroy', this.item.id))
                    .then(res => {
                        this.setCommonMessage('Альбом успешно удалён.');
                        this.$emit('remove')
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
        }
    }
</script>

<style scoped>

</style>
